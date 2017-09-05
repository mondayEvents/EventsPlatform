<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Exception\BadRequestException;
use Cake\Http\ServerRequest;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
abstract class AppController extends Controller
{

    /**
     * @var string $response_code
     */
     private $response_code;
     
         /**
          * @var array $response_message
          */
         private $response_message;
     
         /**
          * Initialization hook method.
          * Use this method to add common initialization code like loading components.
          *
          * @return void
          */
    public function initialize()
    {
        parent::initialize();

        $this->setResponseCode(200);
        $this->setResponseMessage([]);

        $this->loadComponent('Acl.Acl');
        $this->loadComponent('RequestHandler');

        $this->loadComponent('Auth',
            [
                'storage' => 'Memory',
                'authenticate' => [
                    'Form' => [
                        'scope' => ['Users.active' => 1]
                    ],
                    'ADmad/JwtAuth.Jwt' => [
                        'parameter' => 'token',
                        'userModel' => 'Users',
                        'contain' => [],
                        'scope' => ['Users.deleted IS NUll'],
                        'fields' => [
                            'username' => 'id',
                        ],
                        'queryDatasource' => false
                    ]
                ],
                'authorize' => [
                    'Acl.Actions' => ['actionPath' => 'controllers']
                ],
                'unauthorizedRedirect' => false,
                'checkAuthIn' => 'Controller.initialize'
            ]
        );
    }

   
    /**
     * @return string
     */
     public function getResponseCode(): string
     {
         return $this->response_code;
     }
 
     /**
      * @param string $responseCode
      */
     public function setResponseCode(string $responseCode)
     {
         $this->response_code = $responseCode;
     }
 
     /**
      * @return array
      */
     public function getResponseMessage(): array
     {
         return $this->response_message;
     }
 
     /**
      * @param array $message
      */
     public function setResponseMessage(array $message)
     {
         $this->response_message = $message;
     }
 
     /**
      * Wrapper method for serializing responses
      *
      * @return void
      */
     public function buildResponse()
     {
         $this->response->statusCode($this->getResponseCode());
 
         $serialize = array_keys($this->getResponseMessage());
         extract($this->getResponseMessage());
 
         $this->set(compact($serialize));
         $this->set('_serialize', $serialize);
     }
}
