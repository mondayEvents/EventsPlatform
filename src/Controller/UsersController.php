<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\{
    I18n\Time,
    Network\Exception\UnauthorizedException,
    Network\Exception\BadRequestException,
    Utility\Text
};

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Initialize Controller
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add', 'token']);
    }

    /**
     * List and paginate all users
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * Retrieve a valid token, if the request body is valid
     *
     * @return \Cake\Http\Response|void|null Renders JSON response.
     * @throws \Cake\Datasource\Exception\UnauthorizedException When user not found.
     */
    public function token()
    {
        $this->request->allowMethod(['post']);

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid username or password');
        }

        $this->set(['JWT' => $this->Users->createToken($user['id'], $user['group_id'], $user['jti'])]);
        unset($user['group_id'], $user['jti']);

        $this->set(['user' => $user,
            '_serialize' => ['JWT', 'user']
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void|null Renders JSON response.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When user not found.
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
     * @return \Cake\Http\Response|void|null Renders JSON response.
     * @throws \Cake\Network\Exception\BadRequestException When user is already logged.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);

        if ($this->Auth->identify())
        {
            throw new BadRequestException(__("You are already registered or logged in!"));
        }

        $user = $this->Users->newEntity();
        $user = $this->Users->patchEntity($user, $this->request->getData());
        $user->groups_id = 2;
        $user->jti = Text::uuid();

        if (!$this->Users->save($user)) {
            $error = $user->getErrors();
            $this->response(400, compact('error'));
            return;
        }

        $JWT = $this->Users->createToken($user->id, $user->groups_id, $user->jti);

        $this->set(compact('JWT'));
        $this->set('_serialize', ['JWT']);

    }

    /**
     * Edit method
     *
     * @return \Cake\Http\Response|void|null Renders JSON response.
     * @throws \Cake\Network\Exception\NotFoundException When user not found.
     */
    public function edit()
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        $user = $this->Users->get($this->Auth->user('uid'), [
            'contain' => ['Groups']
        ]);

//        dd($user);

        $user = $this->Users->patchEntity($user, $this->request->getData());

        if (!$this->Users->save($user)) {
            $error = $user->getErrors();
            $this->response(400, compact('error'));
            return;
        }

    }

}
