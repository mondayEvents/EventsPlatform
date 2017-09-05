<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Strategy\Registrations\TotalByEventStrategy;

/**
 * Registrations Controller
 *
 * @property \App\Model\Table\RegistrationsTable $Registrations
 *
 * @method \App\Model\Entity\Registration[] paginate($object = null, array $settings = [])
 */
class RegistrationsController extends AppController
{

    /**
     * List all registration for event with pagination
     *
     * @param string $event_id
     * @return \Cake\Http\Response|void
     */
    public function list($event_id = null)
    {
        $this->request->allowMethod(['get']);

        try {
            $this->paginate = [
                'contain' => ['Events' => [
                    'conditions' => [
                        'Events.user_id' => $this->Auth->user('uid'),
                        'Events.id' => $event_id
                    ]
                ], 'Users']
            ];

            $registrations = $this->paginate($this->Registrations);
            $this->setResponseMessage(compact('registrations'));

        } catch (\Exception $exception) {
            $this->setResponseCode(500);
            $this->setResponseMessage(['message' => ['_error' => $exception->getMessage()]]);
        }

        $this->buildResponse();
    }

    /**
     * View method
     *
     * @param string|null $registration_id Registration id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($registration_id = null)
    {
        $this->request->allowMethod(['get']);

        try {
            $registration = $this->Registrations->get($registration_id, [
                'contain' => ['Events', 'Users', 'RegistrationItems']
            ]);
            $this->setResponseMessage(compact('registration'));

        } catch (\Exception $exception) {
            $this->setResponseCode(500);
            $this->setResponseMessage(['message' => ['_error' => $exception->getMessage()]]);
        }

        $this->buildResponse();
    }

    /**
     * Add method
     *
     * @param string $event_id
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add ($event_id)  // TODO: testar se funciona com cupon automatico e individual
    {
        $this->request->allowMethod(['post']);

        try {
            $event = $this->Registrations->Events->viewDetails($event_id);
            $registration = $this->Registrations->newEntity();
            $items = ($event->pay_by_activity) ? $event->matchActivity($this->request->getData('registration_items')) : $event->getAllActivitiesAvailable();
            $registration->registration_items = $this->Registrations->RegistrationItems->setEntities($items);
            $user = $this->Registrations->Users->get($this->Auth->user('uid'));
            $payment = $this->Registrations->RegistrationPayments->newEntity();

            $user_coupons = [];
            if (!empty($this->request->getData('coupons'))) {
                $user_coupons = $this->Registrations->Events->Coupons
                    ->findValidCoupons($event->id, $this->request->getData('coupons'));
            }

            $registration->newRegistration($event, $items, $payment, $user, $user_coupons);

            $registration = $this->Registrations->Events->saveOrFail($event, [
                'associated' => [
                    'Registrations' => [
                        'RegistrationPayments',
                        'RegistrationPaymentsCoupons'
                    ],
                ]
            ]);

            $this->setResponseMessage(compact('registration'));

        } catch (\Exception $exception) {
            $this->setResponseCode(500);
            $this->setResponseMessage(['message' => ['_error' => $exception->getMessage()]]);
        }

        $this->buildResponse();
    }

    /**
     * Accept method
     *
     * @param string|null $registration_id Registration id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function accept($registration_id = null)
    {
        $this->request->allowMethod(['get']);

        try {
            $user = $this->Registrations->Users->get($this->Auth->user('uid'), ['contain' => []]);
            $registration = $this->Registrations->get($registration_id, [
                'contain' => ['Events' => ['Users'],'RegistrationPayments']
            ]);

            $registration->acceptPayment($user);
            $registration = $this->Registrations->saveOrFail($registration, ['associated' => ['RegistrationPayments']]);

            $this->setResponseMessage(compact('registration'));

        } catch (\Exception $exception) {
            $this->setResponseCode(500);
            $this->setResponseMessage(['message' => ['_error' => $exception->getMessage()]]);
        }

        $this->buildResponse();


    }

    /**
     * Delete method
     *
     * @param string|null $id Registration id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $registration = $this->Registrations->get($id);
        if ($this->Registrations->delete($registration)) {
            $this->Flash->success(__('The registration has been deleted.'));
        } else {
            $this->Flash->error(__('The registration could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
