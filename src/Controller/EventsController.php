<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\AssociationRequest;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
            'conditions' => ['Events.published' => 1]
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
        $activity_associations = ['Speakers', 'EventPlaces', 'Tracks'];
        $event = $this->Events->get($id,
            ['contain' =>
                [
                    'Users',
                    'Coupons',
                    'SubEvents' => ['Activities' => $activity_associations],
                    'Registrations',
                    'Sponsorships',
                    'Activities' => $activity_associations
                ]
            ]
        );

        $is_owner = $event->isOwner($this->Auth->user('id'));

        $this->set(compact('event','is_owner'));
        $this->set('_serialize', ['is_owner', 'event']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void|null Renders JSON response.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);

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
