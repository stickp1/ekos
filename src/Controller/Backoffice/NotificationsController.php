<?php
namespace App\Controller\Backoffice;


use App\Controller\Backoffice\AppController;
use Cake\Mailer\Email;
use Cake\Routing\Router;

/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 *
 * @method \App\Model\Entity\Question[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsController extends AppController
{

    private function email_template($name, $body) {

        return '<body bgcolor="#FFFFFF" style="-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; height: 100%; margin: 0; padding: 0; width: 100% !important;">
                  <style>
                    @media only screen and (max-width: 600px) {
                      a[class="btn"] {
                        display: block!important;
                        margin-bottom: 10px!important;
                        background-image: none!important;
                        margin-right: 0!important;
                      }
                      div[class="column"] {
                        width: auto!important;
                        float: none!important;
                      }
                      table.social div[class="column"] {
                        width: auto!important;
                      }
                    }
                  </style>

                  <!-- HEADER -->
                  <table class="head-wrap" bgcolor="#152335" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0; width: 100%;">
                    <tbody>
                      <tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
                        <td style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
                        <td class="header container" style="clear: both !important; display: block !important; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0 auto !important; max-width: 600px !important; padding: 0;">

                          <div class="content" style="display: block; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0 auto; max-width: 600px; padding: 15px;">
                            <table bgcolor="#152335" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0; width: 100%;">
                              <tbody>
                                <tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
                                  <td style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;" text-align="right"><img src="'.Router::url(['prefix' => false, 'controller' => '/'], true).'/img/logo_white.png" height="75" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; max-width: 100%; padding: 0; float:right"></td>
                                  </tr>
                              </tbody>
                            </table>
                          </div>

                        </td>
                        <td style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- /HEADER -->


                  <!-- BODY -->
                  <table class="body-wrap" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0; width: 100%;">
                    <tbody>
                      <tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
                        <td style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
                        <td class="container" bgcolor="#FFFFFF" style="clear: both !important; display: block !important; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0 auto !important; max-width: 600px !important; padding: 0;">

                          <div class="content" style="display: block; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0 auto; max-width: 600px; padding: 15px;">
                            <table style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0; width: 100%;">
                              <tbody>
                                <tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
                                  <td style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
                                    <h3 style="color: #000; font-family: \'HelveticaNeue-Light\', \'Helvetica Neue Light\', \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 27px; font-weight: 500; line-height: 1.1; margin: 0; margin-bottom: 15px; padding: 0;"> Atenção,</h3>
                                    <div style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: normal; line-height: 1.6; margin: 0; margin-bottom: 10px; padding: 0;">
                                     '.$body.'
                                     <p><b>A equipa EKOS.</b></p>
                                     </div>
                                    </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                        </td>
                        <td style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- /BODY -->


                </body>

                </html>';
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($course_id = null)
    {
        $id = $this->Auth->user('id');
        $user = $this->loadModel('Users')->get($id, [
            'contain' => ['Moderators']
            ])->toArray();

        if($user['moderators'] != ''):
            $moderators = array();
        foreach ($user['moderators']  as $key => $value) {
            array_push($moderators, $value['courses_id']);
        }
        endif;

        if(isset($course_id)):

            if($user['role'] == 3):
                $this->paginate = [
                    'contain' => ['Courses', 'Cities'],
                    'conditions' => ['course_id' => $course_id]
                ];

                $courses = $this->loadModel('Courses')->find('list')->toArray();

            elseif($user['role'] == 4):
                $this->paginate = [
                    'contain' => ['Courses', 'Cities'],
                    'conditions' => ['course_id' => $course_id, 'city_id' => $user['city_id']]
                ];

                $courses = $this->loadModel('Courses')->find('list')->toArray();

            else:

                $this->paginate = [
                    'contain' => ['Courses', 'Cities'],
                    'conditions' => ['course_id' => $course_id, 'course_id in ('.implode(',', $moderators).')']
                ];

                $courses = $this->loadModel('Courses')->find('list', ['conditions' => 'id in ('.implode(',', $moderators).')'])->toArray();

            endif;


        else:

            if($user['role'] == 3):
                $this->paginate = [
                    'contain' => ['Courses', 'Cities']
                ];

                $courses = $this->loadModel('Courses')->find('list')->toArray();

            elseif($user['role'] == 4):
                $this->paginate = [
                    'contain' => ['Courses', 'Cities'],
                    'conditions' => ['city_id' => $user['city_id']]
                ];

                $courses = $this->loadModel('Courses')->find('list')->toArray();

            else:
                $this->paginate = [
                    'contain' => ['Courses', 'Cities'],
                    'conditions' => ['course_id in ('.implode(',', $moderators).')']
                ];

                $courses = $this->loadModel('Courses')->find('list', ['conditions' => 'id in ('.implode(',', $moderators).')'])->toArray();

            endif;

        endif;

        
        $notifications = $this->paginate($this->Notifications);

        $this->set(compact('notifications', 'courses'));
    }

    /**
     * View method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function email($id = null)
    {
        $notification = $this->Notifications->get($id);

        $groups = $this->loadModel('Groups')->find('all', ['conditions' => [
            'deleted != ' => 1, 
            'courses_id' => $notification['course_id'],
            'city_id' => $notification['city_id']
            ], 'contain' => ['Users']
            ])->toArray();

        $emails = array();
        foreach ($groups as $group) {
            foreach ($group['users'] as $user) {
                array_push($emails, $user['email']);
            }
        }

        $body = $this->email_template('', $notification['value']);

        $email = new Email('default');
        $email->bcc($emails)
            ->emailFormat('html')
            ->subject('EKOS - Nova notificação')
            ->send($body);

        $this->Flash->success(__('O aviso foi enviado por e-mail.'));
        return $this->redirect(['controller' => 'notifications']);

        

        $this->set('question', $question);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notification = $this->Notifications->newEntity();

        $id = $this->Auth->user('id');
        $user = $this->loadModel('Users')->get($id, [
            'contain' => ['Moderators']
            ])->toArray();

        if($user['moderators'] != ''):
            $moderators = array();
            foreach ($user['moderators']  as $key => $value) {
                array_push($moderators, $value['courses_id']);
            }
        endif;

        if($user['role'] > 2):

            $courses = $this->loadModel('Courses')->find('list')->toArray();

        else:

            $courses = $this->loadModel('Courses')->find('list', ['conditions' => 'id in ('.implode(',', $moderators).')'])->toArray();

        endif;


        if ($this->request->is('post')) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('O aviso foi guardado'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        $this->set(compact('notification', 'courses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notification = $this->Notifications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());

            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('O aviso foi guardado.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        $this->set(compact('notification'));
    }


    public function toggle($id = null)
    {
        if($this->request->is('post')) {
            $notification = $this->Notifications->get($id);
            if ($notification['active'] == 1){$notification['active'] = 0;} else {$notification['active'] = 1;}
            $this->Notifications->save($notification);
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notification = $this->Notifications->get($id);
        if ($this->Notifications->delete($notification)) {
            $this->Flash->success(__('O aviso foi eliminado.'));
        } else {
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }


}
