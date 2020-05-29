<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Number;
use Cake\Http\Client;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\Utility\Hash;
use Cake\Http\Cookie\Cookie;
use DateTime;
use Cake\Routing\Router;

/**
 * Classes Controller
 *
 * @property \App\Model\Table\ClassesTable $Classes
 *
 * @method \App\Model\Entity\Class[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FrontendController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
    
     $scity = $this->request->getCookie('city');
     if($scity) $city_id = $scity; else $city_id = 1;
       
       $courses = $this->loadModel('Courses')->find('all', [
          'order' => 'name', 
          'contain' => ['Groups' => ['conditions' =>  ['Groups.active' => 1, 'Groups.deleted' => 0, 'Groups.city_id' => $city_id], 'Lectures']]
        ])->toArray();

       foreach ($courses as $key => $value) { 

            $min_date = new \DateTime('2040-12-31');
            $max_date = new \DateTime('1994-12-31');
            $e = 1;

            foreach ($value['groups'] as $key2 => $group) {
                      
                      foreach ($group['lectures'] as $lecture) { 
            if($lecture['datetime']):
                        if($lecture['datetime']->format("Y-m-d") < $min_date->format("Y-m-d")) { 
                          $min_date = $lecture['datetime'];
                        }

                        if($lecture['datetime']->format("Y-m-d") > $max_date->format("Y-m-d")) { 
                          $max_date = $lecture['datetime'];
                        }

                        $e = 2;
            endif;
                      }
                     
            } 

            if($e == 2):

            $courses[$key]['min_date'] = $min_date;
            $courses[$key]['max_date'] = $max_date;

            else:

            $courses[$key]['min_date'] = $min_date;

            endif;

            $courses[$key]['e'] = $e;


      }

      $courses =  (array) $courses;

            

      usort( $courses, array( $this, 'sort' ) );

      $this->set(compact('courses', 'courses2'));
    }


    private function sort($a, $b) 
    {
      if ($a['min_date'] == $b['min_date']) return 0;
      return ($a['min_date'] > $b['min_date']) ? 1 : -1;
    }

    public function sobre()
    {
    
    	$scity = $this->request->getCookie('city');
     if($scity) $city_id = $scity; else $city_id = 1;
     
       $teachers = $this->loadModel('Users')->find('all', [
            'contain' => ['Moderators' => ['sort' => ['Courses.name' => 'ASC'], 'Courses']], 
            'order' => 'first_name',
            'conditions' => ['role >' => 0, 'city_id' => $city_id]
        ])->toArray();

       //ORDENAR POR CURSO
       // foreach ($users as $key => $value) {
       //    foreach ($users[$key]['moderators'] as $key2 => $value2) {
       //        $users[$key]['moderators'][$key2] = $value2['course']['name'];
       //    }
           
       //     $user[$value['id']] = $value;
       // }

       // $moderators = $this->loadModel('Moderators')->find('all', ['contain' => ['Courses', 'Users'], 'order' => ['Courses.name', 'Users.first_name']])->toArray();

       // $teachers = array();

       // foreach ($moderators as $moderator) {
       //     if(isset($user[$moderator['users_id']])):
       //      array_push($teachers, $user[$moderator['users_id']]);
       //      unset($user[$moderator['users_id']]);
       //      endif;
       // }

        foreach ($teachers as $key => $teacher) {
          foreach ($teacher['moderators'] as $key2 => $value) {
            $teachers[$key]['moderators'][$key2] = $value['course']['name'];
          }
        }

       $this->set(compact('teachers'));
    }
    
    public function perguntas ()
    {
    }

    public function cursos()
    {
    
       $scity = $this->request->getCookie('city');
       if($scity) $city_id = $scity; else $city_id = 1;
       
       $courses = $this->loadModel('Courses')->find('all', [
          'order' => 'name', 
          'contain' => ['Groups' => ['conditions' => ['Groups.active' => 1, 'Groups.deleted' => 0, 'Groups.city_id' => $city_id], 'Lectures' => ['Users']], 'Themes'],
          'conditions' => ['id >' => 1]
        ]);

       $count_ = $this->loadModel('Products')->find('all', ['fields' => ['group_id', 'count' => 'count(id)'], 'group' => 'group_id'])->toArray();
       $count = array();
       foreach ($count_ as $key => $value) {
         $count[$value['group_id']] = $value['count'];
       }

       if($this->Auth->user()){
        $inscriptions = $this->loadModel('Products')->find('list', ['conditions' => ['sales_users_id' => $this->Auth->user('id')], 'valueField' => 'group_id' ])->toArray();
        $inscriptions_courses = $this->loadModel('UsersGroups')->find('list', ['conditions' => ['users_id' => $this->Auth->user('id')], 'valueField' => 'groups_courses_id' ])->toArray();
        $waiting = $this->loadModel('WaitingList')->find('list', ['conditions' => ['user_id' => $this->Auth->user('id')], 'valueField' => 'group_id' ])->toArray();
        $this->set(compact('inscriptions', 'inscriptions_courses', 'waiting'));
       }

       $themes = $this->loadModel('Themes')->find('list')->toArray();

       $this->set(compact('courses', 'themes', 'count'));
    }

    public function informacoes()
    {
       $content = $this->Frontend->find('list', ['valueField' => 'content'])->toArray();

       $themes = $this->LoadModel('Themes')->find('all', ['order' => ['domain', 'area', "relevance REGEXP '[*]' DESC", 'relevance']])->toArray();

       $matrix = array();

       foreach ($themes as $key => $value) {
          $matrix[$value['domain']][$value['area']][$value['id']] = $value;
       }

        $this->set(compact('content', 'matrix'));
    }

    public function contactos($contact = null)
    {
       if ($this->request->is('post')) {

          $http = new Client();
          $response = $http->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6LdAL20UAAAAAO08rksDD8JnYgEMQBgqdA0py0zk',
            'response' => $this->request->getData('g-recaptcha-response')
          ]);

          if($response->json['success'] == true){

            $email = new Email('default');
                        $email->to('geral@ekos.pt')
                            ->emailFormat('html')
                            ->subject('EKOS - NOVO CONTACTO')
                            ->send("<p>Olá,</p><p>Foi submetida uma nova mensagem geral através do site da EKOS, com o seguinte conteúdo: </p>
                              <p><b>Nome:</b>".$this->request->getData('nome')."</p>
                              <p><b>Contacto:</b>".$this->request->getData('contacto')."</p>
                              <p><b>Mensagem:</b>".nl2br($this->request->getData('message'))."</p>
                              ");
            
          $contact2 = 'success';
          $this->set(compact('contact2'));

          }

          else {
            $contact = $this->request->getData();
            $this->Flash->error(__('Não foi possível confirmar que não és um robô, e a tua mensagem não foi enviada. Por favor, tenta novamente.'));

          } 
       }

       $this->set(compact('contact'));
    }

     public function soon()
    {
        $this->layout = 'ajax';
    }

     public function feedback($id = null)
     {

        $survey = $this->loadModel('Feed_user_surveys')->find('all', ['conditions' => ['code' => $id], 'contain' => ['Lectures' => ['Groups' => ['Courses'], 'Users']]]);
        if($survey->count() == 0){
          $this->Flash->error(__('Questionário não encontrado.'));
          return $this->redirect(['controller' => '/']);
        } else {
          $survey = $survey->first();
          if($survey['answered'] == 1){
            $this->Flash->error(__('Questionário já preenchido.'));
            return $this->redirect(['controller' => '/']);
          }

          if ($this->request->is('post')) {

            $data = $this->request->data();

            //COMEÇA A INSERIR AS RESPOSTAS GERAIS E DE CURSO
            foreach ($data['q'] as $key => $q) {
              $question = $this->loadModel('Feed_answers')->newEntity();
              $question['question_id'] = $key;
              $question['value'] = $q;
              $question['lecture_id'] = $survey['lecture']['id'];
              $question['teacher_id'] = $survey['lecture']['teacher'];
              $question['year'] = $survey['year'];
              $question['course_id'] = $survey['course_id'];
              $question = $this->loadModel('Feed_answers')->save($question);
            }

            //INSERE OS COMENTÁRIOS
            if($data['comments'] != ''):
            $question = $this->loadModel('Answers'.$survey['year'])->newEntity();
            $question['question_id'] = 0;
            $question['long_value'] = $data['comments'];
            $question['lecture_id'] = $survey['lecture']['id'];
            $question['teacher_id'] = $survey['lecture']['teacher'];
            $question['year'] = $survey['year'];
            $question['course_id'] = $survey['course_id'];
            $question = $this->loadModel('Feed_answers')->save($question);
            endif;

            //Atualiza o estado do questionário e redireciona
            $survey['answered'] = 1;
            if($this->loadModel('Feed_user_surveys')->save($survey)){
              $this->Flash->success('Resposta submetida com sucesso.');
            }

            $this->redirect(['controller' => '/']);

          }


          $themes = explode(',', $survey['lecture']['themes']);
          $themes = $this->loadModel('Themes')->find('list', ['conditions' => ['id in' => $themes]])->toArray();
        }
        

        $questions = $this->loadModel('Feed_questions')->find('all', ['conditions' => ['deleted' => 0, 'status' => 1]])->toArray();
    

        $this->set(compact('questions', 'survey', 'themes'));
     }

     public function city ($id = null)
    {
      $this->response = $this->response->withCookie('city', [
        'value' => $id
      ]);

      return $this->redirect( Router::url( $this->referer(), true ) );
    }

    public function report($contact = null)
    {
      
      if ($this->request->is('post')) {

          $http = new Client();
          $response = $http->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6LdAL20UAAAAAO08rksDD8JnYgEMQBgqdA0py0zk',
            'response' => $this->request->getData('g-recaptcha-response')
          ]);

          if($response->json['success'] == true){ 

            $email = new Email('default');
            
            $email->to('geral@ekos.pt')
                  ->emailFormat('html')
                  ->subject('EKOS - Bug Report')
                  ->send("<p>Olá,</p><p>Foi submetido um novo report de erro ou sugestão de funcionalidade através do site da EKOS, com o seguinte conteúdo:
                          </p>
                          <p><b>Url: </b>".$this->request->getData('report-url')."</p>
                          <p><b>Mensagem: </b>".nl2br($this->request->getData('report-message'))."</p>".((empty($this->request->getData('report-contact'))) ? "" : "<p><b>Contacto: </b>").$this->request->getData('report-contact')."</p>"
                  );
                        
            $this->Flash->success(__('A mensagem foi enviada com sucesso. Obrigado pelo feedback!'));
          }
          else {
            $report = $this->request->getData();
            $this->Flash->error(__('Não foi possível confirmar que não és um robô, e a tua mensagem não foi enviada. Por favor, tenta novamente.'));
            $this->set(compact('report'));
          } 
      }
      return $this->redirect($this->referer());
    }

    public function formacao()
    {
      $scity = $this->request->getCookie('city');
      if($scity) $city_id = $scity; else $city_id = 1;
       
      $courses = $this->loadModel('Courses')->find('all', [
        'order' => 'name', 
        'contain' => ['Groups' => ['conditions' =>  ['Groups.active' => 1, 'Groups.deleted' => 0, 'Groups.city_id' => $city_id], 'Lectures']]
        ])->toArray();

      foreach ($courses as $key => $value) { 

            $min_date = new \DateTime('2040-12-31');
            $max_date = new \DateTime('1994-12-31');
            $e = 1;

            foreach ($value['groups'] as $key2 => $group) {
                      
                      foreach ($group['lectures'] as $lecture) { 
            if($lecture['datetime']):
                        if($lecture['datetime']->format("Y-m-d") < $min_date->format("Y-m-d")) { 
                          $min_date = $lecture['datetime'];
                        }

                        if($lecture['datetime']->format("Y-m-d") > $max_date->format("Y-m-d")) { 
                          $max_date = $lecture['datetime'];
                        }

                        $e = 2;
            endif;
                      }
                     
            } 

            if($e == 2):

            $courses[$key]['min_date'] = $min_date;
            $courses[$key]['max_date'] = $max_date;

            else:

            $courses[$key]['min_date'] = $min_date;

            endif;

            $courses[$key]['e'] = $e;
      }

      $courses =  (array) $courses;

      $courses2 = [
        1 => "Patologia Médica", 
        2 => "Patologia Cirúrgica", 
        3 => "Patologia Pediátrica", 
        4 => "Patologia Ginecológica/Obstétrica", 
        5 => "Patologia Psiquiátrica"
      ];

      $courses3 = [
        1 => "Gestão do Trabalho", 
        2 => "Planificação de Tarefas", 
        3 => "Desperdiçadores e Economizadores de Tempo", 
        4 => "Definição de Objetivos", 
        5 => "Aplicação de Exercício Prático"
      ];

      usort( $courses, array( $this, 'sort' ) );

      $this->set(compact('courses', 'courses2', 'courses3'));
    }
   
}
