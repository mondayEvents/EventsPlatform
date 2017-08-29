<?php
namespace App\Controller;

use App\Controller\AppController;
use Exception;
use Cake\Event\Event;
use App\Database\Enum\EventTypeEnum as EventType;

/**
 * Events Controller
 *
 * @property \App\Model\Table\EventsTable $Events

 * @method \App\Model\Entity\Event[] paginate($object = null, array $settings = [])
 */
class EventsController extends AppController
{

    /**
     * Initialize Controller
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['index', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $this->paginate = [
            'contain' => ['Users']
        ];
        $events = $this->paginate($this->Events);

        $this->set(compact('events'));
        $this->set('_serialize', ['events']);
    }

    /**
     * View method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' =>
                [
                    'Users',
                    'Coupons',
                    'AdditionalEvents' => [
                        'Events' => [
                            'Activities' =>[
                                'Speakers',
                                'EventPlaces',
                                'Tracks'
                            ]
                        ]
                    ],
                    'Registrations',
                    'Sponsorships',
                    'Activities' =>[
                        'Speakers',
                        'EventPlaces',
                        'Tracks'
                    ]
                ]
        ]);

        $is_owner = $event->isOwner($this->Auth->user('id'));

        $this->set(compact('event','is_owner'));
        $this->set('_serialize', ['is_owner', 'event']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $event = $this->Events->newEntity();
        $event->user_id = $this->Auth->user('id');

        if ($this->request->is('post')) {
            $event = $this->Events->patchEntity($event, $this->request->getData());
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event could not be saved. Please, try again.'));
        }

        $type = EventTypeAppEnum::getConstants(true);

        $this->set(compact('event', 'type'));
        $this->set('_serialize', ['event']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     * @throws \Exception When ownership isnt valid.
     */
    public function edit($id = null)
    {

        $event = $this->Events->get($id, [
            'contain' => ['EventManagers']
        ]);

        if (!$event->isOwner($this->Auth->User('id'))) {
            $this->Flash->error(__('You dont own that event'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $event = $this->Events->patchEntity($event, $this->request->getData());
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event could not be saved. Please, try again.'));
        }

        $users = $this->Events->Users->find('list', ['limit' => 200]);
        $this->set(compact('event', 'users'));
        $this->set('_serialize', ['event']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $event = $this->Events->get($id);
        if ($this->Events->delete($event)) {
            $this->Flash->success(__('The event has been deleted.'));
        } else {
            $this->Flash->error(__('The event could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * List all events types for
     * selecting porpuses
     *
     * @return \Cake\Http\Response|void|null Renders JSON response.
     */
    public function types ()
    {
        $this->request->allowMethod(['get']);

        $types = EventType::getConstants(true);
        $this->response(200, compact('types'));
    }
    
}
