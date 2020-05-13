<?php
namespace App\Controller\Backoffice;


use App\Controller\Backoffice\AppController;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Routing\Router;

/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 *
 * @method \App\Model\Entity\Question[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeedbackController extends AppController
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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function questions(){
    
        $questions1 = $this->loadModel('Feed_questions')->find('all', ['conditions' => ['type' => 1, 'deleted' => 0]])->toArray();
        $questions2 = $this->loadModel('Feed_questions')->find('all', ['conditions' => ['type' => 2, 'deleted' => 0]])->toArray();

        $this->set(compact('questions1', 'questions2'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = 0)
    {
        $question = $this->loadModel('Feed_questions')->newEntity();


        if ($this->request->is('post')) {
            $question = $this->loadModel('Feed_questions')->patchEntity($question, $this->request->getData());
            $question['type'] = $id;
            
            if ($this->loadModel('Feed_questions')->save($question)) {
                $this->Flash->success(__('A pergunta foi guardada'));

                return $this->redirect(['action' => 'questions']);
            }
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        $this->set(compact('question'));
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
        $question = $this->loadModel('Feed_questions')->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $question = $this->loadModel('Feed_questions')->patchEntity($question, $this->request->getData());

            if ($this->loadModel('Feed_questions')->save($question)) {
                $this->Flash->success(__('A pergunta foi guardada.'));
                return $this->redirect(['action' => 'questions']);
            }
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        $this->set(compact('question'));
    }


    public function toggle($id = null)
    {
        if($this->request->is('post')) {
            $question = $this->loadModel('Feed_questions')->get($id);
            if ($question['status'] == 1){$question['status'] = 0;} else {$question['status'] = 1;}
            $this->loadModel('Feed_questions')->save($question);
            return $this->redirect(['action' => 'questions']);
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
        $question = $this->loadModel('Feed_questions')->get($id);
        $question['deleted'] = 1;
        if($this->loadModel('Feed_questions')->save($question)) {
            $this->Flash->success(__('A pergunta foi eliminada.'));
        }
        
        return $this->redirect(['action' => 'questions']);
    }


    public function generateSurveys()
    {
        
        $this->autoRender = false;

        $lectures = $this->loadModel('Lectures')->find('all', [
            'conditions' => [
                'datetime <' => time()+3600*2,
                'feedback' => 0,
            ], 'contain' => ['Groups' => ['Courses']]
            ])->toArray();

        $year = date("Y");
        if(date('m') > 9) $year = $year + 1;

        foreach ($lectures as $key => $lecture) {
            $students = $this->loadModel('Groups')->get($lecture['group_id'], ['contain' => ['Users' => ['conditions' => ['Users.role' => 0]]]])->toArray();
            /* $students = $this->loadModel('Groups')->get($lecture['group_id'], ['contain' => ['Users' => ['conditions' => ['Users.id in' => (7)]]]])->toArray(); */
            foreach ($students['users'] as $key => $student) {
                $code = substr(md5(mt_rand()), 0, 7);
                $table = TableRegistry::get('Feed_user_surveys');
                $query = $table->query();
                $query->insert(['user_id', 'lecture_id', 'course_id', 'code', 'year'])
                        ->values([
                            'user_id' => $student['id'],
                            'lecture_id' => $lecture['id'],
                            'course_id' => $lecture['group']['courses_id'],
                            'year' => $year,
                            'code' => $code
                            ])
                        ->execute();

            $text = '<p>Já está disponível o questionário de avaliação da <b>'.$lecture['description'].'</b> do Módulo de <b>'.$lecture['group']['course']['name'].'.</p>
                                <p>Para responderes, basta utilizares o botão abaixo.</p>
                             <a class="btn" style="background-color: #ccc; color: #152335; cursor: pointer; display: inline-block; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-weight: bold; margin: 0; margin-right: 10px; padding: 10px 16px; text-align: center; text-decoration: none;" href="'.Router::url(['prefix' => false, 'controller' => 'frontend', 'action' => 'feedback', $code], true).'">Responder</a>';
                                            
                        $body = $this->email_template($student['first_name'], $text);

                        $email = new Email('default');
                        $email->to($student['email'])
                            ->emailFormat('html')
                            ->subject('[EKOS] Questionário de Avaliação - '.$lecture['group']['course']['name'])
                            ->send($body);
                        
            }
            $lecture['feedback'] = 1;
            $lecture = $this->loadModel('Lectures')->save($lecture);


        }

        return $this->redirect(['action' => 'questions']);
    }


    public function teacher ($id = null, $year = null){
        $years = $this->loadModel('FeedUserSurveys')->find('list', ['fields' => ['year' => 'DISTINCT FeedUserSurveys.year'], 'group by' => 'year', 'order' => 'year DESC', 'valueField' => 'year', 'keyField' => 'year'])->toArray();
        
        foreach ($years as $key => $value) {
            $years[$key] = intval($value-1)."/".$value;
        }

        if(!$year){@$year = array_keys($years)[0];}

        $model = $this->loadModel('FeedAnswers');


        //PERMISÕES
        $Auth = $this->Auth->user();
        if($Auth['role'] == 3 || $id == $Auth['id']){
            $answers = $model->find('all', [
                'conditions' => [
                    'teacher_id' => $id,
                    'question_id !=' => 0,
                    'year' => $year,
                ], 
                'order' => 'lecture_id ASC'
            ]);

             $comments_ = $model->find('all', [
                'conditions' => [
                    'question_id' => 0, 
                    'teacher_id' => $id,
                    'year' => $year
                ]
            ]);

        } else {
            $allowed = array();

            if($Auth['role'] == 2){
                foreach ($Auth['moderator'] as $key => $value) {
                    if(!in_array($value, $allowed)) array_push($allowed, $value);
                }
            }
            

            if(empty($allowed)):


                $this->Flash->error('Não tens permissão para aceder à página solicitada');
                return $this->redirect($this->referer());


            else: 

            $answers = $model->find('all', [
                'conditions' => [
                    'question_id !=' => 0, 
                    'teacher_id' => $id,
                    'course_id in' => $allowed,
                    'year' => $year
                ],
                'order' => 'lecture_id ASC'
            ]);


          $comments_ = $model->find('all', [
                'conditions' => [
                    'question_id' => 0, 
                    'teacher_id' => $id,
                    'course_id in' => $allowed,
                    'year' => $year
                ]
            ]);

            endif;
        }

        

        if($answers->count()>0):

        $answers = $answers->toArray();

        

        $q = array();
        foreach ($answers as $key => $value) {
            //General
            @$q[$value['question_id']]['n'] += 1;
            if($value['value'] == 0) @$q[$value['question_id']]['zero'] += 1;
            @$q[$value['question_id']]['total'] += $value['value'];

            //Courses
            @$q[$value['question_id']]['courses'][$value['course_id']]['n'] += 1;
            if($value['value'] == 0) @$q[$value['question_id']]['courses'][$value['course_id']]['zero'] += 1;
            @$q[$value['question_id']]['courses'][$value['course_id']]['total'] += $value['value'];

            //Lectures
            @$q[$value['question_id']]['courses'][$value['course_id']]['lectures'][$value['lecture_id']]['n'] += 1;
            if($value['value'] == 0) @$q[$value['question_id']]['courses'][$value['course_id']]['lectures'][$value['lecture_id']]['zero'] += 1;
            @$q[$value['question_id']]['courses'][$value['course_id']]['lectures'][$value['lecture_id']]['total'] += $value['value'];


        }

        
        $courses = array();
        $lectures = array();
        foreach ($q as $key => $value2) {
            if(@$value2['n'] - @$value2['zero'] > 0): @$q[$key]['avg'] = $value2['total'] / ($value2['n'] - $value2['zero']); else: $q[$key]['avg'] = 0; endif;

        foreach ($value2['courses'] as $k => $value) {
            if(@$value['n'] - @$value['zero'] > 0): @$q[$key]['courses'][$k]['avg'] = $value['total'] / ($value['n'] - $value['zero']); else: $q[$key]['subjects'][$k]['avg'] = 0; endif;
            
            if(!in_array($k, $courses)) array_push($courses, $k);
            foreach ($value['lectures'] as $key2 => $lecture) {
                if(!in_array($key2, $lectures)) array_push($lectures, $key2);
                if(@$lecture['n'] - @$lecture['zero'] > 0): @$q[$key]['courses'][$k]['lectures'][$key2]['avg'] = $lecture['total'] / ($lecture['n'] - $lecture['zero']);  else: $q[$key]['courses'][$k]['lectures'][$key2]['avg'] = 0; endif;
            }

        }  }

        // //VERIFICA QUANTAS UCS HÁ E O NÚMERO DE INSCRITOS EM CADA
        // if(count($subjects) > 0) $subjects = $this->loadModel('UserSurveys')->find('all', [
        //     'contain' => ['Subjects', 'Courses'],
        //     'conditions' => ['subject_id in' => $subjects, "FIND_IN_SET($id, teachers) > 0", 'year' => $year],
        //     'fields' => ['count' => 'COUNT(UserSurveys.id)', 'subject_id', 'Subjects.name', 'Courses.name', 'course_id'],
        //     'group' => ['subject_id', 'course_id']
        // ])->toArray();

        // $courses = array();
        // foreach ($subjects as $key => $value) {
        //     $courses[$value['course_id']] = $value['course']['name'];
        //     $q[3]['subjects'][$value['subject_id']]['courses'][$value['course_id']]['count'] = $value['count'];
        //     $q[3]['subjects'][$value['subject_id']]['name'] = $value['subject']['name'];
        // }


        //GRÁFICO 1
        ksort($q);
        $general['label'] = array();
        $general['color'] = array();
        $general['data'] = array();
        foreach ($q as $key => $value) {
            array_push($general['label'], $key);
            array_push($general['data'], $value['avg']);
            if($key == 1){array_push($general['color'], 'rgba(86, 190, 142, 0.8)');} else {array_push($general['color'], 'rgba(204, 204, 204, 0.7)');}
        }

        //----------------------- GRÁFICO BEST OF-------------------------------- 

        foreach ($q[1]['courses'] as $course => $value) {

            $q3[$course]['label'] = array();
            $q3[$course]['data'] = array();
            foreach ($value['lectures'] as $lecture => $value2) {
              array_push($q3[$course]['label'], $lecture);
              array_push($q3[$course]['data'], $value2['avg']);

            }

        }

        //----------------------- GRÁFICOS AULAS-------------------------------- 
        
        foreach ($q[1]['courses'] as $course => $value) {

          foreach ($value['lectures'] as $lecture => $value2) {
            
              $q2[$course][$lecture]['label'] = array();
              $q2[$course][$lecture]['data'] = array();
              $q2[$course][$lecture]['color'] = array();

              foreach ($q as $key => $value3) {
                array_push($q2[$course][$lecture]['label'], $key);
                array_push($q2[$course][$lecture]['data'], $value3['courses'][$course]['lectures'][$lecture]['avg']);
                if($key == 1){array_push($q2[$course][$lecture]['color'], 'rgba(86, 190, 142, 0.8)');} else {array_push($q2[$course][$lecture]['color'], 'rgba(204, 204, 204, 0.7)');}
              }

          }
        
           
        }


         //------------- COMENTÁRIOS ----------------------
        
        foreach ($comments_ as $key => $value) {
          if(!isset($comments[$value['lecture_id']])) $comments[$value['lecture_id']] = array();
          array_push($comments[$value['lecture_id']], $value['long_value']);
        }

        
        $lectures = $this->loadModel('Lectures')->find('all', ['conditions' => ['Lectures.id in' => $lectures], 'contain' => ['Groups']])->toArray();
        $themes = array();
        foreach ($lectures as $key => $value) {
          $Lectures[$value['id']] = $value['description']." - ".$value['group']['name'];
          $themes_ = explode(',', $value['themes']);
          foreach ($themes_ as $key2 => $value2) {
            if(!in_array($value2, $themes)) array_push($themes, $value2);
          }
          $lectures[$value['id']] = $value;
        }
        $questions = $this->loadModel('FeedQuestions')->find('list', ['conditions' => ['id in ' => $general['label']]])->toArray();
        $courses = $this->loadModel('Courses')->find('list', ['conditions' => ['id in ' => $courses]])->toArray();
        $themes = $this->loadModel('Themes')->find('list', ['conditions' => ['id in ' => $themes]])->toArray();

        
        else:

        $q = 0;

        endif;
        
        $user = $this->loadModel('Users')->get($id);
        $this->set(compact('q', 'years', 'Lectures', 'courses', 'user', 'general', 'questions', 'q2', 'lectures', 'q3', 'themes', 'comments'));

    }


    public function course ($id = null, $year = null){
        $years = $this->loadModel('FeedUserSurveys')->find('list', ['fields' => ['year' => 'DISTINCT FeedUserSurveys.year'], 'group by' => 'year', 'order' => 'year DESC', 'valueField' => 'year', 'keyField' => 'year'])->toArray();
        
        foreach ($years as $key => $value) {
            $years[$key] = intval($value-1)."/".$value;
        }

        if(!$year){@$year = array_keys($years)[0];}

        $model = $this->loadModel('FeedAnswers');


        //PERMISÕES
        $Auth = $this->Auth->user();
        if($Auth['role'] != 3){
            
            $allowed = array();

            if($Auth['role'] == 2){
                foreach ($Auth['moderator'] as $key => $value) {
                    if(!in_array($value, $allowed)) array_push($allowed, $value);
                }
            }
            

            if(!in_array($id, $allowed)):


                $this->Flash->error('Não tens permissão para aceder à página solicitada');
                return $this->redirect($this->referer());

            endif;

          }

          $answers = $model->find('all', [
                'conditions' => [
                    'course_id' => $id,
                    'question_id !=' => 0,
                    'year' => $year,
                ], 
                'order' => 'lecture_id ASC'
            ]);

          $comments_ = $model->find('all', [
                'conditions' => [
                    'course_id' => $id,
                    'question_id' => 0,
                    'year' => $year,
                ]
            ]);

       

        if($answers->count()>0):

        $answers = $answers->toArray();

        

        $q = array();
        foreach ($answers as $key => $value) {
            //General
            @$q[$value['question_id']]['n'] += 1;
            if($value['value'] == 0) @$q[$value['question_id']]['zero'] += 1;
            @$q[$value['question_id']]['total'] += $value['value'];


            //Lectures
            @$q[$value['question_id']]['lectures'][$value['lecture_id']]['n'] += 1;
            if($value['value'] == 0) @$q[$value['question_id']]['lectures'][$value['lecture_id']]['zero'] += 1;
            @$q[$value['question_id']]['lectures'][$value['lecture_id']]['total'] += $value['value'];


        }

        
        $lectures = array();
        foreach ($q as $key => $value2) {
            if(@$value2['n'] - @$value2['zero'] > 0): @$q[$key]['avg'] = $value2['total'] / ($value2['n'] - $value2['zero']); else: $q[$key]['avg'] = 0; endif;

        foreach ($value2['lectures'] as $k => $value) {
            if(@$value['n'] - @$value['zero'] > 0): @$q[$key]['lectures'][$k]['avg'] = $value['total'] / ($value['n'] - $value['zero']); else: $q[$key]['lectures'][$k]['avg'] = 0; endif;
        }  }



        //GRÁFICO 1
        ksort($q);
        $general['label'] = array();
        $general['color'] = array();
        $general['data'] = array();
        foreach ($q as $key => $value) {
            array_push($general['label'], $key);
            array_push($general['data'], $value['avg']);
            if($key == 1){array_push($general['color'], 'rgba(86, 190, 142, 0.8)');} else {array_push($general['color'], 'rgba(204, 204, 204, 0.7)');}
        }

        // //----------------------- GRÁFICO BEST OF-------------------------------- 

        $q3['label'] = array();
        $q3['data'] = array();
        $q3['color'] = array();
        foreach ($q[1]['lectures'] as $lecture => $value) {
            array_push($q3['label'], $lecture);
            array_push($q3['data'], $value['avg']);
        }


         //--------------PROFESSORES--------------

            $teachers_ = $model->find('all', [
                'conditions' => ['course_id' => $id, 'question_id' => 1, 'value >' => 0],
                'group' => 'teacher_id',
                'fields' => ['teacher_id', 'avg' => 'AVG(value)', 'sum' => 'COUNT(value)']
            ])->toArray();

             $colours = ["rgba(255, 99, 132, 0.9)",
                "rgba(54, 162, 235, 0.9)",
                "rgba(255, 206, 86, 0.9)",
                "rgba(75, 192, 192, 0.9)",
                "rgba(153, 102, 255, 0.9)",
                "rgba(255, 159, 64, 0.9)"
                ];

            foreach ($teachers_ as $key => $value) {
                $user = $this->loadModel('Users')->get($value['teacher_id']);
                $teachers[$value['teacher_id']] = $value;
                $teachers[$value['teacher_id']]['color'] = $colours[$key];
                $teachers[$value['teacher_id']]['name'] = $user->first_name." ".$user->last_name;
              
            }

        // //----------------------- GRÁFICOS AULAS-------------------------------- 
        
        foreach ($q[1]['lectures'] as $lecture => $value2) {

            
              $q2[$lecture]['label'] = array();
              $q2[$lecture]['data'] = array();
              $q2[$lecture]['color'] = array();

              foreach ($q as $key => $value3) {
                array_push($q2[$lecture]['label'], $key);
                array_push($q2[$lecture]['data'], $value3['lectures'][$lecture]['avg']);
                if($key == 1){array_push($q2[$lecture]['color'], 'rgba(86, 190, 142, 0.8)');} else {array_push($q2[$lecture]['color'], 'rgba(204, 204, 204, 0.7)');}
              }
        
           
        }


        //------------- COMENTÁRIOS ----------------------
        
        foreach ($comments_ as $key => $value) {
          if(!isset($comments[$value['lecture_id']])) $comments[$value['lecture_id']] = array();
          array_push($comments[$value['lecture_id']], $value['long_value']);
        }


        $lectures = $this->loadModel('Lectures')->find('all', ['conditions' => ['Lectures.id in' => $q3['label']], 'contain' => ['Groups']])->toArray();
        $themes = array();
        foreach ($lectures as $key => $value) {
          $Lectures[$value['id']] = $value['description']." - ".$value['group']['name'];
          $themes_ = explode(',', $value['themes']);
          foreach ($themes_ as $key2 => $value2) {
            if(!in_array($value2, $themes)) array_push($themes, $value2);
          }
          $lectures[$value['id']] = $value;
        }

        foreach ($q[1]['lectures'] as $lecture => $value) {
            array_push($q3['color'], $teachers[$lectures[$lecture]['teacher']]['color']);
        }
        
        $questions = $this->loadModel('FeedQuestions')->find('list', ['conditions' => ['id in ' => $general['label']]])->toArray();
        // $courses = $this->loadModel('Courses')->find('list', ['conditions' => ['id in ' => $courses]])->toArray();
        $themes = $this->loadModel('Themes')->find('list', ['conditions' => ['id in ' => $themes]])->toArray();

        
        else:

        $q = 0;

        endif;
        
        $course = $this->loadModel('Courses')->get($id);
        $this->set(compact('q', 'years', 'Lectures', 'teachers', 'course', 'general', 'questions', 'q2', 'lectures', 'q3', 'themes', 'comments'));

    }


    public function teachers($year = null){

      //PERMISÕES
        $Auth = $this->Auth->user();
        if($Auth['role'] != 3){
            
          $this->Flash->error('Não tens permissão para aceder à página solicitada');
          return $this->redirect($this->referer());

        }

      $years = $this->loadModel('FeedUserSurveys')->find('list', ['fields' => ['year' => 'DISTINCT FeedUserSurveys.year'], 'group by' => 'year', 'order' => 'year DESC', 'valueField' => 'year', 'keyField' => 'year'])->toArray();
        
        foreach ($years as $key => $value) {
            $years[$key] = intval($value-1)."/".$value;
        }

        if(!$year){@$year = array_keys($years)[0];}

      $model = $this->loadModel('FeedAnswers');


      // Vê quantas questões há
      $questions = $model->find('list', ['fields' => ['question_id' => 'DISTINCT FeedAnswers.question_id'], 'group by' => 'question_id', 'order' => 'question_id ASC', 'valueField' => 'question_id', 'conditions' => ['question_id != ' => 0, 'year' => $year]]);
      
      if($questions->count() == 0){
              $questions = 0;
      } else {
      
      $questions = $this->loadModel('FeedQuestions')->find('list', ['conditions' => ['id in' => $questions->toArray()]])->toArray();

        foreach ($questions as $key => $value) {
          $teachers_ = $model->find('all', [
                  'conditions' => ['question_id' => $key, 'value >' => 0, 'year' => $year],
                  'group' => 'teacher_id',
                  'fields' => ['teacher_id', 'avg' => 'AVG(value)', 'sum' => 'COUNT(value)'],
                  'order' => ['avg' => 'DESC'],
              ]);

          $teachers_ = $teachers_->toArray();


              foreach ($teachers_ as $key2 => $value) {
                  $user = $this->loadModel('Users')->get($value['teacher_id']);
                  $teachers[$key][$value['teacher_id']] = $value;
                  $teachers[$key][$value['teacher_id']]['name'] = $user->first_name." ".$user->last_name;
                
              }

        
        }
      }
      

       $this->set(compact('teachers', 'years', 'questions'));


    }

    public function courses($year = null){

      

      $years = $this->loadModel('FeedUserSurveys')->find('list', ['fields' => ['year' => 'DISTINCT FeedUserSurveys.year'], 'group by' => 'year', 'order' => 'year DESC', 'valueField' => 'year', 'keyField' => 'year'])->toArray();
        
        foreach ($years as $key => $value) {
            $years[$key] = intval($value-1)."/".$value;
        }

        if(!$year){@$year = array_keys($years)[0];}

      $model = $this->loadModel('FeedAnswers');


      //PERMISÕES
        $Auth = $this->Auth->user();
        if($Auth['role'] == 3){
            
          $courses_ = $model->find('all', [
                  'conditions' => ['question_id' => 1, 'value >' => 0, 'year' => $year],
                  'group' => 'course_id',
                  'fields' => ['course_id', 'avg' => 'AVG(value)', 'sum' => 'COUNT(value)'],
                  'order' => ['avg' => 'DESC'],
              ]);

        } else {
            $allowed = array();

            if($Auth['role'] == 2){
                foreach ($Auth['moderator'] as $key => $value) {
                    if(!in_array($value, $allowed)) array_push($allowed, $value);
                }
            }
            

            if(empty($allowed)):


                $this->Flash->error('Não tens permissão para aceder à página solicitada');
                return $this->redirect($this->referer());


            else: 

            $courses_ = $model->find('all', [
                  'conditions' => ['question_id' => 1, 'value >' => 0, 'year' => $year, 'course_id in' => $allowed],
                  'group' => 'course_id',
                  'fields' => ['course_id', 'avg' => 'AVG(value)', 'sum' => 'COUNT(value)'],
                  'order' => ['avg' => 'DESC'],
              ]);


            endif;
        }

        


         if($courses_->count() == 0){
              $courses = 0;
          } else {

          $courses_ = $courses_->toArray();


              foreach ($courses_ as $key2 => $value) {
                  $user = $this->loadModel('Courses')->get($value['course_id']);
                  $courses[$value['course_id']] = $value;
                  $courses[$value['course_id']]['name'] = $user->name;
                
              }

        
        }
      

       $this->set(compact('courses', 'years'));


    }


}
