<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Sponsorships Controller
 *
 * @property \App\Model\Table\SponsorshipsTable $Sponsorships
 *
 * @method \App\Model\Entity\Sponsorship[] paginate($object = null, array $settings = [])
 */
class SponsorshipsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Events', 'Companies']
        ];
        $sponsorships = $this->paginate($this->Sponsorships);

        $this->set(compact('sponsorships'));
        $this->set('_serialize', ['sponsorships']);
    }

    /**
     * View method
     *
     * @param string|null $id Sponsorship id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sponsorship = $this->Sponsorships->get($id, [
            'contain' => ['Events', 'Companies']
        ]);

        $this->set('sponsorship', $sponsorship);
        $this->set('_serialize', ['sponsorship']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sponsorship = $this->Sponsorships->newEntity();
        if ($this->request->is('post')) {
            $sponsorship = $this->Sponsorships->patchEntity($sponsorship, $this->request->getData());
            if ($this->Sponsorships->save($sponsorship)) {
                $this->Flash->success(__('The sponsorship has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sponsorship could not be saved. Please, try again.'));
        }
        $events = $this->Sponsorships->Events->find('list', ['limit' => 200]);
        $companies = $this->Sponsorships->Companies->find('list', ['limit' => 200]);
        $this->set(compact('sponsorship', 'events', 'companies'));
        $this->set('_serialize', ['sponsorship']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sponsorship id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sponsorship = $this->Sponsorships->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sponsorship = $this->Sponsorships->patchEntity($sponsorship, $this->request->getData());
            if ($this->Sponsorships->save($sponsorship)) {
                $this->Flash->success(__('The sponsorship has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sponsorship could not be saved. Please, try again.'));
        }
        $events = $this->Sponsorships->Events->find('list', ['limit' => 200]);
        $companies = $this->Sponsorships->Companies->find('list', ['limit' => 200]);
        $this->set(compact('sponsorship', 'events', 'companies'));
        $this->set('_serialize', ['sponsorship']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sponsorship id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sponsorship = $this->Sponsorships->get($id);
        if ($this->Sponsorships->delete($sponsorship)) {
            $this->Flash->success(__('The sponsorship has been deleted.'));
        } else {
            $this->Flash->error(__('The sponsorship could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
