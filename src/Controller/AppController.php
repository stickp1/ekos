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
namespace App\Controller;

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
        
        

        $scity = $this->request->getCookie('city');
        
        $cities = $this->loadModel('Cities')->find('all')->toArray();
        $cities2 = $this->loadModel('Cities')->find('list')->toArray();
        $this->set(compact('cities', 'cities2', 'scity'));


        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'authError' => 'Não te é permitido aceder à página solicitada.',
            'authenticate' => [
                'Form' => [
                    'finder' => 'auth'
                ]
            ],
            'storage' => 'Session'
        ]);

        /*
if($this->Auth->user() == null && $this->request->getParam('action') != 'soon' && $this->request->getParam('controller') != 'Users'){
            return $this->redirect(['prefix' => false, 'controller' => 'soon']);
        }

        if($this->request->getParam('controller') == 'Users'){
            $this->Auth->allow();
        } else {
            $this->Auth->allow(['soon']);
        }
*/

        $this->Auth->allow();


        $user = $this->Auth->user();
        if($this->Auth->user('role') == 0) {
            $user['role_description'] = 'Formando';
        } elseif($this->Auth->user('role') == 1) {
            $user['role_description'] = 'Formador';
        } elseif($this->Auth->user('role') == 2) {
            $user['role_description'] = 'Coordenador';
        } elseif($this->Auth->user('role') == 3) {
            $user['role_description'] = 'Administrador';
        } elseif($this->Auth->user('role') == 4) {
            $user['role_description'] = 'Coordenador Local';
        }
        $this->set('Auth', $user);

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

        // Only admins can access admin functions
        if ($this->request->getParam('prefix') === 'backoffice') {
            return (bool)($user['role'] > 0);
        }

        // Default deny
        return false;
    }
}
