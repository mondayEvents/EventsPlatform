<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * Tracks Controller
 *
 * @property \App\Model\Table\TracksTable $Tracks
 *
 * @method \App\Model\Entity\Track[] paginate($object = null, array $settings = [])
 */
class TracksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($event_id)
    {
        $this->request->allowMethod(['get']);

        try {
            $tracks = $this->Tracks->find()
                ->where(['Tracks.event_id' => $event_id])
                ->innerJoin('Events', ['Events.user_id' => $this->Auth->user('uid')])
                ->all();

            $this->setResponseMessage(compact('tracks'));

        } catch (\Exception $exception) {
            $this->setResponseCode(500);
            $this->setResponseMessage(['message' => ['_error' => $exception->getMessage()]]);
        }

        $this->buildResponse();
    }

    /**
     * Add method
     * @param string $event_id
     */
    public function add($event_id)
    {
        try {
            $coordinators = $this->request->getData('coordinators');
            if (!is_array($coordinators)) {
                throw new \Exception(__('Invalid Coordinators format'));
            }

            $event = $this->Tracks->Events->get($event_id, ['contain' => ['Users']]);
            $owner = $this->Tracks->Events->Users->get($this->Auth->user('uid'));

            $data = $this->request->getData();
            unset($data['coordinators']);
            $track = $this->Tracks->newEntity($data);

            $coordinators = $this->Tracks->Events->Users->find()->where(['Users.id IN' => $coordinators])->first();
            $track->setManagers($coordinators);


            $event->setTrack($track, $owner);
            $track = $this->Tracks->Events->saveOrFail($event);

            $this->setResponseMessage(compact('track'));

        } catch (PersistenceFailedException $exception) {
            $this->setResponseCode(406);
            $this->setResponseMessage(['error' => $exception->getEntity()->getErrors()]);

        } catch (\Exception $exception) {
            $this->setResponseCode(500);
            $this->setResponseMessage(['message' => ['_error' => $exception->getMessage()]]);
        }

        $this->buildResponse();
    }
}
