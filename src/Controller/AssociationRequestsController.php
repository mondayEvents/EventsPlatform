<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * AssociationRequests Controller
 *
 * @property \App\Model\Table\AssociationRequestsTable $AssociationRequests
 *
 * @method \App\Model\Entity\AssociationRequest[] paginate($object = null, array $settings = [])
 */
class AssociationRequestsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->request->allowMethod(['get']);
        $pendingAssociations = $this->AssociationRequests->getAssociationRequests($this->Auth->user('uid'));

        $this->setResponseMessage(compact('pendingAssociations'));
        $this->buildResponse();
    }

    /*
    * Accept pending association request
    *
    * @param string|null $request_id Association Request id.
    * @return \Cake\Http\Response|void
    */
   public function accept($request_id = null)
   {
       $this->request->allowMethod(['get']);

       try {

           $request = $this->AssociationRequests->get($request_id,
               ['contain' => ['Events' => ['EventManagers'], 'Users']]
           );

           $manager = $this->AssociationRequests->Events->EventManagers->newEntity();
           $user = $this->AssociationRequests->Users->get($this->Auth->user('uid'));
           $manager->user = $user;

           $request->acceptEventAssociation($manager);

           $this->AssociationRequests->saveOrFail($request, [
               'associated' => ['Events' => ['ParentEvents','EventManagers'], 'Users']
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
     * Decline pending association request
     *
     * @param string|null $request_id Association Request id.
     * @return \Cake\Http\Response|void
     */
     public function decline($request_id = null)
     {
         $this->request->allowMethod(['get']);
 
         try {
             $request = $this->AssociationRequests->get($request_id);
             $request->declineEventAssociation();
             $this->AssociationRequests->saveOrFail($request);
 
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
      * @param string $asked_event_id
      */
     function requestAssociation ($asked_event_id = null)
     {
         $this->request->allowMethod(['post']);
 
         try {
             $user = $this->AssociationRequests->Users->get($this->Auth->user('uid'));
             $sub_event = $this->AssociationRequests->Events->get($this->request->getData('event_id'), ['contain' => ['Users']]);
             $event = $this->AssociationRequests->Events->get($asked_event_id, ['contain' => ['Users']]);
 
             $request = $this->AssociationRequests->newEntity();
 
             $request->setAssociationRequest($user, $event, $sub_event, $this->request->getData('event_id'));
             $this->AssociationRequests->saveOrFail($request);
 
             $this->setResponseMessage(['message' => ['_success' => __("Your request was sent!")]]);
 
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
