<?php
namespace App\Controller\Backoffice;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Inflector;
use App\Controller\Backoffice\AppController;

/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 *
 * @method \App\Model\Entity\Question[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestionsController extends AppController
{

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

            if($user['role'] > 2):
                $this->paginate = [
                    'contain' => ['Exams', 'Courses'],
                    'conditions' => ['course_id' => $course_id]
                ];

                $courses = $this->loadModel('Courses')->find('list')->toArray();

            else:

                $this->paginate = [
                    'contain' => ['Exams', 'Courses'],
                    'conditions' => ['course_id' => $course_id, 'course_id in ('.implode(',', $moderators).')']
                ];

                $courses = $this->loadModel('Courses')->find('list', ['conditions' => 'id in ('.implode(',', $moderators).')'])->toArray();

            endif;


        else:

            if($user['role'] > 2):
                $this->paginate = [
                    'contain' => ['Exams', 'Courses']
                ];

                $courses = $this->loadModel('Courses')->find('list')->toArray();

            else:
                $this->paginate = [
                    'contain' => ['Exams', 'Courses'],
                    'conditions' => ['course_id in ('.implode(',', $moderators).')']
                ];

                $courses = $this->loadModel('Courses')->find('list', ['conditions' => 'id in ('.implode(',', $moderators).')'])->toArray();

            endif;

        endif;

        
        $themes = $this->loadModel('Themes')->find('list')->toArray();
        $questions = $this->paginate($this->Questions);

        $this->set(compact('questions', 'themes', 'courses'));
    }

    /**
     * View method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => ['Exams', 'Themes']
        ]);

        $this->set('question', $question);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    
    	$session = $this->getRequest()->getSession();
        $question = $this->Questions->newEntity();

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
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            $question['theme_id'] = implode(',', $this->request->getData()['themes']);
            if($this->request->getData()['file']['tmp_name'] != ''){

                $dir = WWW_ROOT.'img/questions'.DS;

                $imagem = $this->request->data['file'];

                if($imagem['error']!=0 || $imagem['size']==0) {
                    $this->Flash->error('Alguma coisa deu errado, o upload retornou erro '.$imagem['error'].' e tamanho '.$imagem['size']);
                } else {

                    $this->checa_dir($dir);
                    $imagem = $this->checa_nome($imagem, $dir);
                    $path = $this->move_arquivos($imagem, $dir);
                
                }

                $question['pic'] = $path;
            }
            
            if ($this->Questions->save($question)) {
                $this->Flash->success(__('A pergunta foi guardada'));

                return $this->redirect($session->read('referer'));
            }
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        $themes = $this->Questions->Themes->find('list', ['limit' => 500]);
        $this->set(compact('question', 'courses', 'themes'));
        
        $session->write('referer', $this->referer());
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
    	$session = $this->getRequest()->getSession();
        $question = $this->Questions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            $question['theme_id'] = implode(',', $this->request->getData()['themes']);
            if($this->request->getData()['file']['tmp_name'] != ''){

                $dir = WWW_ROOT.'img/questions'.DS;

                $imagem = $this->request->data['file'];

                if($imagem['error']!=0 || $imagem['size']==0) {
                    $this->Flash->error('Alguma coisa deu errado, o upload retornou erro '.$imagem['error'].' e tamanho '.$imagem['size']);
                } else {

                    $this->checa_dir($dir);
                    $imagem = $this->checa_nome($imagem, $dir);
                    $path = $this->move_arquivos($imagem, $dir);
                
                }

                $question['pic'] = $path;
            }


            if ($this->Questions->save($question)) {
                $this->Flash->success(__('A pergunta foi guardada.'));
                return $this->redirect($session->read('referer'));
            }
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        $themes = $this->Questions->Themes->find('list', ['conditions' => ['courses_id' => $question->course_id]]);
        $this->set(compact('question', 'exams', 'themes'));
        
        $session->write('referer', $this->referer());
    }

    public function deletePic($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $question = $this->Questions->get($id);
        $question['pic'] = null;

        if ($this->Questions->save($question)) {
            $this->Flash->success(__('A imagem foi apagada.'));
        } else {
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        return $this->redirect(['action' => 'edit', $id]);
    }


    public function toggle($id = null)
    {
        if($this->request->is('post')) {
            $question = $this->Questions->get($id);
            if ($question['active'] == 1){$question['active'] = 0;} else {$question['active'] = 1;}
            $this->Questions->save($question);
            return $this->redirect($this->referer());
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
        $question = $this->Questions->get($id);
        if ($this->Questions->delete($question)) {
            $this->Flash->success(__('The question has been deleted.'));
        } else {
            $this->Flash->error(__('The question could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
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
        //$imagem_nome = strtolower(Inflector::slug($imagem_nome,'-'));
        $imagem_nome = substr(uniqid('', true), -5);
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

}
