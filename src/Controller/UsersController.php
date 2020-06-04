<?php
namespace App\Controller;

use App\Controller\AppController;
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
     /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function register()
    {

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user['pic'] = "/img/avatar.jpg";
            $user['reset_char'] = md5(uniqid(time(), true));
            $refer_url = $this->referer('/', true);
            $url_params = Router::parse($refer_url);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registo efetuado com sucesso. Ativa a tua conta através do email de confirmação.'));

                $text = '<p>Bem-vindo à EKOS, a tua escola de preparação para a Prova Nacional de Acesso.</p>
                     <p>O teu processo de registo está praticamente concluído. Basta agora ativares a conta através do botão abaixo.</p>
                     <p><b>Vemo-nos em breve!</b></p>
                     <a class="btn" style="background-color: #ccc; color: #152335; cursor: pointer; display: inline-block; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-weight: bold; margin: 0; margin-right: 10px; padding: 10px 16px; text-align: center; text-decoration: none;" href="'.Router::url(['action' => 'activate', $user['reset_char']], true).'">Ativar</a>';
                                    
                $body = $this->email_template($this->request->data['first_name'], $text);

                $email = new Email('default');
                $email->to($this->request->data['email'])
                    ->emailFormat('html')
                    ->subject('Bem-Vindo à EKOS - Email de Confirmacao')
                    ->send($body);

                
                 return $this->redirect(['prefix' => @$url_params['prefix'], 'controller' => $url_params['controller'], 'action' => $url_params['action']]);
            }

            foreach ($user->errors() as $key => $value) {
                if ($key == "first_name") $field = "<u>nome</u>";
                if ($key == "last_name") $field = "<u>apelido</u>";
                if ($key == "email") $field = "<u>email</u>";
                if ($key == "password") $field = "<u>password</u>";
                if ($key == "vat_number") $field = "<u> NIF</u>";
                if (!isset($value['unique'])){
                 @$error .= "Ocorreu um erro com o $field inserido. <br>";} else {
                    @$error .= "O $field inserido já se encontra registado. <br>";
                 }
             } ;
                $error .= "O utilizador não foi gravado.";
            $this->getRequest()->getSession()->write('error', $error);
            return $this->redirect(['prefix' => @$url_params['prefix'], 'controller' => $url_params['controller'], 'action' => $url_params['action'], 'e' => 2]);
        }
        $this->set(compact('user'));
    }


    public function activate($char)
    {

        $user = $this->Users->find('all', ['conditions' => ['reset_char' => $char]])->first();
        if($user) {
            $user['reset_char'] = null;
            $user['active'] = 1;

            if($this->Users->save($user)) {
                $this->Flash->success(__('Conta ativada com sucesso'));
            }
            else {
                $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
            }
        } 

        return $this->redirect(['controller' => '/']);
    }

    public function reset($char = null)
    {

        if($this->request->is('post')) {

            if(@$this->request->data['char']) {
                $user = $this->Users->find('all', ['conditions' => ['reset_char' => $this->request->data['char']]])->first();
                $user = $this->Users->patchEntity($user, $this->request->getData());
                $user['reset_char'] = null;

                if($this->Users->save($user)) {
                    $this->Flash->success(__('Palavra-passe alterada com sucesso.'));
                }
                else {
                    $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
                }

             return $this->redirect(['controller' => '/']);

            } else {

                $user = $this->Users->find('all', ['conditions' => ['email' => $this->request->data['email'], 'active' => 1]])->first();
                if($user){
                    $user['reset_char'] = md5(uniqid(time(), true));
                     if ($this->Users->save($user)) {
                        $this->Flash->success(__('Foi-te enviado um email com as instruções para procederes à mudança de password.'));

                        $text = '<p>Foi efetuado um pedido de recuperação da password da tua conta na EKOS.</p>
                                <p>Carrega no botão abaixo e segue as instruções para alterares a password da tua conta.</p>
                             <a class="btn" style="background-color: #ccc; color: #152335; cursor: pointer; display: inline-block; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-weight: bold; margin: 0; margin-right: 10px; padding: 10px 16px; text-align: center; text-decoration: none;" href="'.Router::url(['action' => 'reset', $user['reset_char']], true).'">Recuperar</a>';
                                            
                        $body = $this->email_template($user['first_name'], $text);

                        $email = new Email('default');
                        $email->to($this->request->data['email'])
                            ->emailFormat('html')
                            ->subject('EKOS - Recuperar Password')
                            ->send($body);

                        return $this->redirect(['controller' => '/']);
                    }
                } else {
                    $this->Flash->error(__('Endereço de email não registado.'));
                }
            }
        } 

        if($this->Auth->user()){
            return $this->redirect(['controller' => '/']);
        }
        
        if($char) {
            if($this->Users->find('all', ['conditions' => ['reset_char' => $char]])->first()) {
                $this->set(compact('char'));
            }
        }    
    }
    

    public function login()
    {
        if($this->Auth->user()){
            return $this->redirect(['controller' => '/']);
        }

        if ($this->request->is('post')) {
            $user = $this->Users->find('all', ['conditions' => ['email' => $this->request->data['email'], 'active' => 1]])->first();
            $refer_url = $this->referer('/', true);
            $url_params = Router::parse($refer_url);
            if ((new DefaultPasswordHasher)->check($this->request->data['password'], $user['password'])) {
                $this->Auth->setUser($user);
                $this->loadModel('Sessions')->deleteAll(['id' => $user->session_id]);
                $user->session_id = $this->request->session()->id();
                $user = $this->Users->save($user);
                if(isset($_GET['redirect'])){
                    return $this->redirect($_GET['redirect']);
                } else {
                    return $this->redirect($this->referer());
                    //return $this->redirect(['prefix' => @$url_params['prefix'], 'controller' => $url_params['controller'], 'action' => $url_params['action']]);
                } 
            } else {
                return $this->redirect($this->referer());
                //return $this->redirect(['prefix' => @$url_params['prefix'], 'controller' => $url_params['controller'], 'action' => $url_params['action'], 'e' => 1]);
            }
        }
    }


    public function logout()
    {
        $this->Auth->logout();
        return $this->redirect(['prefix' => false, 'controller' => '/']);
    }

    public function validaEmail()
    {
      $this->autoRender=false;
      $email = $_GET['email'];
      //Limpamos eventuais espaços a mais
      $email=trim($email);

      $existing = $this->Users->find('all', ['conditions' => ['email' => $email]])->first();
      if(empty($existing) || $existing['id']===$this->Auth->user('id'))
        return $this->response->withStatus(201);
      else
        return $this->response->withStatus(401);
    }

   public function changePassword()
    {
      $user = $this->Auth->user();
      if($this->request->is(['post','put'])) {
        $this->Users->patchEntity($user, $this->request->getData(),[
          'accessibleFields' => [
            '*' => false,
            'password' => true,
          ]
        ]);
      }
      if($this->Users->save($user)){
        $this->Flash->success(__('Alterações efetuadas com sucesso.'));
      } else {
         $error .= "As alterações não foram efetuadas com sucesso.";
         $this->getRequest()->getSession()->write('error', $error);
      }
      return $this->redirect(['controller' => 'reserved', 'action' => 'profile']);
    }

    

    public function validaNIF() {

    $this->autoRender = false ;
    $nif = $_GET['vat_number'];
    //Limpamos eventuais espaços a mais
    $nif=trim($nif);
    //Verificamos se é numérico e tem comprimento 9
    if (!is_numeric($nif) || strlen($nif)!=9) {
        $response = $this->response->withStatus(401);
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
                $response = $this->response->withStatus(201);
            } else {
            $response = $this->response->withStatus(402);            }
        } else {
            $response = $this->response->withStatus(403);        }
      }
    
      return $response;
    }
}
