<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * Companies Controller
 *
 * @property \App\Model\Table\CompaniesTable $Companies
 *
 * @method \App\Model\Entity\Company[] paginate($object = null, array $settings = [])
 */
class CompaniesController extends AppController
{


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);
        
                try {
                    $event = $this->Companies->Events->get($event_id, ['contain' => ['Users']]);
                    $user = $this->Companies->Events->Users->get($this->Auth->user('uid'));
        
                    $company = $this->Companies->newEntity($this->request->getData());
                    $event->setCompany($company, $user);
        
                    $this->Companies->Events->saveOrFail($event);
                    $this->setResponseMessage(compact('company'));
        
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
