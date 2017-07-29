<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Exception\Exception;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize () {
        parent::initialize();

        $this->Auth->allow(
            [
                'index',
                'token',
                'forgotPassword',
                'resetPassword',
                'initDB'
            ]
        );
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $user = $this->Users->newEntity();
        $user->set("name",'asdasdasd');
        echo $user->get('name');
        dd($user);

        $this->paginate = [
            'contain' => ['Groups']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * Signup method
     * Creates new user profile via password
     * TODO: signup with facebook token
     *
     * @param string|null
     * @return response 200|202|422
     */
    public function signup($provider = null)
    {
        $this->request->allowMethod('post');

        if($provider === 'facebook') {
           // Do something...
        }

        $user = $this->Users->newEntity();
        $user = $this->Users->patchEntity($user, $this->request->data(),
            [
                'accessibleFields' => ['username' => true, 'password' => true],
                'associated' => ['Details'],
                'validate' => true
            ]
        );

        $userRecurrence = $this->Users->Recurrences->newEntity();
        $userRecurrence->succeeded_orders = 0;
        $userRecurrence->failed_orders = 0;
        $userRecurrence->total_spent = 0;
        $userRecurrence->points = 0;

        $user->recurrence = $userRecurrence;
        $user->group_id = 2;

        $user->jti = Text::uuid();

        $this->httpStatusCode = 422;
        $this->apiResponse['message'] = __('Errors were found. Please try again!');

        if ($user->errors()) {
            $this->apiResponse['errors'] = $user->errors();

            return null;
        }

        if (!$this->Users->save($user, ['deep' => true])) {
            $this->apiResponse['errors'] = $user->errors();
            return null;
            return null;
        }

        $event = new Event('Model.User.signup', $this, [
            'username' => $user->username,
            'fist_name' => $user->detail->fist_name
        ]);
        $this->Users->eventManager()->dispatch($event);

        $this->token();
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Groups', 'Events', 'Registrations']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
