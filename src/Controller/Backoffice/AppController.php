<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller\Backoffice;

use Cake\Controller\Controller;
use Cake\Event\Event;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

		$cities2 = $this->loadModel('Cities')->find('list')->toArray();
		$this->set(compact('cities2'));
		
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'authError' => 'Efetua login para acederes à página solicitada.',
            'authenticate' => [
                'Form' => [
                    'finder' => 'auth'
                ]
            ],
            'storage' => 'Session',
            'authorize' => 'Controller'
        ]);

        $this->Auth->allow(['userList', 'login', 'generateSurveys', 'validateMb']);

        $user = $this->Auth->user();
        if($this->Auth->user('role') == 0) {
            $user['role_description'] = 'Formando';
        } elseif($this->Auth->user('role') == 1) {
            $user['role_description'] = 'Formador';
        } elseif($this->Auth->user('role') == 2) {
            $user['role_description'] = 'Coordenador';
        } elseif($this->Auth->user('role') == 3) {
            $user['role_description'] = 'Administrador';
        }

        if($this->Auth->user()):
         $permissions = $this->LoadModel('Moderators')->find('all', ['conditions' => ['users_id' => $this->Auth->user('id')]])->toArray();
        $user['moderator'] = array();
        foreach ($permissions as $key => $value) {
            $user['moderator'][$key] = $value['courses_id'];
        }
        endif;

        $this->set('Auth', $user);

        $courses = $this->LoadModel('Courses')->find('list');
        $this->set('Courses', $courses);

        $pending = $this->LoadModel('Sales')->find('all', ['conditions' => ['status' => 2]])->count();
        $this->set('Pending', $pending);
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    public function isAuthorized($user = null)
    {
        // Any registered user can access public functions
        if (!$this->request->getParam('prefix')) {
            return true;
        }

        if ($this->request->getParam('prefix') === 'backoffice') {
            
            // Students cant access backoffice functions
            if (!$user['role'] > 0) {
                return false;
            }

            //Only admins can access Sales, Public and Users functions
            if (($this->request->getParam('controller') === 'Sales' ||  $this->request->getParam('controller') === 'Users' || $this->request->getParam('controller') === 'Frontend' || $this->request->getParam('action') === 'documents') && $user['role'] != 3) {
                return false;
            }

            //Coordinators can only access their own courses
            if ($this->request->getParam('controller') === 'Courses' && $user['role'] == 2 && !in_array($this->request->getParam('pass')[0], $user['moderator'])) {
                return false;
            }

            //Teachers can only access files, questions/flashcards pages, feedback
            if ($user['role'] == 1 && $this->request->getParam('controller') !== 'Uploader' && $this->request->getParam('controller') !== 'Questions' && $this->request->getParam('controller') !== 'Flashcards' && $this->request->getParam('controller') !== 'Feedback') {
                return false;
            }

            return true;
        }

        // Default deny
        return false;
    }
}
