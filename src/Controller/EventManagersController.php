<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EventManagers Controller
 *
 * @property \App\Model\Table\EventManagersTable $EventManagers
 *
 * @method \App\Model\Entity\EventManager[] paginate($object = null, array $settings = [])
 */
class EventManagersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Events', 'Users']
        ];
        $eventManagers = $this->paginate($this->EventManagers);

        $this->set(compact('eventManagers'));
        $this->set('_serialize', ['eventManagers']);
    }

    /**
     * View method
     *
     * @param string|null $id Event Manager id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $eventManager = $this->EventManagers->get($id, [
            'contain' => ['Events', 'Users']
        ]);

        $this->set('eventManager', $eventManager);
        $this->set('_serialize', ['eventManager']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $eventManager = $this->EventManagers->newEntity();
        if ($this->request->is('post')) {
            $eventManager = $this->EventManagers->patchEntity($eventManager, $this->request->getData());
            if ($this->EventManagers->save($eventManager)) {
                $this->Flash->success(__('The event manager has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event manager could not be saved. Please, try again.'));
        }
        $events = $this->EventManagers->Events->find('list', ['limit' => 200]);
        $users = $this->EventManagers->Users->find('list', ['limit' => 200]);
        $this->set(compact('eventManager', 'events', 'users'));
        $this->set('_serialize', ['eventManager']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Event Manager id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $eventManager = $this->EventManagers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $eventManager = $this->EventManagers->patchEntity($eventManager, $this->request->getData());
            if ($this->EventManagers->save($eventManager)) {
                $this->Flash->success(__('The event manager has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event manager could not be saved. Please, try again.'));
        }
        $events = $this->EventManagers->Events->find('list', ['limit' => 200]);
        $users = $this->EventManagers->Users->find('list', ['limit' => 200]);
        $this->set(compact('eventManager', 'events', 'users'));
        $this->set('_serialize', ['eventManager']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Event Manager id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $eventManager = $this->EventManagers->get($id);
        if ($this->EventManagers->delete($eventManager)) {
            $this->Flash->success(__('The event manager has been deleted.'));
        } else {
            $this->Flash->error(__('The event manager could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
