<?php
namespace App\Controller\Backoffice;

use App\Controller\Backoffice\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Mailer\Email;
use Cake\Routing\Router;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function login()
    {
        $this->viewBuilder()->setLayout('login');
        
        if($this->Auth->user()){
            return $this->redirect(['controller' => '/']);
        }

        if ($this->request->is('post')) {
            $user = $this->Users->find('all', ['conditions' => ['email' => $this->request->data['email'], 'active' => 1]])->first();

            if ((new DefaultPasswordHasher)->check($this->request->data['password'], $user['password'])) {
                $this->Auth->setUser($user);
                if(isset($_GET['redirect'])){
                    return $this->redirect($_GET['redirect']);
                } else {
                    return $this->redirect(['prefix' => 'backoffice', 'controller' => '/']);
                }
            } else {
                $this->Flash->error('Utilizador ou password errados.');
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Moderators']
        ]);

        if(isset($_GET['img'])) {
            if ($_GET['img'] == 1){
                $this->Flash->success(__('Imagem atualizada com sucesso.'));
            } elseif ($_GET['img'] == 2){
                $this->Flash->error(__('Ocorreu um erro ao guardar a imagem.'));
            }
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
			

            //Atualizar permissões
        if(count($this->request->getData('privileges')) > 0){
            $privileges = implode(",",$this->request->getData('privileges')); 
            
        
            $query = $this->LoadModel('Moderators')->query();
            $query->delete()->where(['users_id' => 
                $user['id'], "courses_id NOT IN ($privileges)"])->execute();

            foreach ($this->request->getData('privileges') as $privilege) {
                $moderator = $this->LoadModel('Moderators')->find('all', ['conditions' => ['users_id' => $user['id'], 'courses_id' => $privilege]]);

                if($moderator->count() < 1){
                    $n_privilege = $this->LoadModel('Moderators')->newEntity();
                    $n_privilege['users_id'] = $user['id'];
                    $n_privilege['courses_id'] = $privilege;
                    $n_privilege = $this->LoadModel('Moderators')->save($n_privilege);
                }
            }
        } else {
            $query = $this->LoadModel('Moderators')->query();
            $query->delete()->where(['users_id' => $user['id']])->execute();
        }

            
            if ($user['vat_number'] != '' && !$this->validaNIF($user['vat_number'])) {
                $this->Flash->error(__('O número de contribuinte inserido não é válido.'));
            } else {
                if ($this->Users->save($user)) {
                	
                    $this->Flash->success(__('Utilizador guardado com sucesso.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }

        $role = [0 => 'Formando', 1 => 'Formador', 2 => 'Coordenador', 3 => 'Administrador', 4 => 'Coordenador Local'];
        $cities = $this->loadModel('Cities')->find('list');

        foreach ($user['moderators'] as $key => $value) {
            $moderator[$key] = $value['courses_id'];
        }
        $this->set(compact('user', 'role', 'moderator', 'cities'));
    }

     /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        if(isset($_GET['s'])):
        $this->paginate = [
            'conditions' => ['OR' => ['first_name LIKE' => '%'.$_GET['s'].'%', 'last_name LIKE' => '%'.$_GET['s'].'%', 'email LIKE' => '%'.$_GET['s'].'%'], 'active' => 1]
        ];

        else:
            $this->paginate = [
            'conditions' => ['active' => 1]
        ];
       
        endif;

        $users = $this->paginate($this->Users);

        $this->set(compact('users'));

    }

    public function userList() {

        $this->layout = false;
        
        if(isset($_GET['search'])){

        $user = $this->Users->find('all', [
            'conditions' => ['OR' => ['first_name LIKE' => "%".$_GET['search']."%", 'last_name LIKE' => "%".$_GET['search']."%", 'email LIKE' => "%".$_GET['search']."%"]],
            ]);

        foreach ($user->toArray() as $key => $value) {
            $users['results'][$key]['id'] = $value['id'];
            $users['results'][$key]['text'] = $value['first_name']." ".$value['last_name']." - ".$value['email'];
        }

        
        $this->set(compact('users'));

        }

    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function validaNIF($nif, $ignoreFirst=true) {
    //Limpamos eventuais espaços a mais
    $nif=trim($nif);
    //Verificamos se é numérico e tem comprimento 9
    if (!is_numeric($nif) || strlen($nif)!=9) {
        return false;
    } else {
        $nifSplit=str_split($nif);
        //O primeiro digíto tem de ser 1, 2, 5, 6, 8 ou 9
        //Ou não, se optarmos por ignorar esta "regra"
        if (
            in_array($nifSplit[0], array(1, 2, 5, 6, 8, 9))
            ||
            $ignoreFirst
        ) {
            //Calculamos o dígito de controlo
            $checkDigit=0;
            for($i=0; $i<8; $i++) {
                $checkDigit+=$nifSplit[$i]*(10-$i-1);
            }
            $checkDigit=11-($checkDigit % 11);
            //Se der 10 então o dígito de controlo tem de ser 0
            if($checkDigit>=10) $checkDigit=0;
            //Comparamos com o último dígito
            if ($checkDigit==$nifSplit[8]) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
      }
    }

    public function image(){

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
                    $user = $this->Users->get($id);
                    $user['pic'] = Router::url(['prefix' => false, 'controller' => '/', 'action' => 'img'])."/pics/".$name.'.png';
                    $this->Users->save($user);

                    echo "success";} else {echo "error";}

        }
    }
}
