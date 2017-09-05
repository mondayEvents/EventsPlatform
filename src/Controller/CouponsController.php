<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * Coupons Controller
 *
 * @property \App\Model\Table\CouponsTable $Coupons
 *
 * @method \App\Model\Entity\Coupon[] paginate($object = null, array $settings = [])
 */
class CouponsController extends AppController
{

    
    public function add()
    {
        $this->request->allowMethod(['post']);
        
                try {
                    $event = $this->Coupons->Events->get($event_id, ['contain' => ['Users']]);
                    $coupon = $this->Coupons->newEntity($this->request->getData());
                    $user = $this->Coupons->Events->Users->get($this->Auth->user('uid'));
        
                    $event->setCoupon($coupon, $user);
                    $this->Coupons->Events->saveOrFail($event);
        
                    $this->setResponseMessage(['message' => ['_success' => __("Your coupon was created!")]]);
        
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
