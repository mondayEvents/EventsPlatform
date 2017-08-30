<?php
namespace App\Controller;

use App\Database\Enum\ActivityTypeEnum as ActivityType;
use App\Controller\AppController;
use App\Model\Entity\Activity;

/**
 * Activities Controller
 *
 * @property \App\Model\Table\ActivitiesTable $Activities
 *
 * @method \App\Model\Entity\Activity[] paginate($object = null, array $settings = [])
 */
class ActivitiesController extends AppController
{

    /**
     * Initialize Controller
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['types']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Events', 'Panelists', 'Themes', 'EventPlaces']
        ];
        $activities = $this->paginate($this->Activities);

        $this->set(compact('activities'));
        $this->set('_serialize', ['activities']);
    }

    /**
     * View method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activity = $this->Activities->get($id, [
            'contain' => ['Events', 'Panelists', 'Themes', 'EventPlaces', 'ActivityPlaces', 'Concomitance', 'RegistrationItems']
        ]);

        $this->set('activity', $activity);
        $this->set('_serialize', ['activity']);
    }

    /**
     * Add method
     *
     * @param $event_id
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When event not found.
     */
    public function add(string $event_id)
    {

        $this->request->allowMethod(['post']);

        $event = $this->Activities->Events->get($event_id);
        if (!$event->isOwner($this->Auth->user('uid'))) {
            $error = ["_notification" => __("Sorry, but you do not own this event")];
            $this->response(400, compact('error'));
            return;
        }

        $activity = $this->Activities->newEntity();
        $activity->event_id = $event->id;
        $activity = $this->Activities->patchEntity($activity, $this->request->getData());

        if (isset($activity->event_place))
        {
            $activity->event_place->event_id = $event->id;
        }

        if (!$this->Activities->save($activity)) {
            $error = $activity->getErrors();
            $this->response(400, compact('error'));
            return;
        }

        $this->set(compact('activity'));
        $this->set('_serialize', ['activity']);
    }

    public function types ()
    {
        $this->request->allowMethod(['get']);

        $types = ActivityType::getConstants(true);

        $this->set(compact('types'));
        $this->set('_serialize', ['types']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activity = $this->Activities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $events = $this->Activities->Events->find('list', ['limit' => 200]);
        $panelists = $this->Activities->Panelists->find('list', ['limit' => 200]);
        $themes = $this->Activities->Themes->find('list', ['limit' => 200]);
        $eventPlaces = $this->Activities->EventPlaces->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'events', 'panelists', 'themes', 'eventPlaces'));
        $this->set('_serialize', ['activity']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activity = $this->Activities->get($id);
        if ($this->Activities->delete($activity)) {
            $this->Flash->success(__('The activity has been deleted.'));
        } else {
            $this->Flash->error(__('The activity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}