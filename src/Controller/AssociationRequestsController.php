<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AssociationRequests Controller
 *
 * @property \App\Model\Table\AssociationRequestsTable $AssociationRequests
 *
 * @method \App\Model\Entity\AssociationRequest[] paginate($object = null, array $settings = [])
 */
class AssociationRequestsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Events', 'Parent']
        ];
        $associationRequests = $this->paginate($this->AssociationRequests);

        $this->set(compact('associationRequests'));
        $this->set('_serialize', ['associationRequests']);
    }

    /**
     * View method
     *
     * @param string|null $id Association Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $associationRequest = $this->AssociationRequests->get($id, [
            'contain' => ['Users', 'Events', 'Parent']
        ]);

        $this->set('associationRequest', $associationRequest);
        $this->set('_serialize', ['associationRequest']);
    }

    /**
     * @param string $asked_event_id
     */
    function requestAssociation ($asked_event_id = null)
    {
        $this->request->allowMethod(['post']);

        $events = $this->AssociationRequests->Events
            ->find()
            ->where(['Events.id IN' => [$asked_event_id, $this->request->getData('event_id')]])
            ->limit(2)
            ->toArray();

        if (count($events) < 2) {
            $error = ['message' => __('One of the events could not be found. Please, verify the your IDs')];
            $this->response(400, compact('error'));
            return;
        }

        $index = (array_column($events, 'id')[0] == $asked_event_id) ? 0 : 1;
        $event_asked = $events[$index];
        $event_asker = $events[!$index];

        $ownsBoth = $this->AssociationRequests->Events
            ->ownershipChecker($events);

        if ($ownsBoth)
        {
            $wasSaved = $this->AssociationRequests->Events->AdditionalEvents
                ->associateEvents($event_asked, $event_asker);

            if (!$wasSaved) {
                $error = $wasSaved;
                $this->response(400, compact('error'));
                return;
            }

            $message = ['_created' => __('Your events are now related')];
            $this->response(200, compact('message'));
            return;
        }

        $data = ['active' => true, 'message' => $this->request->getData('message')];
        $associationRequest = $this->AssociationRequests->newEntity($data);

        $associationRequest->user = $this->AssociationRequests->Users
            ->get($this->Auth->user('uid'), ['contain'=>[]]);

        $associationRequest->event = $event_asker;
        $associationRequest->event_parent = $event_asked;

        $saved = $this->AssociationRequests->save($associationRequest, ['associated' => [
            'Users', 'Events', 'EventParents']
        ]);

        if (!$saved) {
            $error = $associationRequest->getErrors();
            $this->response(400, compact('error'));
            return;
        }

        $message = ['_sent' => __('Your association request is waiting for approval!')];
        $this->response(200, compact('message'));
    }
}
