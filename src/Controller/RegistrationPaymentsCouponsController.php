<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RegistrationPaymentsCoupons Controller
 *
 * @property \App\Model\Table\RegistrationPaymentsCouponsTable $RegistrationPaymentsCoupons
 *
 * @method \App\Model\Entity\RegistrationPaymentsCoupon[] paginate($object = null, array $settings = [])
 */
class RegistrationPaymentsCouponsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['RegistrationPayments', 'Coupons']
        ];
        $registrationPaymentsCoupons = $this->paginate($this->RegistrationPaymentsCoupons);

        $this->set(compact('registrationPaymentsCoupons'));
        $this->set('_serialize', ['registrationPaymentsCoupons']);
    }

    /**
     * View method
     *
     * @param string|null $id Registration Payments Coupon id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $registrationPaymentsCoupon = $this->RegistrationPaymentsCoupons->get($id, [
            'contain' => ['RegistrationPayments', 'Coupons']
        ]);

        $this->set('registrationPaymentsCoupon', $registrationPaymentsCoupon);
        $this->set('_serialize', ['registrationPaymentsCoupon']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $registrationPaymentsCoupon = $this->RegistrationPaymentsCoupons->newEntity();
        if ($this->request->is('post')) {
            $registrationPaymentsCoupon = $this->RegistrationPaymentsCoupons->patchEntity($registrationPaymentsCoupon, $this->request->getData());
            if ($this->RegistrationPaymentsCoupons->save($registrationPaymentsCoupon)) {
                $this->Flash->success(__('The registration payments coupon has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The registration payments coupon could not be saved. Please, try again.'));
        }
        $registrationPayments = $this->RegistrationPaymentsCoupons->RegistrationPayments->find('list', ['limit' => 200]);
        $coupons = $this->RegistrationPaymentsCoupons->Coupons->find('list', ['limit' => 200]);
        $this->set(compact('registrationPaymentsCoupon', 'registrationPayments', 'coupons'));
        $this->set('_serialize', ['registrationPaymentsCoupon']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Registration Payments Coupon id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $registrationPaymentsCoupon = $this->RegistrationPaymentsCoupons->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $registrationPaymentsCoupon = $this->RegistrationPaymentsCoupons->patchEntity($registrationPaymentsCoupon, $this->request->getData());
            if ($this->RegistrationPaymentsCoupons->save($registrationPaymentsCoupon)) {
                $this->Flash->success(__('The registration payments coupon has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The registration payments coupon could not be saved. Please, try again.'));
        }
        $registrationPayments = $this->RegistrationPaymentsCoupons->RegistrationPayments->find('list', ['limit' => 200]);
        $coupons = $this->RegistrationPaymentsCoupons->Coupons->find('list', ['limit' => 200]);
        $this->set(compact('registrationPaymentsCoupon', 'registrationPayments', 'coupons'));
        $this->set('_serialize', ['registrationPaymentsCoupon']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Registration Payments Coupon id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $registrationPaymentsCoupon = $this->RegistrationPaymentsCoupons->get($id);
        if ($this->RegistrationPaymentsCoupons->delete($registrationPaymentsCoupon)) {
            $this->Flash->success(__('The registration payments coupon has been deleted.'));
        } else {
            $this->Flash->error(__('The registration payments coupon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
