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
        
        $groups = array();
        foreach ($user['groups'] as $key => $value) {
            $groups[$key] = $value['id'];
        }

        if($group_id != null && !in_array($group_id, $groups)){
            $this->Flash->error(__('Não tens permissão para aceder ao curso selecionado.'));
            return $this->redirect(['action' => 'index']);
        } elseif($group_id == null && !count($user['groups']) > 0) {
            $user['groups'] = 0;
        } elseif($group_id == null) {
            $group_id = $user['groups'][0]['id'];
        }

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
            'contain' => ['groups' => ['Courses']]
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
            'conditions' => ['Groups.id' => $group_id],
            'contain' => ['Lectures' => ['Users'], 'Courses']
        ])->first();

        $themes_ = $this->loadModel('Themes')->find('all', [
        'conditions' => ['courses_id' => $group['courses_id']]
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
                'conditions' => ['users_id' => $id ],
                'contain' => ['Products' => ['Groups' => ['Courses']], 'Mb_references']
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
        
        array_map([$this, 'loadModel'], ['Products']);

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
             
            // ids of annual courses selection
            $courses = [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];

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
            $course['price'] = 840;
            $course['name'] = 'Curso Anual';
        }
        if ($this->request->is('post')) {

            $posted = $this->request->getData();
            $group_id = $this->request->getData('group_id');
            $all_sales = [];

            if($annual){

                $courses_id_order = [10, 4, 5, 6, 11, 8, 3, 7, 9, 12, 13]; 
                $courses_per_trimester = [2, 2, 3, 4];
                $course_it = 0;
                
                for($trimester=0; $trimester<4; $trimester++){

                    // generate one sale per trimester with value 210
                    $sale = $this->Products->Sales->newEntity();
                    $sale['users_id'] = $id;
                    $sale['value'] = 210;
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
                        $product['value'] = floatval(210) / $courses_per_trimester[$trimester];
                        $this->Products->save($product);

                        $course_it++;
                    }
                }
            } else {

                $id_tmp = $courses_id_order[$course_it];

                $sale = $this->Products->Sales->newEntity();
                $sale['users_id'] = $id;
                $sale['value'] = $course['price'];
                $sale['payment_type'] = $this->request->getData('payment_type');
                $sale = $this->Products->Sales->save($sale);
                array_push($all_sales, $sale);

                $product = $this->Products->newEntity();
                $product['group_id'] = $this->request->getData('course_'.$id_tmp.'_group_id');
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
        $this->set(compact('groups', 'course', 'annual_courses'));
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
                $this->Flash->success('Foste colocado em lista de espera. Serás contacto caso abra uma nova vaga ou turma.');

            return $this->redirect(['controller' => 'cursos']);
         }
        $this->set(compact('course'));
    }

    public function exam($id = 1)
    {
    
        $user_id = $this->Auth->user('id');
        
        if ($this->request->is('post')) {
    	    $exam = $this->loadModel('Exams')->get($id, ['contain' => ['questions']])->toArray();
    	    
    	    $total = count($exam['questions']);
    	    $correct = 0;
    	    $data = $this->request->getData();
    	    
    	    foreach($exam['questions'] as $key => $question){
    	    	if ($question['correct'] == $data['q'.$question['id']]) $correct += 1;
    	    }
    	    
    	    $user_exams = $this->loadModel('UserExams')->find('all', ['conditions' => ['user_id' => $user_id, 'exam_id' => $id]])->first();
    	    $user_exams['answers'] = json_encode($data);
    	    $user_exams['result'] = $correct."/".$total;
    	    $user_exams['finished'] = 1;
    	    $user_exams = $this->loadModel('UserExams')->save($user_exams);
    	    
    	    $this->redirect(['action' => 'ebank', 'c' => 1]);             
        }	
    	
        if ($id != 1){
    	    //VERIFIA INSCRIÇÕES DO ALUNO
    	    if (!$user_id){
    		    return $this->redirect(['controller' => '/']);
    	    }
    	    
    	    $user = $this->loadModel('Users')->get($user_id, [
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

            if(in_array(16, $courses) || in_array(15, $courses)){
            
                $user_exams = $this->loadModel('UserExams')->find('all', ['conditions' => ['user_id' => $user_id, 'exam_id' => $id]]);
                        
                if($user_exams->count() == 0){
        	        $user_exams = $this->loadModel('UserExams')->newEntity();
        	        $user_exams['user_id'] = $user_id;
        	        $user_exams['exam_id'] = $id;
        	        $user_exams['timestamp'] = Time::now();
        	        $user_exams = $this->loadModel('UserExams')->save($user_exams);
                } else {
        	        $user_exams = $user_exams->first();
        	        
        	        $avg = $this->loadModel('UserExams')->find('all', [
                    'fields' => ['exam_id', 'result' => 'AVG(result)'],
                    'conditions' => ['exam_id' => $id, 'SUBSTRING_INDEX(result,"/",1) > 0'],
                    ])->toArray();
                    
                    
        	        
        	        if($user_exams['finished'] != 1){
        		        $user_exams['timestamp'] = Time::now();
        				$user_exams = $this->loadModel('UserExams')->save($user_exams);
        	        }
        	        
                }  
            }
           
    		else { // Se o aluno não tem acesso aos exames de simulação
    	       $id = 1;
    		}
        }

        $exam = $this->loadModel('Exams')->get($id, ['contain' => ['questions']])->toArray();

        $this->set(compact('exam', 'user_exams', 'courses', 'avg'));
    }

	public function ebank()
    {

       $user_id = $this->Auth->user('id');
        if(!isset($user_id))   return $this->redirect(['controller' => '/']);

        $user = $this->loadModel('Users')->get($user_id, [
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

        if(in_array(15, $courses) || in_array(16, $courses)):
        	
        	$exams = $this->loadModel('Exams')->find('all', [
            'conditions' => ['id > ' => 1, 'active' => 1],
            'contain' => ['UserExams' => ['conditions' => ['user_id' => $user_id]]]
            ])->toArray();
            
           $this->set(compact('exams', 'courses'));
                   
        else: $this->redirect(['controller' => 'reserved']);
        
        
        endif;      
    }
    
    public function qbank()
    {
        $session = $this->getRequest()->getSession();
        $user_id = $this->Auth->user('id');
        
        if(!isset($user_id))   return $this->redirect(['controller' => '/']);

        if ($this->request->is('post')) {

            $question_stat = $this->loadModel('Questions')->find('all', ['fields' => ['id', 'correct', 'a1', 'a2', 'a3', 'a4', 'a5']])->toArray();
            foreach ($question_stat as $value) {
                $tot = $value['a1']+$value['a2']+$value['a3']+$value['a4']+$value['a5'];
                if($tot > 50 ) $statistics[$value['id']] = $value['a'.$value['correct']] / $tot;
            }

            function get_percentile($percentile, $array) {
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

            $stat25 = get_percentile(25, $statistics);
            $stat75 = get_percentile(75, $statistics);

			if($this->request->getData('courses')[0] == 14) {
				
				$questions_ = $this->loadModel('questions')->find('all', [
	                'conditions' => ['active' => 1, 'course_id' => 14],
	                ])->toArray();
				
			} else {
				
				$questions_ = $this->loadModel('questions')->find('all', [
	                'conditions' => ['active' => 1, 'course_id in ('.implode(',', $this->request->getData('courses')).')'],
	                'order' => 'rand()'
	                ])->toArray();
				
			}
			
            $questions = array();
            $i = 0;
            foreach ($questions_ as $value) {

                $tot = $value['a1']+$value['a2']+$value['a3']+$value['a4']+$value['a5'];
                if($tot > 50):  
                    $corr = $value['a'.$value['correct']] / $tot; 
                else: $corr = 9999; 
                endif;

                if( (in_array(1, $this->request->getData('difficulty')) && $corr >= $stat75) || 
                (in_array(2, $this->request->getData('difficulty')) && (($corr < $stat75 && $corr >= $stat25) || $corr == 9999)) ||
                (in_array(3, $this->request->getData('difficulty')) && $corr < $stat25)):
                    
                    if(array_intersect(explode(',', $value['theme_id']), $this->request->getData('themes'))){
                        $questions[$i]['status'] = 0;
                        $questions[$i]['id'] = $value['id'];
                        $i++;
                    }
                endif;
            }
            
            $session->write('question_list', $questions);
            
            return $this->redirect(['action' => 'question', $questions[0]['id']]);
        }

        $user = $this->loadModel('Users')->get($user_id, [
            'contain' => ['groups' => ['Courses']]
            ])->toArray();
            
		//Elimina cursos de turmas eliminadas
        foreach ($user['groups'] as $key => $value) {
           if($value['deleted'] == 1) unset($user['groups'][$key]);
        }

        $courses_ = array();
        foreach ($user['groups'] as $key => $value) {
            $courses_[$key] = $value['course']['id'];
        }

        if(in_array(1, $courses_) && in_array(14, $courses_)): //VERIFICA SE ESTÁ INSCRITO NO E-LEARNING e no CURSO de VERÂO
            $courses = $this->loadModel('Courses')->find('all', [
            'conditions' => ['OR' => [['id > ' => 1, 'id <=' => 14], 'id' => 17]] ,
            'contain' => ['Themes']
            ])->toArray();
            
        elseif(in_array(1, $courses_)): //VERIFICA SE ESTÁ INSCRITO NO E-LEARNING sem CURSO de VERÂO
            $courses = $this->loadModel('Courses')->find('all', [
            'conditions' => ['OR' => [['id > ' => 1, 'id <' => 15], 'id' => 17]],
            'contain' => ['Themes']
            ])->toArray();

        elseif(count($courses_) > 0): // VERIFCA OS CURSOS EM QUE ESTÁ INSCRITO
            $courses = $this->loadModel('Courses')->find('all', [
            'conditions' => ['OR' => [['id in ('.implode(',', $courses_).')', 'id <' => 14], 'id' => 17]],
            'contain' => ['Themes']
            ])->toArray();
            
        else: 
            $courses = null;
        endif;

        $question_list = $session->read('question_list');
        $this->set(compact('courses', 'question_list', 'courses_'));
    }

    public function question($id = null)
    {
        $session = $this->getRequest()->getSession();

        //  VERIFICA SE NÃO EXISTE PERGUNTA
        if(!$id){

            $this->set('none', 1);

        } else {

        $question = $this->loadModel('Questions')->get($id,
        ['fields' => ['id', 'correct', 'a1', 'a2', 'a3', 'a4', 'a5', 'pic', 'op1', 'op2', 'op3', 'op4', 'op5', 'correct', 'question', 'course_id', 'justification']])->toArray();

        //VERIFICA SE O UTILIZADOR COMPROU O CURSO DA PERGUNTA
        $user_id = $this->Auth->user('id');
        if(!isset($user_id))   return $this->redirect(['controller' => '/']);
        $user = $this->loadModel('Users')->get($user_id, [
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

         if(!in_array($question['course_id'], $courses) && $question['course_id']!=17 && !in_array(1, $courses)){
            return $this->redirect(['action' => 'index']);
        }

        $question_stat = $this->loadModel('Questions')->find('all', ['fields' => ['id', 'correct', 'a1', 'a2', 'a3', 'a4', 'a5']])->toArray();
        foreach ($question_stat as $value) {
            $tot = $value['a1']+$value['a2']+$value['a3']+$value['a4']+$value['a5'];
            if($tot > 50 ) $statistics[$value['id']] = $value['a'.$value['correct']] / $tot;
        }

        function get_percentile($percentile, $array) {
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

        $stat25 = get_percentile(25, $statistics);
        $stat75 = get_percentile(75, $statistics);

       $question_list = $session->read('question_list');

       $this->set(compact('question', 'question_list', 'stat25', 'stat75', 'statistics', 'courses'));

       }  
    }

    public function answer()
    {
       $this->layout = false;
       $session = $this->getRequest()->getSession();

       $id = $this->request->getData('id');
       $answer = $this->request->getData('answer');
       $qk = $this->request->getData('qk');
       $question = $this->loadModel('Questions')->get($id, ['fields' => ['id', 'correct', 'a1', 'a2', 'a3', 'a4', 'a5']]);

       if($question['correct'] == $answer) $status = 1; else $status = 2; 
       $session->write('question_list.'.$qk.'.status', $status);
       $session->write('question_list.'.$qk.'.answer', $answer);

       if($answer != ''):
        $question['a'.$answer] = $question['a'.$answer] + 1;
        
        $query = $this->loadModel('Questions')->query();
        $query->update()
            ->set(['a'.$answer => $question['a'.$answer]])
            ->where(['id' => $id])
            ->execute();
        endif;

       $this->set(compact('answer', 'question'));
    }

    public function flashcards()
    {
        

        if ($this->request->is('post')) {


            if(is_null($this->request->data('themes'))){
                return $this->redirect(['action' => 'fbank']);
            }

            $user_id = $this->Auth->user('id');
            
            $user = $this->loadModel('Users')->get($user_id, [
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

            if($this->request->data('wrong') == 0) {

                $flashcards = $this->loadModel('Flashcards')->find('all', [
                        'contain' => ['FlashcardsUser'.$user_id, 'Themes'],
                        'conditions' => ['Flashcards.active' => 1, 'theme_id in' => $this->request->data('themes')],
                        'order' => ['FlashcardsUser'.$user_id.'.correct' => 'ASC', 'FlashcardsUser'.$user_id.'.last_time' => 'ASC', 'rand()']
                        ])->toArray();
            } elseif($this->request->data('wrong') == 1) {
                
                $flashcards = $this->loadModel('Flashcards')->find('all', [
                        'contain' => ['FlashcardsUser'.$user_id, 'Themes'],
                        'conditions' => ['Flashcards.active' => 1, 'theme_id in' => $this->request->data('themes'), 'FlashcardsUser'.$user_id.'.correct !=' => 1],
                        'order' => ['FlashcardsUser'.$user_id.'.correct' => 'ASC', 'FlashcardsUser'.$user_id.'.last_time' => 'ASC', 'rand()']
                        ])->toArray();

            } elseif($this->request->data('wrong') == 2) {
                
                $flashcards = $this->loadModel('Flashcards')->find('all', [
                        'contain' => ['FlashcardsUser'.$user_id, 'Themes'],
                        'conditions' => ['Flashcards.active' => 1, 'theme_id in' => $this->request->data('themes'), 'FlashcardsUser'.$user_id.'.favorite' => 1],
                        'order' => ['FlashcardsUser'.$user_id.'.correct' => 'ASC', 'FlashcardsUser'.$user_id.'.last_time' => 'ASC', 'rand()']
                        ])->toArray();

            }

        $this->set(compact('flashcards', 'courses'));
        
        }      
    }

    public function fbank()
    {
       $session = $this->getRequest()->getSession();
       $user_id = $this->Auth->user('id');
        if(!isset($user_id))   return $this->redirect(['controller' => '/']);

        //VÊ SE EXISTE UMA TABELA PARA OS FLASHCARDS DO UTILIZADOR, OU CRIA
            $data = $this->request->getData();
            $db = ConnectionManager::get('default');
            $tables = $db->schemaCollection()->listTables();

            if(!in_array('flashcards_user'.$user_id, $tables)){
                $schema = new TableSchema('flashcards_user'.$user_id);
                $schema->addColumn('id', [
                  'type' => 'integer',
                  'length' => 11,
                  'autoIncrement' => true,
                ])->addColumn('flashcard_id', [
                  'type' => 'integer',
                  'length' => 11,
                ])->addColumn('correct', [
                  'type' => 'integer',
                  'length' => 1,
                ])->addColumn('favorite', [
                  'type' => 'integer',
                  'length' => 1,
                ])->addColumn('last_time', [
                  'type' => 'timestamp',
                ])->addConstraint('primary', [
                  'type' => 'primary',
                  'columns' => ['id']
                ]);

                $queries = $schema->createSql($db);
                foreach ($queries as $sql) {
                  $db->execute($sql);
                }
            }  else {
                $table = $db->schemaCollection()->describe('flashcards_user'.$user_id, ['forceRefresh' => true])->columns();
                if(!in_array('favorite', $table)){       
                    $db->query('ALTER TABLE flashcards_user'.$user_id.' ADD favorite int');
                }
                
            }



        $user = $this->loadModel('Users')->get($user_id, [
            'contain' => ['groups' => ['Courses']]
            ])->toArray();
        
        //Elimina cursos de turmas eliminadas
        foreach ($user['groups'] as $key => $value) {
           if($value['deleted'] == 1) unset($user['groups'][$key]);
        }


        $courses_ = array();
        foreach ($user['groups'] as $key => $value) {
            $courses_[$key] = $value['course']['id'];
        }

        if(count($courses_) > 0): // VERIFICA SE COMPROU CURSOS
            if(in_array(1, $courses_)):
                $courses = $this->loadModel('Courses')->find('all', [
                    'conditions' => ['id > ' => 1, 'id <' => 14 ], //não há flaschards do curso de verão
                    'contain' => ['Themes']])->toArray();
            else:
                $courses = $this->loadModel('Courses')->find('all', [
                    'conditions' => ['id in ('.implode(',', $courses_).')', 'id <' => 14],
                    'contain' => ['Themes']])->toArray();
            endif;

        $query = $this->loadModel('FlashcardsUser'.$user_id)->find();
        $query->select(['count' => $query->func()->count('correct'), 'Flashcards.theme_id'])
              ->join([
                    'table' => 'Flashcards',
                    'type' => 'INNER',
                    'conditions' => 'Flashcards.id = flashcard_id'
                ])
              ->where(['correct' => 1])
            ->group(['theme_id']);

        foreach ($query as $key => $value) {
            $answered[$value['Flashcards']['theme_id']] = $value['count'];
        }

        $query2 = $this->loadModel('Flashcards')->find();
        $query2->select(['count' => $query->func()->count('id'), 'theme_id'])
                ->where(['active' => 1])
              ->group(['theme_id']);

        foreach ($query2 as $key => $value) {
            $flashcards[$value['theme_id']] = $value['count'];
        }


        else: $courses = null;
        endif;

       $this->set(compact('courses', 'answered', 'flashcards', 'courses_'));
    }

    public function flashAnswer()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $user_id = $this->Auth->user('id');

        $answer = $this->loadModel('FlashcardsUser'.$user_id)->find('all', ['conditions' => ['flashcard_id' => $this->request->data('id')]]);
        //$answer = $this->loadModel('FlashcardsUser'.$user_id)->find('all', ['conditions' => ['flashcard_id' => 100]]);

        if($answer->count()>0): $answer = $answer->first(); else: $answer = $this->loadModel('FlashcardsUser'.$user_id)->newEntity(); $answer['flashcard_id'] = $this->request->data('id'); endif; 
       
        /* if($answer->count()>0): $answer = $answer->first(); else: $answer = $this->loadModel('FlashcardsUser'.$user_id)->newEntity(); $answer['flashcard_id'] = 100 ; endif;  */
        $answer['correct'] = $this->request->data('answer');
        $answer['last_time'] = date('Y-m-d');
        
        $answer = $this->loadModel('FlashcardsUser'.$user_id)->save($answer);
    }

    public function flashFav()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $user_id = $this->Auth->user('id');

        $answer = $this->loadModel('FlashcardsUser'.$user_id)->find('all', ['conditions' => ['flashcard_id' => $this->request->data('id')]]);
        //$answer = $this->loadModel('FlashcardsUser'.$user_id)->find('all', ['conditions' => ['flashcard_id' => 100]]);

        if($answer->count()>0): $answer = $answer->first(); else: $answer = $this->loadModel('FlashcardsUser'.$user_id)->newEntity(); $answer['flashcard_id'] = $this->request->data('id'); endif; 
       
        /* if($answer->count()>0): $answer = $answer->first(); else: $answer = $this->loadModel('FlashcardsUser'.$user_id)->newEntity(); $answer['flashcard_id'] = 100 ; endif;  */
        $answer['favorite'] = $this->request->data('answer');
        
        $answer = $this->loadModel('FlashcardsUser'.$user_id)->save($answer);
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
                                  <td style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; padding: 0;" text-align="right"><img src="'.Router::url(['controller' => '/'], true).'/img/logo_white.png" height="75" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; margin: 0; max-width: 100%; padding: 0; float:right"></td>
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
