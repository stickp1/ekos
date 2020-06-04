<?php
namespace App\Controller\Backoffice;

use App\Controller\Backoffice\AppController;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Inflector;

/**
 * Courses Controller
 *
 * @property \App\Model\Table\CoursesTable $Courses
 *
 * @method \App\Model\Entity\Course[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UploaderController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
      $courses_list = $this->LoadModel('Courses')->find('list')->toArray();
      
      if($this->Auth->user('role') != 3):
      foreach ($courses_list as $key => $value) {
          if(!in_array($key, $this->viewVars['Auth']['moderator'])){
            unset($courses_list[$key]);
          }
      };
      endif;

      $this->set(compact('courses_list'));
    }
    
    public function documents()
    {
		    $uploads = $this->loadModel('Uploads')->find('all', [
            'contain' => [
                'Users'
            ], 	
            'conditions' => [
                'theme_id <=' => 0,
                'Uploads.active' => 1
            ],
            'fields' => [
                'theme_id',
                'id',
                'name',
                'type',
                'Users.first_name',
                'Users.last_name',
                'timestamp',
                'active',
            ],
            'group' => 'theme_id',
            'group' => 'timestamp'
        ])->toArray();


        $categories = $this->Uploads->find('all', [
            'conditions' => [
                'theme_id <=' => 0
            ],
            'fields' => [
                'theme_id', 
            ],
        ])->distinct();

        $this->set(compact('uploads', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lecture id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $file = $this->loadModel('Uploads')->get($id);
        if($file['theme_id'] > 0) { //SE NÃO FOR UM DOCUMENTO
	        $course_id = $this->loadModel('Themes')->get($file['theme_id'])['courses_id'];
	
	        if(($this->Auth->user('role') == 1 && $file['owner'] != $this->Auth->user('id') ) || ($this->Auth->user('role') == 2 && !in_array($course_id, $this->viewVars['Auth']['moderator']) ) ){
	
	            $this->Flash->error(__('Não tens permissão para aceder à página solicitada.'));
	            return $this->redirect(['action' => 'index']);
	        }
	     }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $file = $this->loadModel('Uploads')->patchEntity($file, $this->request->getData());
            if ($this->loadModel('Uploads')->save($file)) {
                $this->Flash->success(__('Ficheiro atualizado com sucesso.'));
				
				if($file['theme_id'] > 0) { //SE NÃO FOR UM DOCUMENTO
                	return $this->redirect(['action' => 'index', 'c' => $course_id, 't' => $file['theme_id']]);
                } else {
	                return $this->redirect(['action' => 'documents']);
                }
            }
            $this->Flash->error(__('Ocorreu um erro.'));
        }

        $this->set(compact('file'));
    }


    public function listFiles($id)
    {
        $this->layout = false;

		
		    $user = $this->Auth->user();

		
		    if($user['role'] == 3) { // Se for administrador, pode ver todas as cidades
        	$uploads = $this->loadModel('Uploads')->find('all', ['contain' => ['Users', 'Cities'], 'conditions' => ['theme_id' => $id]])->toArray();
        	
        } else {
	        $uploads = $this->loadModel('Uploads')->find('all', ['contain' => ['Users', 'Cities'], 'conditions' => ['theme_id' => $id, 'Uploads.city_id' => $user['city_id']]])->toArray();
	       
        }

		 
        $this->set(compact('uploads'));
    }

    public function listThemes($id)
    {
        $this->layout = false;
       

        $themes = $this->loadModel('Themes')->find('list', ['conditions' => ['courses_id' => $id]])->toArray();
        

        $this->set(compact('themes'));
       
    }

    public function deleteFile($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $file = $this->loadModel('Uploads')->get($id);
        if ($this->loadModel('Uploads')->delete($file)) {
            $this->Flash->success(__('O ficheiro foi eliminado.'));
        } else {
            $this->Flash->error(__('Não foi possível eliminar o ficheiro.'));
        }

		    if($file['theme_id'] > 0) { //SE NÃO FOR UM DOCUMENTO
			   $course_id = $this->loadModel('Themes')->get($file['theme_id'])['courses_id'];
	        return $this->redirect(['action' => 'index', 'c' => $course_id, 't' => $file['theme_id']]);
	       } else {
		      return $this->redirect(['action' => 'documents']);	    
		    }
    }



    public function toggleFile($id = null)
    {
        if($this->request->is('post')) {
            $file = $this->loadModel('Uploads')->get($id);
            
            if ($file['active'] == 1){$file['active'] = 0;} else {$file['active'] = 1;}
                $this->loadModel('Uploads')->save($file);
                
                if($file['theme_id'] > 0) { //SE NÃO FOR UM DOCUMENTO
    				      $course_id = $this->loadModel('Themes')->get($file['theme_id'])['courses_id'];
    		          return $this->redirect(['action' => 'index', 'c' => $course_id, 't' => $file['theme_id']]);
    	          } else {
    		          return $this->redirect(['action' => 'documents']);	    
    		        }
            }
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

        public function upload($imagem = array(), $dir = 'img/uploads')
    {

        $dir = WWW_ROOT.$dir.DS;

        if($this->request->is('post')) {
            $imagem = $this->request->data['file'];

            if($imagem['error']!=0 || $imagem['size']==0) {
                $this->Flash->error('Alguma coisa deu errado, o upload retornou erro '.$imagem['error'].' e tamanho '.$imagem['size']);
                return $this->redirect(['action' => 'index']);
            }

            $this->checa_dir($dir);

            $imagem = $this->checa_nome($imagem, $dir);

            if ($path = $this->move_arquivos($imagem, $dir)) {
                $upload = $this->loadModel('Uploads')->newEntity();
                $upload['name'] = $imagem['name'];
                $upload['type'] = $imagem['type'];
                $upload['owner'] = $this->Auth->user('id');
                $upload['theme_id'] = $this->request->data['theme_id'];
                $upload['city_id'] = $this->request->data['city_id'];
                $upload['url'] = $path;
                $upload = $this->loadModel('Uploads')->save($upload);
                $this->Flash->success('Ficheiro carregado com sucesso.');

            } else {
                $this->Flash->error('Ocorreu um erro');
            }

      			if($this->request->data['theme_id'] > 0){
                $course_id = $this->loadModel('Themes')->get($upload['theme_id'])['courses_id'];
                return $this->redirect(['action' => 'index', 'c' => $course_id, 't' => $upload['theme_id']]);
            } else {
      	        return $this->redirect(['action' => 'documents']);
            }
        }

    }

}
