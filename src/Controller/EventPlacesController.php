<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * EventPlaces Controller
 *
 * @property \App\Model\Table\EventPlacesTable $EventPlaces
 *
 * @method \App\Model\Entity\EventPlace[] paginate($object = null, array $settings = [])
 */
class EventPlacesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Events']
        ];
        $eventPlaces = $this->paginate($this->EventPlaces);

        $this->set(compact('eventPlaces'));
        $this->set('_serialize', ['eventPlaces']);
    }

    /**
     * View method
     *
     * @param string|null $id Event Place id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $eventPlace = $this->EventPlaces->get($id, [
            'contain' => ['Events']
        ]);

        $this->set('eventPlace', $eventPlace);
        $this->set('_serialize', ['eventPlace']);
    }


    public function add($event_id = null)
    {
        $this->request->allowMethod(['post']);

        try {
            $place = $this->EventPlaces->addEventPlace($this->Auth->user('uid'), $event_id, $this->request->getData());
            $this->setResponseMessage([
                'event_place' => [
                    'id' => $place->id,
                    'event_id' => $place->event_id,
                    'parent_id' => $place->parent_id,
                    'name' => $place->name
                ]
            ]);

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
     * Edit method
     *
     * @param string|null $id Event Place id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $eventPlace = $this->EventPlaces->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $eventPlace = $this->EventPlaces->patchEntity($eventPlace, $this->request->getData());
            if ($this->EventPlaces->save($eventPlace)) {
                $this->Flash->success(__('The event place has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event place could not be saved. Please, try again.'));
        }
        $events = $this->EventPlaces->Events->find('list', ['limit' => 200]);
        $this->set(compact('eventPlace', 'events'));
        $this->set('_serialize', ['eventPlace']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Event Place id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $eventPlace = $this->EventPlaces->get($id);
        if ($this->EventPlaces->delete($eventPlace)) {
            $this->Flash->success(__('The event place has been deleted.'));
        } else {
            $this->Flash->error(__('The event place could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
