<?php
namespace App\Controller;

use App\Database\Enum\ActivityTypeAppEnum;
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
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(string $event_id)
    {
        $event = $this->Activities->Events->get($event_id);

        if (!$event->isOwner($this->Auth->User('id'))) {
            $this->Flash->error(__('You dont own that event'));
            return $this->redirect(['action' => 'index']);
        }

        $activity = $this->Activities->newEntity();
        $activity->event_id = $event_id;

        if ($this->request->is('post')) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }

        $panelists = $this->Activities->Panelists->find('list', ['limit' => 200]);
        $themes = $this->Activities->Themes->find('list', ['limit' => 200]);
        $eventPlaces = $this->Activities->EventPlaces->find('list', ['limit' => 200]);
        $type = ActivityTypeAppEnum::getConstants(true);

        $this->set(compact('activity', 'type', 'panelists', 'themes', 'eventPlaces'));
        $this->set('_serialize', ['activity']);
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
    
    public function types()
    {
        $this->request->allowMethod(['get']);
        $types = ActivityTypeEnum::getConstants(true);
        $this->set(compact('types'));
        $this->set('_serialize', ['types']);
    }
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
