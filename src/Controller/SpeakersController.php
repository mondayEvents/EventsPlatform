<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Speakers Controller
 *
 * @property \App\Model\Table\SpeakersTable $Speakers
 *
 * @method \App\Model\Entity\Speaker[] paginate($object = null, array $settings = [])
 */
class SpeakersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $speakers = $this->paginate($this->Speakers);

        $this->set(compact('speakers'));
        $this->set('_serialize', ['speakers']);
    }

    /**
     * View method
     *
     * @param string|null $id Speaker id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $speaker = $this->Speakers->get($id, [
            'contain' => []
        ]);

        $this->set('speaker', $speaker);
        $this->set('_serialize', ['speaker']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $speaker = $this->Speakers->newEntity();
        if ($this->request->is('post')) {
            $speaker = $this->Speakers->patchEntity($speaker, $this->request->getData());
            if ($this->Speakers->save($speaker)) {
                $this->Flash->success(__('The speaker has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The speaker could not be saved. Please, try again.'));
        }
        $this->set(compact('speaker'));
        $this->set('_serialize', ['speaker']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Speaker id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $speaker = $this->Speakers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $speaker = $this->Speakers->patchEntity($speaker, $this->request->getData());
            if ($this->Speakers->save($speaker)) {
                $this->Flash->success(__('The speaker has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The speaker could not be saved. Please, try again.'));
        }
        $this->set(compact('speaker'));
        $this->set('_serialize', ['speaker']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Speaker id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $speaker = $this->Speakers->get($id);
        if ($this->Speakers->delete($speaker)) {
            $this->Flash->success(__('The speaker has been deleted.'));
        } else {
            $this->Flash->error(__('The speaker could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
