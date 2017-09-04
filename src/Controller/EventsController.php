<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Contract\HttpClientInterface;
use App\Model\Entity\AssociationRequest;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\Entity;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use Exception;
use Cake\Event\Event;
use App\Database\Enum\EventTypeEnum as EventType;
use App\Database\Enum\EventStatusEnum as EventStatus;
/**
 * Events Controller
 *
 * @property \App\Model\Table\EventsTable $Events
 * @method \App\Model\Entity\Event[] paginate($object = null, array $settings = [])
 */
class EventsController extends AppController
{
 /**
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['index','view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
            'conditions' => [
                'Events.status IN' => [
                    EventStatus::getNameByValue(EventStatus::NEW),
                    EventStatus::getNameByValue(EventStatus::OPEN)
                ]
            ]
        ];

        $this->setResponseMessage(['events' => $this->paginate($this->Events)]);
        $this->buildResponse();
    }

  /**
     * View method
     *
     * @param string|null $event_id Event id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($event_id = null)
    {
        $this->request->allowMethod(['get']);

        try {
            $event = $this->Events->viewDetails($event_id);
            $is_owner = false;

            if ($this->Auth->user('uid')) {
                $user = $this->Events->Users->get($this->Auth->user('uid'));
                $is_owner = $event->isOwnedBy($user);
            }

            $this->setResponseMessage(compact('event','is_owner'));

        } catch (PersistenceFailedException $exception) {
            $this->setResponseCode(406);
            $this->setResponseMessage(['error' => $exception->getEntity()->getErrors()]);

        } catch (\Exception $exception) {
            $this->setResponseCode(500);
            $this->setResponseMessage(['message' => ['_error' => $exception->getMessage()]]);
        }

        $this->buildResponse();
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|void|null Renders JSON response.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);

        try {
            $event = $this->Events->newEntity($this->request->getData());
            $event->user = $this->Events->Users->get($this->Auth->user('uid'));
            $event->tags = $this->Events->Tags->find()
                ->where(['Tags.id IN' => (array) $this->request->getData('tags')])
                ->select(['id','name'])
                ->toList();

            $event = $this->Events->saveOrFail($event);
            $this->setResponseMessage(compact('event'));

        } catch (PersistenceFailedException $exception) {
            $this->setResponseCode(406);
            $this->setResponseMessage(['error' => $exception->getEntity()->getErrors()]);

        } catch (\Exception $exception) {
            $this->setResponseCode(500);
            $this->setResponseMessage(['message' => ['_error' => $exception->getMessage()]]);
        }

        $this->buildResponse();
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
