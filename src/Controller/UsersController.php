<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\{
    I18n\Time, Network\Exception\UnauthorizedException, Network\Exception\BadRequestException, ORM\Exception\PersistenceFailedException, Utility\Text
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

        $user = $this->Users->get($user['id'], ['contain' => ['Groups']]);

        $message = ['JWT' => $user->getToken()];
        unset($user->group, $user->jti);
        $message['user'] = $user;

        $this->setResponseMessage($message);
        $this->buildResponse();
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

        try {
            $this->Users->cantBeLogged($this->Auth->user());

            $user = $this->Users->newEntity($this->request->getData(), ['associated' => ['Tags']]);
            $user->group = $this->Users->Groups->findByName('Regular')->first();
            $user->jti = Text::uuid();
            $tags = $this->request->getData('tags');

            if (!empty($tags)) {
                $user->tags[] = $this->Users->Tags->find()
                    ->where(['Tags.id IN' => $tags])
                    ->select(['id','name'])
                    ->toList();
            }

            $user = $this->Users->saveOrFail($user);
            $this->setResponseMessage([
                'JWT' => $user->getToken(),
                'user' => $user
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
     * @return \Cake\Http\Response|void|null Renders JSON response.
     * @throws \Cake\Network\Exception\NotFoundException When user not found.
     */
    public function edit()
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        try {
            $user = $this->Users->get($this->Auth->user('uid'), ['contain' => ['Tags']]);
            $tags = $this->request->getData('tags');

            if (!empty($tags)) {
                $user->tags[] = $this->Users->Tags->find()
                    ->where(['Tags.id IN' => $tags])
                    ->select(['id','name'])
                    ->toList();
            }

            $this->Users->saveOrFail($this->Users->patchEntity($user, $this->request->getData()));

            $this->setResponseMessage(['message' => ['_success' => 'Your profile was updated!']]);

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