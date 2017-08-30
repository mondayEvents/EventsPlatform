<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RegistrationItems Controller
 *
 * @property \App\Model\Table\RegistrationItemsTable $RegistrationItems
 *
 * @method \App\Model\Entity\RegistrationItem[] paginate($object = null, array $settings = [])
 */
class RegistrationItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Registrations', 'Activities']
        ];
        $registrationItems = $this->paginate($this->RegistrationItems);

        $this->set(compact('registrationItems'));
        $this->set('_serialize', ['registrationItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Registration Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $registrationItem = $this->RegistrationItems->get($id, [
            'contain' => ['Registrations', 'Activities']
        ]);

        $this->set('registrationItem', $registrationItem);
        $this->set('_serialize', ['registrationItem']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $registrationItem = $this->RegistrationItems->newEntity();
        if ($this->request->is('post')) {
            $registrationItem = $this->RegistrationItems->patchEntity($registrationItem, $this->request->getData());
            if ($this->RegistrationItems->save($registrationItem)) {
                $this->Flash->success(__('The registration item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The registration item could not be saved. Please, try again.'));
        }
        $registrations = $this->RegistrationItems->Registrations->find('list', ['limit' => 200]);
        $activities = $this->RegistrationItems->Activities->find('list', ['limit' => 200]);
        $this->set(compact('registrationItem', 'registrations', 'activities'));
        $this->set('_serialize', ['registrationItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Registration Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $registrationItem = $this->RegistrationItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $registrationItem = $this->RegistrationItems->patchEntity($registrationItem, $this->request->getData());
            if ($this->RegistrationItems->save($registrationItem)) {
                $this->Flash->success(__('The registration item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The registration item could not be saved. Please, try again.'));
        }
        $registrations = $this->RegistrationItems->Registrations->find('list', ['limit' => 200]);
        $activities = $this->RegistrationItems->Activities->find('list', ['limit' => 200]);
        $this->set(compact('registrationItem', 'registrations', 'activities'));
        $this->set('_serialize', ['registrationItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Registration Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $registrationItem = $this->RegistrationItems->get($id);
        if ($this->RegistrationItems->delete($registrationItem)) {
            $this->Flash->success(__('The registration item has been deleted.'));
        } else {
            $this->Flash->error(__('The registration item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
