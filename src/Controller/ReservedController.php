<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Inflector;
use CakePdf\Pdf\CakePdf;
use Cake\Datasource\ConnectionManager;
use Cake\Database\Schema\TableSchema;
use Cake\I18n\Time;
use Cake\I18n\I18n;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\ORM\Query;







/**
 * Classes Controller
 *
 * @property \App\Model\Table\ClassesTable $Classes
 *
 * @method \App\Model\Entity\Class[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReservedController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($group_id = null)
    {
        
        $id = $this->Auth->user('id');
        if(!isset($id))   return $this->redirect(['controller' => '/']);

        $user = $this->loadModel('Users')->get($id, [
            'contain' => [
                'groups' => [
                    'conditions' => [
                        'deleted' => 0
                    ],
                    'Courses'
                ]
            ],
        ])->toArray();

        $courses = array();
        foreach ($user['groups'] as $key => $value) {
            $courses[$key] = $value['course']['id'];
        }
        
        $groups = array();
        foreach ($user['groups'] as $key => $value) {
            $groups[$key] = $value['id'];
        }

        if($group_id != null && !in_array($group_id, $groups)){
            $this->Flash->error(__('Não tens permissão para aceder ao curso selecionado.'));
            return $this->redirect(['action' => 'index']);
        } elseif($group_id == null && !count($user['groups']) > 0)
            $user['groups'] = 0;
        elseif($group_id == null)
            $group_id = $user['groups'][0]['id'];

        if(@count($user['groups']) > 0):
        $group = $this->loadModel('Groups')->find('all', [
            'conditions' => ['id' => $group_id],
            'contain' => ['Lectures' => ['Users']]
            ])->first();

        $surveys = $this->loadModel('Feed_user_surveys')->find('list', [
                'conditions' => ['user_id' => $id, 'answered' => 0, 'course_id' => @$group['courses_id']], 
                'keyField' => 'lecture_id', 
                'valueField' => 'code'])->toArray();

        $notifications = $this->loadModel('Notifications')->find('all', [
            'conditions' => ['course_id' => @$group['courses_id'], 'active' => 1]
            ])->toArray();

        $themes_ = $this->loadModel('Themes')->find('all', [
            'conditions' => ['courses_id' => @$group['courses_id']],
            'contain' => ['Uploads' => ['conditions' => ['active' => 1, 'Uploads.city_id' => @$group['city_id']]]]
            ])->toArray();
        $themes = array();
        foreach ($themes_ as $key => $value) {
            $themes[$value['id']] = $value; 
        }
        endif;
        

        $this->set(compact( 'group', 'user', 'themes', 'notifications', 'surveys', 'courses'));
    }

    public function schedule($group_id = null)
    {
        $id = $this->Auth->user('id');
        if(!isset($id) || !isset($group_id))   return $this->redirect(['controller' => '/']);

        $user = $this->loadModel('Users')->get($id, [
            'contain' => [
                'groups' => [
                    'Courses'
                ]
            ]
        ])->toArray();

        $groups = array();
        foreach ($user['groups'] as $key => $value) {
            $groups[$key] = $value['id'];
        }

        if(!in_array($group_id, $groups)){
            $this->Flash->error(__('Não tens permissão para aceder ao curso selecionado.'));
            return $this->redirect(['action' => 'index']);
        }

        $group = $this->loadModel('Groups')->find('all', [
            'conditions' => [
                'Groups.id' => $group_id
            ],
            'contain' => [
                'Lectures' => [
                    'Users'
                ], 
                'Courses'
            ]
        ])->first();

        $themes_ = $this->loadModel('Themes')->find('all', [
            'conditions' => [
                'courses_id' => $group[
                    'courses_id'
                ]
            ]
        ])->toArray();
        $themes = array();
        foreach ($themes_ as $key => $value) {
            $themes[$value['id']] = $value; 
        }

        $this->viewBuilder()->options([
            'pdfConfig' => [
                'orientation' => 'portrait',
            ]
        ]);

         $this->set(compact( 'group', 'themes'));        
    }

    public function payments()
    {

            $id = $this->Auth->user('id');
            if(!isset($id))   return $this->redirect(['controller' => '/']);
            
            $user = $this->loadModel('Users')->get($id, [
            'contain' => ['groups' => ['Courses']]
            ])->toArray();
            
        
			//Elimina cursos de turmas eliminadas
	        foreach ($user['groups'] as $key => $value) {
	           if($value['deleted'] == 1) unset($user['groups'][$key]);
	        }
	
	        $courses = array();
	        foreach ($user['groups'] as $key => $value) {
	            $courses[$key] = $value['course']['id'];
	        }

            $sales = $this->loadModel('sales')->find('all', [
                'conditions' => [
                    'users_id' => $id 
                ],
                'contain' => [
                    'Products' => [
                        'Groups' => [
                            'Courses'
                        ]
                    ], 
                    'Mb_references'
                ]
            ])->toArray();
            

            $this->set(compact( 'sales', 'courses'));
    }

    public function file($file_id = null, $name = null)
    {

        $id = $this->Auth->user('id');

        $upload = $this->loadModel('Uploads')->get($file_id, ['contain' => ['Themes' => ['Courses']]]);
        $course = $upload['theme']['course']['id'];
        
        $user = $this->loadModel('Users')->get($id, [
            'contain' => ['groups' => ['Courses']]
            ])->toArray();

        $courses = array();
        foreach ($user['groups'] as $key => $value) {
            $courses[$key] = $value['course']['id'];
        }

         if(!in_array($course, $courses)){
            $this->Flash->error(__('Não tens permissão para aceder ao ficheiro selecionado.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->autoRender = false;
        header("Content-type:".$upload['type']);
        header("Content-Disposition: inline; filename=".$upload['url']);
        @readfile('http://ekos.pt/img/uploads/'.$upload['url']);
    }

    public function profile()
    {
        $id = $this->Auth->user('id');
        if(!isset($id))   return $this->redirect(['controller' => '/']);

        // We need to get the user each time because it might be different from the original authenticated user
        // (eg. if image is updated, which happens in a different function)
         $user = $this->loadModel('Users')->get($id);

         $user_ = $this->loadModel('Users')->get($id, [
            'contain' => ['groups' => ['Courses']]
            ])->toArray();

        //Elimina cursos de turmas eliminadas
        foreach ($user_['groups'] as $key => $value) {
           if($value['deleted'] == 1) unset($user_['groups'][$key]);
        }

        $courses = array();
        foreach ($user_['groups'] as $key => $value) {
            $courses[$key] = $value['course']['id'];
        }

        if(isset($_GET['img'])) {
            if ($_GET['img'] == 1)
                $this->Flash->success(__('Imagem atualizada com sucessoo.'));
            elseif ($_GET['img'] == 2)
                $this->Flash->error(__('Ocorreu um erro ao guardar a imagem.'));
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $new_email = $this->request->getData('email');
            $user = $this->loadModel('Users')->patchEntity($user, $this->request->getData(),[
              'accessibleFields' => [
                '*' => false,
                'first_name' => true,
                'last_name' => true,
                'phone_number' => true,
                'vat_number' => true,
                'description' =>true
              ]
            ]);
            if ($user['email'] != $new_email)
                $email_flash = $this->changeMail($new_email);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Utilizador guardado com sucesso. '. @$email_flash));
                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again. ' . $email_flash));
        }
        $this->set(compact('user', 'courses'));
    }
 
    public function changeMail($new_email, $char=null)
    {
      $this->autoRender = false;
      if($char && $this->request->is(['post','get'])) {

          $user = $this->loadModel('Users')->find('all', ['conditions' => ['reset_char' => $char]])->first();
          $user = $this->loadModel('Users')->patchEntity($user,array('email' => $new_email, 'reset_char' => null),['accessibleFields' => [
            '*' => false,
            'email' => true,
            'reset_char' => true
            ]
          ]);

          if($this->loadModel('Users')->save($user))
            $this->Flash->success(__('E-mail alterado com sucesso.'));
          else
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
          return $this->redirect(['controller' => '/']);
      } else {
          $user = $this->Auth->user();
          $user['reset_char'] = md5(uniqid(time(), true));
          if ($this->loadModel('Users')->save($user)){

            $text = '<p>Recebemos um pedido de alteração de email. Por favor confirma esta alteração através do botão abaixo. Se não foste tu a efetuar esta alteração ou se não desejas proceder com a mesma, por favor ignora este contacto. Contacta geral@ekos.pt para mais informações.</p>
                  <p><b>Vemo-nos em breve!</b></p>
                  <a class="btn" style="background-color: #ccc; color: #152335; cursor: pointer; display: inline-block; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-weight: bold; margin: 0; margin-right: 10px; padding: 10px 16px; text-align: center; text-decoration: none;" href="'.Router::url(['action' => 'changeMail',$new_email, $user['reset_char']], true).'">Alterar email</a>';
            $body = $this->email_template($user['first_name'], $text);

                        $email = new Email('default');
                        $email->to($new_email)
                            ->emailFormat('html')
                            ->subject('EKOS - Alterar email')
                            ->send($body);

            return 'Foi-te enviado um email com instruções para confirmar a mudança de email.';
          }
          return 'Ocorreu um erro ao tentar alterar o email. Por favor, tenta novamente.';
      }
    }

    public function changeImage()
    {

        $this->viewBuilder()->setLayout('ajax');
        error_reporting(false);

        if(isset($_POST['img'])){
            $data = $_POST['img'];
            $id = $_POST['id'];


            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $name = substr( sha1( time() ), 0, 5 );
            if(file_put_contents('img/pics/'.$name.'.png', $data))
            {
                $user = $this->loadModel('Users')->get($id);
                $user['pic'] = "img/pics/".$name.'.png';
                $this->loadModel('Users')->save($user);
                //$this->set(compact('user'));
                echo "success";
                exit;
            } else {
                echo "error";
                exit;
            }
        }
    }

    public function inscription ($course_id = null, $annual = null)
    {
        
        $this->loadModel('Products');

        $id = $this->Auth->user('id');

        if(!isset($id))   return $this->redirect(['controller' => '/']);

        if($scity = $this->request->getCookie('city')) 
            $city_id = $scity; 
        else 
            $city_id = 1;
    
        $course = $this->Products->Courses->get($course_id);

        $groups_raw = $this->Products->find('all', [
            'fields' => [
                'group_id', 
                'count' => 'count(products.id)', 
                'groups.name', 
                'groups.courses_id', 
                'groups.vacancy'
            ], 
            'group' => 'group_id'
        ])->matching('Groups', function (Query $q) use ($course_id, $city_id) {
            return $q->where([
                'Groups.courses_id' => $course_id, 
                'Groups.active' => 1, 
                'Groups.deleted' => 0,
                'Groups.city_id' => $city_id, 
                'Groups.inscriptions_open' => 1
            ]);
        });

        $groups = array();
        foreach ($groups_raw as $key => $value)
            if ($value['count'] < $value['groups']['vacancy'])
                $groups[$key] = [
                    'id'=>$value['group_id'],
                    'used'=>$value['count'], 
                    'name'=>$value['groups']['name'], 
                    'vacancy'=>$value['groups']['vacancy']
                ];

        // If there is no match (because no one signed up yet): get groups from group table
        $groups = $groups_raw->count() ? $groups : $this->Products->Groups->find('all', [
            'conditions' => [
                'courses_id' => $course_id, 
                'active' => 1, 
                'deleted' => 0,
                'city_id' => $city_id, 
                'inscriptions_open' => 1,
                'vacancy >' => 0
            ]
        ])->toArray();
  
        if(empty($groups) || $this->Products->exists(['sales_users_id' => $id, 'group_courses_id' => $course_id])){
            $this->Flash->error(__('Não foi possível realizar a inscrição'));
            return $this->redirect(['action' => 'index']);
        }

        if($annual){
             
            $courses = $this->loadModel('Courses')->find('list', [ 
                'conditions' => [
                  'Courses.id > 1',
                  'Courses.id < 14'
                ],
                'valueField' => 'Courses.id'
              ])->join([
                'g' => [
                  'table' => 'Groups',
                  'type' => 'LEFT',
                  'conditions' => [
                    'g.courses_id = courses.id',
                    'g.active' => 1,
                    'g.city_id' => $city_id
                  ]
                ],
                'l' => [
                  'table' => 'Lectures',
                  'type' => 'LEFT',
                  'conditions' => [
                    'l.group_id = g.id',
                    'l.datetime is not null'
                  ]
                ]
              ])->order('l.datetime')->group('Courses.id')->toArray();
            $courses = array_keys($courses);

            $annual_courses = $this->Products->Courses->find('all', [
                'order' => 'name',
                'conditions' => 'id in ('.implode(',',$courses).')',
                'contain' => [
                    'Groups' => [
                        'conditions' => [
                            'active' => 1,
                            'deleted' => 0,
                            'city_id' => $city_id
                        ]
                    ]
                ]
            ])->toArray();
            $course['price'] = $city_id !=3 ? 850 : 620;
            $course['name'] = 'Curso Anual';

            $this->set(compact('annual_courses', 'courses'));
        }
        if ($this->request->is('post')) {

            $posted = $this->request->getData();
            $group_id = $this->request->getData('group_id');
            $all_sales = [];

            if($annual){

                $courses_id_order = $this->loadModel('Courses')->find('list', [ 
                    'conditions' => [
                      'Courses.id > 1',
                      'Courses.id < 14'
                    ],
                    'valueField' => 'Courses.id'
                    ])->join([
                    'g' => [
                      'table' => 'Groups',
                      'type' => 'LEFT',
                      'conditions' => [
                        'g.courses_id = courses.id',
                        'g.active' => 1,
                        'g.city_id' => $city_id
                      ]
                    ],
                    'l' => [
                      'table' => 'Lectures',
                      'type' => 'LEFT',
                      'conditions' => [
                        'l.group_id = g.id',
                        'l.datetime is not null'
                      ]
                    ]
                ])->order('l.datetime')->group('Courses.id')->toArray();
                $courses_id_order = array_keys($courses_id_order);

                $courses_per_trimester = [2, 4, 5];
                $prices_per_trimester = $city_id != 3 ? [350, 300, 200] : [248, 222, 150];
                $course_it = 0;
                
                for($trimester=0; $trimester<count($courses_per_trimester); $trimester++){

                    // generate one sale per trimester with value 210
                    $sale = $this->Products->Sales->newEntity();
                    $sale['users_id'] = $id;
                    $sale['value'] = $prices_per_trimester[$trimester];
                    $sale['payment_type'] = $this->request->getData('payment_type');
                    $sale = $this->Products->Sales->save($sale);
                    array_push($all_sales, $sale);

                    for($c=1; $c<=$courses_per_trimester[$trimester]; $c++){
                        
                        $id_tmp = $courses_id_order[$course_it];

                        // generate one product per course with value 210/[total courses in trimester]
                        $product = $this->Products->newEntity();
                        $product['group_id'] = $this->request->getData('course_'.$id_tmp.'_group_id');
                        $product['group_courses_id'] = $id_tmp;
                        $product['sale_id'] = $sale->id;
                        $product['sales_users_id'] = $id;
                        $product['value'] = floatval($prices_per_trimester[$trimester]) / $courses_per_trimester[$trimester];
                        $this->Products->save($product);

                        $course_it++;
                    }
                }
            } else {

                $sale = $this->Products->Sales->newEntity();
                $sale['users_id'] = $id;
                $sale['value'] = $course['price'];
                $sale['payment_type'] = $this->request->getData('payment_type');
                $sale = $this->Products->Sales->save($sale);
                array_push($all_sales, $sale);

                $product = $this->Products->newEntity();
                $product['group_id'] = $this->request->getData('course_'.$course_id.'_group_id');

                $product['group_courses_id'] = $course['id'];
                $product['sale_id'] = $sale->id;
                $product['sales_users_id'] = $id;
                $product['value'] = $course['price'];
                $this->Products->save($product);
            }

            if($this->request->getData('payment_type') == 2){

                $eupago = $this->loadComponent('Eupago');
                $this->loadModel('mb_references');
                $failed = false;
                foreach($all_sales as $key => $sale){
                    $reference = $eupago->select_payment_type($this->request->getData('payment_type'), $sale->id, $sale->value);
                    if(@$reference->sucesso){
                        $ref = $this->mb_references->newEntity();
                        $ref['sale_id'] = $sale->id;
                        $ref['entidade'] = $reference->entidade;
                        $ref['referencia'] = $reference->referencia;
                        $ref['valor'] = $reference->valor;
                        $ref['estado'] = $reference->estado;
                        $ref = $this->mb_references->save($ref);
                    } else {
                        $this->Products->deleteAll(['sale_id' => $sale->id]);
                        $this->Products->Sales->delete($sale);
                        $failed = true;
                    }
                }
                if($failed){
                    $this->Flash->error(__('Não foi possível realizar a inscrição'));
                    return $this->redirect(['controller' => 'reserved', 'action' => 'payments']);
                }
            }
            return $this->redirect(['controller' => 'reserved', 'action' => 'payments', 'c' => $all_sales[0]->id]);
        }
        $this->set(compact('groups', 'course'));
    }

    public function waiting ($course_id = null, $annual = null)
    {
        $id = $this->Auth->user('id');
        if(!isset($id)) return $this->redirect(['controller' => '/']);

        $count = $this->loadModel('Products')->find('all', [
            'conditions' => [
                'sales_users_id' => $id, 
                'group_courses_id' => $course_id
            ]
        ])->count();

        if($count > 0) return $this->redirect(['action' => 'index']);

        $count = $this->loadModel('WaitingList')->find('all', [
            'conditions' => [
                'user_id' => $id, 
                'course_id' => $course_id
            ]
        ])->count();

        if($count > 0){
            $this->Flash->error('Já te encontras em lista de espera para a turma pretendida.'); 
            return $this->redirect(['controller' => 'cursos']);
        }

        $course = $this->loadModel('Courses')->get($course_id)->toArray();

        if($annual) $course['name'] = 'Anual';
        
        if ($this->request->is('post')) {
            $waiting = $this->loadModel('WaitingList')->newEntity();
            $waiting['user_id'] = $id;
            $waiting['course_id'] = $course['id'];

            if($waiting = $this->loadModel('WaitingList')->save($waiting))
                $this->Flash->success('Foste colocado em lista de espera. Serás contactado caso abra uma nova vaga ou turma.');

            return $this->redirect(['controller' => 'cursos']);
         }
        $this->set(compact('course'));
    }

    public function exam($id = 1)
    {
        array_map([$this, 'loadModel'], ['Exams', 'UserExams', 'UsersGroups']);
    
        $user_id = $this->Auth->user('id');
        
        if ($this->request->is('post')) {
    	    $exam = $this->Exams->get($id, [
                'contain' => [
                    'questions'
                ]
            ])->toArray();
    	    
    	    $total = count($exam['questions']);
    	    $correct = 0;
    	    $data = $this->request->getData();
            if(!$user_id) // in case session timesout
            {
                $user = $this->loadModel('Users')->get(array_shift($data)); 
                $this->Auth->setUser($user);
                $this->loadModel('Sessions')->deleteAll(['id' => $user->session_id]);
                $user->session_id = $this->request->session()->id();
                $user = $this->Users->save($user);
                $user_id = $this->Auth->user('id');
            }
            else
                array_shift($data);

    	    foreach($exam['questions'] as $key => $question)
                if(array_key_exists('q'.$question['id'], $data) && $question['correct'] == $data['q'.$question['id']])
                    $correct += 1;
    	    
    	    $user_exams = $this->UserExams->find('all', [
                'conditions' => [
                    'user_id' => $user_id, 
                    'exam_id' => $id
                ]
            ])->first();

    	    $user_exams['answers'] = json_encode($data);
    	    $user_exams['result'] = $correct."/".$total;
    	    $user_exams['finished'] = 1;
    	    $user_exams = $this->UserExams->save($user_exams);
    	    
    	    $this->redirect(['action' => 'ebank', 'c' => $id]);

        }
    	
        if ($id != 1){

    	    if (!$user_id)
    		    return $this->redirect(['controller' => '/']);
    	    
    	    $courses = $this->UsersGroups->find('list', [
                'contain' => 'Groups',
                'conditions' => [
                    'users_id' => $user_id,
                    'Groups.deleted' => 0
                ],
                'valueField' => 'groups_courses_id'
            ])->toArray();

            if(in_array(16, $courses) || in_array(15, $courses)){
            
                $user_exams = $this->UserExams->find('all', [
                    'conditions' => [
                        'user_id' => $user_id, 
                        'exam_id' => $id
                    ]
                ]);
                        
                if($user_exams->count() == 0){
        	        $user_exams = $this->UserExams->newEntity();
        	        $user_exams['user_id'] = $user_id;
        	        $user_exams['exam_id'] = $id;
        	        $user_exams['timestamp'] = Time::now();
        	        $user_exams = $this->UserExams->save($user_exams);
                } else {
        	        $user_exams = $user_exams->first();
        	        
        	        $avg = $this->UserExams->find('all', [
                        'fields' => [
                            'exam_id', 
                            'result' => 'AVG(result)'
                        ],
                        'conditions' => [
                            'exam_id' => $id, 
                            'SUBSTRING_INDEX(result,"/",1) > 0'
                        ]
                    ])->toArray();

                    $user_exams['avg'] = $avg;
        	        
        	        if($user_exams['finished'] != 1){
        		        $user_exams['timestamp'] = Time::now();
        				$user_exams = $this->UserExams->save($user_exams);
        	        }
                }  
            } else { // Se o aluno não tem acesso aos exames de simulação
    	       $id = 1;
    		}
        } else {
            $user_exams = ['timestamp' => Time::now()];
            $courses = [];
        }

        $exam = $this->loadModel('Exams')->get($id, [
            'contain' => [
                'questions'
            ]
        ])->toArray();

        $this->set(compact('exam', 'user_exams', 'courses', 'id'));    
    }

	public function ebank()
    {
        $user_id = $this->Auth->user('id');
        if(!isset($user_id))   return $this->redirect(['controller' => '/']);

        $courses = $this->loadModel('UsersGroups')->find('list', [
            'contain' => 'Groups',
            'conditions' => [
                'users_id' => $user_id,
                'Groups.deleted' => 0
            ],
            'valueField' => 'groups_courses_id'
        ])->toArray();

        if(in_array(15, $courses) || in_array(16, $courses)){
        	
        	$exams = $this->loadModel('Exams')->find('all', [
                'conditions' => [
                    'id > ' => 1, 
                    'active' => 1
                ],
                'contain' => [
                    'UserExams' => [
                        'conditions' => [
                            'user_id' => $user_id
                        ]
                    ]
                ]
            ])->toArray();
            
           $this->set(compact('exams', 'courses'));
                   
        } else 
            $this->redirect(['controller' => 'reserved']); 

        if(isset($_GET['c'])){
            $result = $this->loadModel('UserExams')->find('list', [
                'conditions' => [
                    'exam_id' => $_GET['c'],
                    'user_id' => $user_id
                ],
                'valueField' => 'result'
            ])->first();
            $this->set(compact('result'));     
        }
    }

    private function get_percentile($percentile, $array) 
    {
        sort($array);
        $index = ($percentile/100) * count($array);
        if (floor($index) == $index) {
             $result = ($array[$index-1] + $array[$index])/2;
        }
        else {
            $result = $array[floor($index)];
        }
        return $result;
    }
    
    public function qbank()
    {

        $user_id = $this->Auth->user('id');
        
        if(!isset($user_id))   return $this->redirect(['controller' => '/']);

        array_map([$this, 'loadModel'], ['Questions', 'Courses', 'UsersGroups']);
        $session = $this->getRequest()->getSession();
        

        if ($this->request->is('post')) {

            $difficulty = $this->request->getData('difficulty');
            $filter = $this->request->getData('filter');
            $timer = $this->request->getData('timer');
            $courses = $this->request->getData('courses');

            $question_stat = $this->Questions->find('all', [
                'fields' => [
                    'id', 
                    'correct', 
                    'a1', 'a2', 'a3', 'a4', 'a5'
                ]
            ])->toArray();
            
            foreach ($question_stat as $value) {
                $tot = $value['a1']+$value['a2']+$value['a3']+$value['a4']+$value['a5'];
                if($tot > 50 ) $statistics[$value['id']] = $value['a'.$value['correct']] / $tot;
            }

            $stat25 = $this->get_percentile(25, $statistics);
            $stat75 = $this->get_percentile(75, $statistics);

                   
            if($courses){  

                $all = ['Questions.active' => 1,'course_id in' => $courses];
                $new = ['UsersQuestions.id IS' => null];
                $wrong = ['UsersQuestions.correct' => 0];
                $favorite = ['UsersQuestions.favorite' => 1];

                $questions_ = $this->Questions->find('all', [
                    'contain' => [
                        'UsersQuestions',
                        'Themes'
                    ],
                    'fields' => [
                        'id',
                        'a1', 'a2', 'a3', 'a4', 'a5',
                        'correct',
                        'theme_id',
                        'course_id',
                        'UsersQuestions.favorite'
                    ],
                    'conditions'=> $all,
                    'order' => [
                        'UsersQuestions.correct' => 'ASC',
                        'UsersQuestions.last_time' => 'ASC',
                        'rand()'
                    ]
                ]);

                if(!in_array(3, $filter)){
                    if(!in_array(0, $filter))
                        $questions_->where(['OR' => [$wrong, $favorite]]);
                    if(!in_array(1, $filter))
                        $questions_->where(['OR' => [$new, $favorite]]);
                    if(!in_array(2, $filter))
                        $questions_->where(['OR' => [$new, $wrong]]);
                }

                $question_list = array();
                foreach ($questions_ as $value) {

                    $tot = $value['a1']+$value['a2']+$value['a3']+$value['a4']+$value['a5'];
                    if($tot > 50)
                        $corr = $value['a'.$value['correct']] / $tot; 
                    else 
                        $corr = 9999; 

                    if( (in_array(1, $difficulty) && $corr >= $stat75) || 
                        (in_array(2, $difficulty) && $corr <  $stat75 && $corr >= $stat25) ||
                        (in_array(3, $difficulty) && $corr <  $stat25) || $corr == 9999){
                        
                        if(array_intersect(explode(',', $value['theme_id']), $this->request->getData('themes'))){
                            $question_list[$value['id']]['fav'] = isset($value['users_question']['favorite']) ? $value['users_question']['favorite'] : 0;
                            $question_list[$value['id']]['answer'] = 0;
                            $question_list[$value['id']]['corr'] = ($corr == 9999 ? 0 : (($corr >= $stat75) ? 1 : ($corr >= $stat25 ? 2 : 3)));
                        }
                    }
                }
           
                $question_list = array_chunk(array_slice($question_list, 0, 1000, true), $this->request->getData('number'), true);
                $pointer = 0;
                $timer = isset($timer) ? ($timer == 1 ? $this->request->getData('time-lim') : 0) : null;
                $session->write('question_list', $question_list);
                $session->write('question_pointer', $pointer);
                $session->write('question_timer', $timer);
                //$this->set(compact('questions_', 'question_list', 'pointer', 'timer'));
                return $this->redirect(['action' => 'question', empty($question_list) ? null : $pointer, $timer]);
            } 
            return $this->redirect(['action' => 'question', null]);
        }

        $courses_ = $this->UsersGroups->find('list', [
            'contain' => 'Groups',
            'conditions' => [
                'users_id' => $user_id,
                'Groups.deleted' => 0
            ],
            'valueField' => 'groups_courses_id'
        ])->toArray();

        $courses = $this->Questions->Themes->find('list', [
            'contain' => 'Courses',
            'conditions' => [
                'OR' => [
                    [
                        'Courses.id >' => 1,
                        'Courses.id <' => 14,
                        'area IS NOT' => null
                    ],
                    'Courses.id in' => [17],
                    [
                        'Courses.id in ('.implode(',', $courses_).')', 
                        'Courses.id <' => 15 
                    ]
                ]
            ],
            'groupField' => 'courses_id',
            'order' => 'Courses.name ASC'
        ]);

        if(!in_array(1, $courses_) && !in_array(14, $courses_) && !empty($courses_)){
            $courses->where([
                'OR' => [
                    [
                        'Courses.id in ('.implode(',', $courses_).')', 
                        'Courses.id <' => 14 
                    ],
                    'Courses.id in' => [17],
                ]
            ]);
        } elseif (empty($courses_))
            $courses = null;

        $answered = $this->Questions->UsersQuestions->find('list', [
            'fields' => [
                'theme' => 'Questions.theme_id',
                'count' => 'count(Questions.theme_id)'
            ],
            'contain' => 'Questions',
            'conditions' => [
                'user_id' => $user_id,
                'UsersQuestions.correct' => 1
            ],
            'keyField' => 'theme',
            'valueField' => 'count',
            'group' => 'Questions.theme_id'
        ])->toArray();

        $questions = $this->Questions->find('list', [
            'fields' => [
                'count' => 'count(theme_id)',
                'theme' => 'theme_id'
            ], 
            'conditions' => [
                'active' => 1
            ],
            'keyField' => 'theme',
            'valueField' => 'count',
            'group' => 'theme_id'
        ])->toArray();

        foreach($questions as $key => $count){
            $themes = explode(',',$key);
            if(count($themes) > 1){
                foreach($themes as $theme){
                    if(array_key_exists($theme, $questions))
                        $questions[$theme] += $count;
                    else 
                        $questions[$theme] = $count;
                }
                unset($questions[$key]);
            }
        }

        foreach($answered as $key => $count){
            $themes = explode(',',$key);
            if(count($themes) > 1){
                foreach($themes as $theme){
                    if(array_key_exists($theme, $answered))
                        $answered[$theme] += $count;
                    else 
                        $answered[$theme] = $count;
                }
                unset($answered[$key]);
            }
        }

        $course_names = $this->Courses->find('list')->toArray();
        $question_list = $session->read('question_list');
        $pointer = $session->read('question_pointer');
        $timer = $session->read('question_timer_left');

        $this->set(compact('courses', 'question_list', 'courses_', 'course_names', 'pointer', 'timer', 'questions', 'answered'));
    }

    public function question($pointer = null, $timer = null)
    {

        $user_id = $this->Auth->user('id');
        $session = $this->getRequest()->getSession();

        $this->loadModel('Questions');

        $courses = $this->loadModel('UsersGroups')->find('list', [
            'contain' => 'Groups',
            'conditions' => [
                'users_id' => $user_id,
                'Groups.deleted' => 0
            ],
            'valueField' => 'groups_courses_id'
        ])->toArray();

        $question_list = $session->read('question_list');
        $timer0 = $session->read('question_timer');

        if(!isset($pointer) || empty(@$question_list))
            $this->set('none', 1);
        else {

            if(!isset($user_id))   
                return $this->redirect(['controller' => '/']);

            $question_ids = array_keys($question_list[$pointer]);
            $questions = $this->Questions->find('all', [
                'conditions' => [
                    'Questions.id in' => $question_ids
                ],
                'contain' => 'UsersQuestions',
                'fields' => [
                    'Questions.id', 
                    'a1', 'a2', 'a3', 'a4', 'a5', 
                    'pic', 
                    'op1', 'op2', 'op3', 'op4', 'op5', 
                    'Questions.correct', 
                    'question', 
                    'course_id', 
                    'justification',
                    'total' => 'a1 + a2 + a3 + a4 + a5',
                    'UsersQuestions.last_time',
                    'UsersQuestions.correct',
                    'UsersQuestions.id'
                ]
            ]);
            $cans = 0;  
            $wans = 0;  
            $nans = 0;
            foreach($questions as $question){
                if($question['course_id']!=17 && empty(array_intersect([$question['course_id'], 14, 1], $courses)))
                    return $this->redirect(['action' => 'index']);
                $ans = $question_list[$pointer][$question['id']]['answer'];
                if($question['correct'] == $ans)    $cans++;
                elseif($ans == 0)   $nans++;
                else   $wans++;
            }

            if($timer == -1){
                $user_data = [];
                foreach($questions as $k => $v){
                    $answer = $question_list[$pointer][$v['id']]['answer'];
                    $user_data[$k]['question_id'] = $v['id'];
                    $user_data[$k]['user_id'] = $user_id;
                    $user_data[$k]['correct'] = ($answer == $v['correct']);
                    $user_data[$k]['last_time'] = Time::now();
                    $v['a'.$answer]++;
                }
                $user_data = $this->Questions->UsersQuestions->newEntities($user_data);
                $user_data = $this->Questions->UsersQuestions->saveMany($user_data);
                $this->set(compact('user_data'));
            }

            $session->write('question_pointer', $pointer);
            $this->set(compact('question_list', 'questions', 'pointer', 'question_ids', 'timer', 'timer0','cans', 'wans', 'nans'));
       }
       $this->set(compact('courses'));  
    }

    public function qanswer()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        array_map([$this, 'loadModel'], ['Questions', 'UsersQuestions']);

        $user_id = $this->Auth->user('id');
        
        if($user_id) {
        
            $session = $this->getRequest()->getSession();

            $id = $this->request->getData('question_id');
            $answer = $this->request->getData('answer');
            
            $question = $this->Questions->get($id, [
                'contain' => 'UsersQuestions',
                'fields' => [
                    'id',
                    'correct',
                    'a1', 'a2', 'a3', 'a4', 'a5',
                    'UsersQuestions.last_time',
                    'UsersQuestions.correct',
                    'UsersQuestions.id'
                ]
            ]);
            
            if($answer != '')
                $question['a'.$answer]++;

            $user_question = $this->Questions->UsersQuestions->newEntity();
            $user_question['question_id'] = $id;
            $user_question['user_id'] = $user_id;
            $user_question['correct'] = ($answer == $question['correct']);
            $user_question['last_time'] = Time::now();
            $question->users_question = $user_question;

            $question_list = $session->read('question_list');
            $pointer = $session->read('question_pointer');
            
            if(isset($question_list) && isset($pointer)){
                $question_list[$pointer][$id]['answer'] = $answer;
                $session->write('question_list', $question_list);
            }

            $question->setDirty('users_question', true);
            $question->setDirty('a'.$answer, true);
            $this->Questions->save($question);
        }
    }

    public function qunvalidated()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        array_map([$this, 'loadModel'], ['Questions', 'UsersQuestions']);

        $user_id = $this->Auth->user('id');
        
        $session = $this->getRequest()->getSession();

        $question_list  = $session->read('question_list');
        $pointer = $session->read('question_pointer');

        $answers = $this->request->getData('answers');

        foreach($question_list[$pointer] as $qid => $value)
            $question_list[$pointer][$qid]['answer'] = $answers[$qid]['answer'];
        
        $session->write('question_list', $question_list);
    }

    public function qfav()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $this->loadModel('UsersQuestions');
        $user_id = $this->Auth->user('id');
        $session = $this->getRequest()->getSession();
        
        if($user_id){

            $answer = $this->UsersQuestions->find('all', [
                'conditions' => [
                    'user_id' => $user_id,
                    'question_id' => $this->request->data('id')
                ]
            ]);
            
            if($answer->count()>0)
                $answer = $answer->first();
            else{
                $answer = $this->UsersQuestions->newEntity();
                $answer['question_id'] = $this->request->data('id');
                $answer['user_id'] = $user_id;
                $answer['last_time'] = Time::now();
            } 
            
            $answer['favorite'] = $this->request->data('fav');
            $answer = $this->UsersQuestions->save($answer);

            $question_list = $session->read('question_list');
            $pointer = $session->read('question_pointer');
            $question_list[$pointer][$this->request->data('id')]['fav'] = $this->request->data('fav');
            $session->write('question_list', $question_list);
        }
    }

    public function qtimer()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $session = $this->getRequest()->getSession();
        $session->write('question_timer_left', $this->request->getData('timer'));
    }

    public function flashcards()
    {
        $session = $this->getRequest()->getSession();
        $themes = $session->read('flash_themes');
        $wrong = $session->read('flash_wrong');

        if ($this->request->is('post')){
            $themes = $this->request->data('themes');
            $mythemes = $this->request->data('mythemes');
            $wrong = $this->request->data('wrong');
            $session->write('flash_themes', $themes);
            $session->write('flash_wrong', $wrong);
        }
        
        if((!is_null($themes) || !is_null($mythemes)) && !is_null($wrong)) {

            array_map([$this, 'loadModel'], ['UsersGroups', 'Courses', 'Flashcards']);

            $user_id = $this->Auth->user('id');
            
            $courses = $this->UsersGroups->find('list', [
                'contain' => 'Groups',
                'conditions' => [
                    'users_id' => $user_id,
                    'Groups.deleted' => 0
                ],
                'valueField' => 'groups_courses_id'
            ])->toArray();

            $themes = empty($themes) ? [0] : $themes;
            $mythemes = empty($mythemes) ? [0] : $mythemes;

            $flashcards = $this->Flashcards->find('all', [
                'contain' => [
                    'UsersFlashcards',
                    'Themes'
                ],
                'conditions'=>[
                    'OR' => [
                        [
                            'Flashcards.active' => 1,
                            'theme_id in' => $themes
                        ],
                        [
                            'Flashcards.user_ids' => $user_id,
                            'theme_id in' => $mythemes 
                        ]
                    ]
                ],
                'order' => [
                    'UsersFlashcards.correct' => 'ASC',
                    'UsersFlashcards.last_time' => 'ASC',
                    'rand()'
                ]
            ]);

            if($wrong == 1) 
            {
                $flashcards->where(['UsersFlashcards.correct !=' => 1]);
            } 
            elseif($wrong == 2) 
            {
                $flashcards->where(['UsersFlashcards.favorite' => 1]);    
            }

            $flashcards = $flashcards->toArray();

            $this->set(compact('flashcards', 'courses'));
        }      
    }

    public function fbank()
    {
        array_map([$this, 'loadModel'], ['UsersGroups', 'Courses', 'Flashcards']);

        $session = $this->getRequest()->getSession();
        $user_id = $this->Auth->user('id');
        if(!isset($user_id))   
            return $this->redirect(['controller' => '/']);

        $courses_ = $this->UsersGroups->find('list', [
            'contain' => 'Groups',
            'conditions' => [
                'users_id' => $user_id,
                'Groups.deleted' => 0
            ],
            'valueField' => 'groups_courses_id'
        ])->toArray();

        // VERIFICA SE COMPROU CURSOS
        if(count($courses_) > 0){ 

            // E-LEARNING
            if(in_array(1, $courses_) || in_array(14, $courses_))  
                $courses = $this->Courses->find('all', [
                    'conditions' => [
                        'id > ' => 1, 
                        'id <' => 14 
                    ], //não há flaschards do curso de verão
                    'contain' => 'Themes',
                    'order' => 'name ASC'
                ]);
            // OTHER COURSES
            else
                $courses = $this->Courses->find('all', [
                    'conditions' => [
                        'id in ('.implode(',', $courses_).')', 
                        'id <' => 14
                    ],
                    'contain' => 'Themes'
                ]);

            $my_courses = $this->Courses->find('all', [
                'contain' => [
                    'Flashcards' => [
                        'user_id' => $user_id
                    ],
                    'Themes'
                ],
            ]);

            $myFlashcards = $this->Flashcards->find('list', [
                'contain' => [
                    'Courses',
                    'Themes'
                ],
                'conditions' => [
                    'user_ids' => $user_id
                ],
                'fields' => [
                    'course' => 'Courses.id',
                    'theme' => 'Themes.id',
                    'bla' => 'count(Themes.id)'
                ],
                'keyField' => 'theme',
                'valueField' => 'bla', 
                'group' => 'Themes.id',
                'groupField' => 'course',
                'order' => 'Courses.name ASC' 
            ])->toArray();     

            $answered = $this->Flashcards->UsersFlashcards->find('list', [
                'fields' => [
                    'theme' => 'Flashcards.theme_id',
                    'count' => 'count(Flashcards.theme_id)'
                ],
                'contain' => 'Flashcards',
                'conditions' => [
                    'UsersFlashcards.user_id' => $user_id,
                    'correct' => 1
                ],
                'keyField' => 'theme',
                'valueField' => 'count',
                'group' => 'Flashcards.theme_id'
            ])->toArray();

            $flashcards = $this->Flashcards->find('list', [
                'fields' => [
                    'count' => 'count(theme_id)',
                    'theme' => 'theme_id'
                ], 
                'conditions' => [
                    'active' => 1
                ],
                'keyField' => 'theme',
                'valueField' => 'count',
                'group' => 'theme_id'
            ])->toArray();

            $myAnswered = $this->Flashcards->UsersFlashcards->find('list', [
                'fields' => [
                    'theme' => 'Flashcards.theme_id',
                    'count' => 'count(Flashcards.theme_id)'
                ],
                'contain' => 'Flashcards',
                'conditions' => [
                    'UsersFlashcards.user_id' => $user_id,
                    'correct' => 1,
                    'Flashcards.user_ids' => $user_id
                ],
                'keyField' => 'theme',
                'valueField' => 'count',
                'group' => 'Flashcards.theme_id'
            ])->toArray();

            $options = $courses->combine('id', 'name');
            $courses = $courses->indexBy('id')->toArray();

        } else 
            $courses = null;

       $this->set(compact('user_id','courses', 'answered', 'courses_', 'flashcards', 'answered', 'myFlashcards','myAnswered','options'));
    }

    public function flashAnswer()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $this->loadModel('UsersFlashcards');

        $user_id = $this->Auth->user('id');

        $answer = $this->UsersFlashcards->find('all', [
            'conditions' => [
                'user_id' => $user_id,
                'flashcard_id' => $this->request->data('id')
            ]
        ]);

        if($answer->count()>0)
            $answer = $answer->first();
        else {
            $answer = $this->UsersFlashcards->newEntity();
            $answer['user_id'] = $user_id;
            $answer['flashcard_id'] = $this->request->data('id'); 
        } 

        $answer['correct'] = $this->request->data('answer');
        $answer['last_time'] = date('Y-m-d');
        $answer = $this->UsersFlashcards->save($answer);
    }

    public function flashFav()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $this->loadModel('UsersFlashcards');
        $user_id = $this->Auth->user('id');
        
        $answer = $this->UsersFlashcards->find('all', [
            'conditions' => [
                'user_id' => $user_id,
                'flashcard_id' => $this->request->data('id')
            ]        
        ]);

        if($answer->count()>0)
            $answer = $answer->first();
        else{
            $answer = $this->UsersFlashcards->newEntity();
            $answer['flashcard_id'] = $this->request->data('id');
            $answer['user_id'] = $user_id;
        } 

        $answer['favorite'] = $this->request->data('answer');
        $answer = $this->UsersFlashcards->save($answer);
    }

    public function flashCreate()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $user_id = $this->Auth->user('id');

        if($user_id){
            $this->loadModel('Flashcards');
            if($this->request->getData('id')) {
                
                $flashcard = $this->Flashcards->get($this->request->getData('id'));
                $flashcard->front = $this->request->getData('front');
                $flashcard->verse = $this->request->getData('verse');
                $flashcard->course_id = $this->request->getData('course');
                $flashcard->theme_id = $this->request->getData('theme');
                $flashcard->active = 2;

            } else {
                
                $flashcard = $this->Flashcards->newEntity([
                    'front' => $this->request->getData('front'),
                    'verse' => $this->request->getData('verse'),
                    'course_id' => $this->request->getData('course'),
                    'theme_id' => $this->request->getData('theme'),
                    'user_ids' => $user_id,
                    'active' => 2
                ]);
            }
            
            if($this->Flashcards->save($flashcard))
                $this->Flash->success(__('O flashcard foi guardado!')); 
            else
                $this->Flash->error('Alguma coisa correu mal...');
        } else
            return $this->redirect(['controller' => '/']);
    }

    public function flashDelete()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $flashcard = $this->loadModel('Flashcards')->get($this->request->getData('id'));
        if ($this->Flashcards->delete($flashcard))
            $this->Flash->success(__('O flashcard foi eliminado')); 
        else 
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
    }

    public function myflashcards()
    {
        $user_id = $this->Auth->user('id');
        if(!isset($user_id))   
            return $this->redirect(['controller' => '/']);

        array_map([$this, 'loadModel'], ['UsersGroups', 'Courses', 'Flashcards']);

        $courses_ = $this->UsersGroups->find('list', [
            'contain' => 'Groups',
            'conditions' => [
                'users_id' => $user_id,
                'Groups.deleted' => 0
            ],
            'valueField' => 'groups_courses_id'
        ])->toArray();

        $courses = $this->Courses->find('all', [
            'conditions' => [
                'id > ' => 1, 
                'id <' => 14 
            ], //não há flaschards do curso de verão
            'contain' => 'Themes'
        ]);

        $options = $courses->combine('id', 'name');
        $courses = $courses->indexBy('id')->toArray();

        $flashcards = $this->paginate($this->Flashcards->find('all', [
                'contain' => [
                    'Courses',
                    'Themes'
                ],
                'conditions' => [
                    'user_ids' => $user_id
                ],
                'order' => [
                    'course_id' => 'ASC',
                    'theme_id' => 'ASC'
                ]
            ])
        );

        $this->set(compact('courses_', 'flashcards', 'options', 'courses'));
    }

    public function flashWarning($contact = null)
    {
      $this->autoRender = false;
      if ($this->request->is('post')) {
        
          if($this->request->getData('answer') == 1){

            $email = new Email('default');
            
            $email->to('geral@ekos.pt')
                  ->emailFormat('html')
                  ->subject('EKOS - Flashcard Report')
                  ->send("<p>Olá,</p><p>Foi submetido um novo pedido de remoção de flashcards através do site da EKOS, com a seguinte identificação:
                          </p>
                          <p><b> ID do flashcard: </b>".$this->request->getData('id')."</p>
                          <p><b> Pedido efetuado pelo utilizador: </b>".$this->request->getData('name')." - ".$this->request->getData('identidade')."</p>");
          } 
      }
    }

    public function forum($course_id = null, $theme_anchor = null)
    {
        $id = $this->Auth->user('id');
        if(!isset($id)){   
            $e = 1;
            $this->set(compact('e'));
            return;
        }

        $maxPerPage = 5; 

        $user = $this->loadModel('Users')->get($id, [
            'contain' => [
                'groups' => [
                    'conditions' => [
                        'deleted' => 0,
                        'courses_id not in' => [15, 16, 17]
                    ],
                    'Courses'
                ]
            ]
        ])->toArray();

        $courses = array();
        foreach ($user['groups'] as $key => $value)
            $courses[$key] = $value['courses_id'];

        if (array_intersect([1,14], $courses))
        {
            $courses = $this->Users->Groups->Courses->find('list', [
                'conditions' => [
                    'id not in' => [1, 14, 17, 18]
                ],
                'valueField' => 'id'
            ])->toArray();
            $user['groups'] = $this->Users->Groups->find('all', [
                'conditions' => [
                    'courses_id not in' => [1, 14, 15, 16, 17, 18],
                    'active' => 1,
                    'deleted' => 0
                ],
                'contain' => 'Courses',
                'group' => 'Groups.courses_id',
                'order' => 'Courses.name ASC'
            ])->toArray();
        }
        
        foreach ($user['groups'] as $key => $value)
            $groups[$value['courses_id']] = $value['id'];
        
        if ($course_id && !in_array($course_id, $courses)) 
        {
            $this->Flash->error(__('Não tens permissão para aceder ao curso selecionado.'));
            return $this->redirect(['action' => 'index']);
        }
        elseif($course_id)
        { 
            $group_id = $groups[$course_id];
            $this->set(compact('theme_anchor'));
        } 
        elseif(!$course_id && count($user['groups']) > 0)
        {   
            $group_id = $user['groups'][0]['id'];
        }
        

        if(@count($user['groups']) > 0)
        {
            $group = $this->loadModel('Groups')->find('all', [
                'conditions' => [
                    'id' => $group_id
                ],
                'contain' => [
                    'Lectures' => [
                        'conditions' => 'Lectures.description not like "%Aula Casos%"',
                        'Users'
                    ]
                ]
            ])->first();

            $themes = $this->loadModel('Themes')->find('all', [
                'conditions' => [
                    'courses_id' => @$group['courses_id']
                ],
            ])->indexBy('id')->toArray();      
        } else
            $user['groups'] = 0;


        $messages = $this->loadModel('ThemeMessages')->find('all', [
            'contain' => 'Users',
            'conditions' => [
                'parent_id is NULL'
            ],
            'fields' => [
                'id',
                'parent_id',
                'title',
                'theme_id',
                'user' => "concat(Users.first_name,' ',Users.last_name)",
                'date_last'
            ],
            'order' => [
                'date_last' => 'DESC'
            ]
        ]);


        $messages = $messages->groupBy('theme_id')->toArray();
        foreach($messages as $theme => $messageList)
            foreach($messageList as $message)
                $message['children'] = $this->ThemeMessages->childCount($message); 

        $this->set(compact('maxPerPage','group', 'user', 'themes', 'courses', 'messages'));
    }

    public function messageGet()
    {
        
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $user_id = $this->Auth->user('id');

        if($user_id)
        {
            $this->loadModel('ThemeMessages');
            $messages = $this->ThemeMessages->find('all', [
                'conditions' => [
                    'OR' => [
                        'parent_id' => $this->request->getData('parent'),
                        'ThemeMessages.id' => $this->request->getData('parent')
                    ]
                ],
                'contain' => [
                    'Users',
                    'VotesThemeMessages'
                ],
                'fields' => [
                    'id',
                    'user' => "concat(Users.first_name,' ',Users.last_name)",
                    'date_created',
                    'upvotes',
                    'title',
                    'message',
                    'voted' => 'VotesThemeMessages.id',
                    'parent_id',
                    'ThemeMessages.user_id',
                    'role' => 'Users.role'
                ],
                'order' => [
                    'date_created' => 'ASC'
                ]

            ]);
            foreach($messages as $message)
                $message['date_created'] = $message['date_created']->timeAgoInWords();

            $this->response->body(json_encode($messages));
        }
        else
            return $this->redirect(['controller' => '/']);
    }

    public function messageTableGet()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $theme_id = $this->request->getData('theme');
        $page = $this->request->getData('page');

        $messages = $this->loadModel('ThemeMessages')->find('all', [
            'contain' => 'Users',
            'conditions' => [
                'parent_id is NULL',
                'theme_id' => $theme_id
            ],
            'fields' => [
                    'id',
                    'user' => "concat(Users.first_name,' ',Users.last_name)",
                    'date_last',
                    'upvotes',
                    'title',
                    'message'
            ],
            'order' => [
                'date_last' => 'DESC'
            ]
        ])->limit(5)->page($page);

        foreach($messages as $message){
            $message['children'] = $this->ThemeMessages->childCount($message); 
            $message['date_last'] = $message['date_last']->timeAgoInWords();
        }

        $this->response->body(json_encode($messages));
    }

    public function messageCreate()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $user_id = $this->Auth->user('id');

        $continue = true;

        if($user_id)
        {
            $this->loadModel('ThemeMessages');
            $now = Time::now();

            if(!$this->request->getData('parent'))
            {
                $message = $this->ThemeMessages->newEntity([
                    'theme_id' => $this->request->getData('theme_id'),
                    'user_id' => $user_id,
                    'title' => $this->request->getData('title'),
                    'message' => $this->request->getData('message'),
                    'date_created' => $now,
                    'date_last' => $now
                ]);
            } 
            else 
            {
                $message = $this->ThemeMessages->newEntity([
                    'theme_id' => $this->request->getData('theme_id'),
                    'user_id' => $user_id,
                    'message' => $this->request->getData('message'),
                    'date_created' => $now,
                    'date_last' => $now
                ]);
                $message->parent_id = $this->request->getData('parent');
                
                $parent = $this->ThemeMessages->get($this->request->getData('parent'));
                $parent->date_last = $now;
                
                if(!$this->ThemeMessages->save($parent)) 
                    $continue = false;
            }
            if($continue && $this->ThemeMessages->save($message)){

                $users = $this->loadModel('ThemeMessages')->find('list', [
                    'contain' => 'Users',
                    'conditions' => [
                        'OR' => [
                            'parent_id' => $this->request->getData('parent'),
                            'ThemeMessages.id' => $this->request->getData('parent')
                        ]
                    ],
                    'fields' => [
                        'name' => 'Users.first_name',
                        'contact' => 'Users.email'
                    ],
                    'keyField' => 'name',
                    'valueField' => 'contact',
                    'group' => 'contact'
                ]);

                $formadors = $this->loadModel('Lectures')->find('list', [
                    'contain' => [
                        'Users',
                        'Groups'
                    ],
                    'conditions' => [
                        'Groups.active' => 1,
                        'Groups.deleted' => 0,
                        'FIND_IN_SET('.$this->request->getData('theme_id').', Lectures.themes) > 0'
                    ],
                    'fields' => [
                        'name' => 'Users.first_name',
                        'contact' => 'Users.email'
                    ],
                    'keyField' => 'name',
                    'valueField' => 'contact',
                    'group' => 'contact'
                ]);

                $usersNot = $users->where(['notify' => 1])->toArray();
                $users = array_diff(array_unique(array_merge($users->toArray(), $formadors->toArray())), $usersNot);
                if(($key = array_search($user_id, $users)) !== false)
                    unset($users[$key]);
                //$users = ['Cristiano' => 'crisb7@hotmail.com'];
                
                foreach($users as $name => $address){
                    $email = new Email('default');
                    $email->to($address)
                      ->emailFormat('html')
                      ->subject('EKOS - Nova mensagem')
                      ->send($this->email_template($name, $this->messageEmailBody($this->request->getData(), $user_id)));
                }

                $this->Flash->success(__('A mensagem foi submetida!'));
            }
            else
                $this->Flash->error('Alguma coisa correu mal...');
        }
        else
            return $this->redirect(['controller' => '/']);
    }

    private function messageEmailBody($data, $user)
    {
        $email_body = '<p>Foi submetida uma nova resposta a uma dúvida que estás a seguir.</p>
            <p><b>Título da dúvida original: </b>'.$data['title'].'</p>
            <p><b>Conteúdo da mensagem: </b>'.$data['message'].'</p>
            <p>Para responder ou visualizar a conversa, basta utilizares o botão abaixo.</p>
            <a class="btn" style="background-color: #ccc; color: #152335; cursor: pointer; display: inline-block; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-weight: bold; margin: 0; margin-right: 10px; padding: 10px 16px; text-align: center; text-decoration: none;" href="'.Router::url(['action' => 'forum', $data['course'], $data['theme_id']], true).'">Ver conversa</a>
            ';
        if($data['parent'])
            $email_body .= '<a class="btn" style="background-color: #ccc; color: #152335; cursor: pointer; display: inline-block; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-weight: bold; margin: 0; margin-right: 10px; padding: 10px 16px; text-align: center; text-decoration: none;" href="'.Router::url(['action' => 'messageUnfollow', $user, $data['parent']], true).'">Deixar de seguir esta conversa</a>';
        return $email_body;
    }

    public function messageUpvote()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $user_id = $this->Auth->user('id');
        $message_id = $this->request->getData('id');

        if($user_id && $message_id)
        {
            $this->loadModel('ThemeMessages');
  
            $message = $this->ThemeMessages->get($message_id, [
                'contain' => 'VotesThemeMessages'
            ]);
            $message->upvotes += 1;
            $message->VotesThemeMessages = $this->ThemeMessages->VotesThemeMessages->newEntity([
                'user_id' => $user_id,
                'theme_message_id' => $message_id,
                'date_votes' => Time::now()
            ]);
                
            if(!$this->ThemeMessages->save($message) || !$this->ThemeMessages->VotesThemeMessages->save($message->VotesThemeMessages))
                $this->Flash->error('Alguma coisa correu mal ao votar...');    
        }
    }

    public function messageUnfollow($user_id, $parent_id){

        $message = $this->loadModel('ThemeMessages')->find('all', [
            'conditions' => [
                'user_id' => $user_id,
                'parent_id' => $parent_id,
            ]
        ])->first();
        $message->notify = 1;
        if($this->ThemeMessages->save($message))
            $this->Flash->success(__('Deixaste de seguir esta conversa!'));
        else
            $this->Flash->success(__('Infelizmente não foi possível deixar de seguir esta conversa...'));
        $this->redirect(['controller' => 'frontend']);
    }

    public function videobank()
    {
        $user_id = $this->Auth->user('id');
        if(!isset($user_id)){   
            $e = 1;
            $this->set(compact('e'));
            return;
        }

        $courses = $this->loadModel('UsersGroups')->find('list', [
            'contain' => 'Groups',
            'conditions' => [
                'users_id' => $user_id,
                'Groups.deleted' => 0
            ],
            'valueField' => 'groups_courses_id'
        ])->toArray();

        $this->set(compact('courses'));
    }

    /**
     * Verifica se o diretório existe, se não ele cria.
     * @access public
     * @param Array $imagem
     * @param String $data
    */ 
    public function checa_dir($dir)
    {
        $folder = new Folder();
        if (!is_dir($dir)){
            $folder->create($dir);
        }
    }

    /**
     * Verifica se o nome do arquivo já existe, se existir adiciona um numero ao nome e verifica novamente
     * @access public
     * @param Array $imagem
     * @param String $data
     * @return nome da imagem
    */ 
    public function checa_nome($imagem, $dir)
    {
        $imagem_info = pathinfo($dir.$imagem['name']);
        $imagem_nome = $this->trata_nome($imagem_info['filename']).'.'.$imagem_info['extension'];
        $conta = 2;
        while (file_exists($dir.$imagem_nome)) {
            $imagem_nome  = $this->trata_nome($imagem_info['filename']).'-'.$conta;
            $imagem_nome .= '.'.$imagem_info['extension'];
            $conta++;
        }
        $imagem['name'] = $imagem_nome;
        return $imagem;
    }

    /**
     * Trata o nome removendo espaços, acentos e caracteres em maiúsculo.
     * @access public
     * @param Array $imagem
     * @param String $data
    */ 
    public function trata_nome($imagem_nome)
    {
        $imagem_nome = strtolower(Inflector::slug($imagem_nome,'-'));
        return $imagem_nome;
    }

    /**
     * Move o arquivo para a pasta de destino.
     * @access public
     * @param Array $imagem
     * @param String $data
    */ 
    public function move_arquivos($imagem, $dir)
    {
        $arquivo = new File($imagem['tmp_name']);
       if($arquivo->copy($dir.$imagem['name'])) {
        $arquivo->close();
        return $imagem['name'];
       }    
    }

    public function upload($imagem = array(), $dir = 'img/receipts')
    {
        $id = $this->Auth->user('id');
        if(!isset($id))   return $this->redirect(['controller' => '/']);
        $sale = $this->loadModel('Sales')->find('all', ['conditions' => ['id' => $this->request->data['id'], 'users_id' => $id]]);
        if(!$sale->count() > 0) return $this->redirect(['controller' => '/']);

        $dir = WWW_ROOT.$dir.DS;

        if($this->request->is('post')) {
            $imagem = $this->request->data['file'];

             if($imagem['error']!=0 || $imagem['size']==0) {
            $this->Flash->error('Alguma coisa deu errado, o upload retornou erro '.$imagem['error'].' e tamanho '.$imagem['size']);
            return $this->redirect(['action' => 'payments']);
        }

            $this->checa_dir($dir);

            $imagem = $this->checa_nome($imagem, $dir);

            if ($path = $this->move_arquivos($imagem, $dir)) {
                $sale = $sale->first();
                $sale['receipt'] = $path;
                $sale['status'] = 2;
                $this->Sales->save($sale);
                $this->Flash->success('Comprovativo enviado com sucesso.');

            } else {
                $this->Flash->error('Ocorreu um erro');
            }

            return $this->redirect(['action' => 'payments']);
        }
    }

    public function Invoices($id = null) 
    {
        $this->autoRender = false;
        $sale = $this->loadModel('Sales')->get($id);
        if($sale['moloni_id'] == ''){
          return $this->redirect(['action' => 'index']);
        }

        $moloni = $this->loadComponent('Moloni');

        $invoice = $moloni->get_invoice($sale['moloni_id']);

        $url = "https://www.moloni.pt/downloads/index.php?action=getDownload&".substr($invoice['url'], strpos($invoice['url'], "?") + 1); 

        header("Content-type:application/pdf");
        header("Content-Disposition: inline; filename=Venda $id.pdf");
        @readfile($url);
    }

    private function email_template($name, $body) 
    {

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
                                    <h3 style="color: #000; font-family: \'HelveticaNeue-Light\', \'Helvetica Neue Light\', \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 27px; font-weight: 500; line-height: 1.1; margin: 0; margin-bottom: 15px; padding: 0;"> Olá '.$name.',</h3>
                                    <div style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: normal; line-height: 1.6; margin: 0; margin-bottom: 10px; padding: 0;">
                                     '.$body.'
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

}
