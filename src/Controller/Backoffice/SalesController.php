<?php
namespace App\Controller\Backoffice;

use App\Controller\Backoffice\AppController;
use Cake\I18n\Number;
use Cake\I18n\Time;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Inflector;
use Cake\Mailer\Email;
use Cake\Routing\Router;


/**
 * Sales Controller
 *
 * @property \App\Model\Table\SalesTable $Sales
 *
 * @method \App\Model\Entity\Sale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalesController extends AppController
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

                                     <p color="#333"><b>A equipa da EKOS.</b></p>
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
    public function index($year = null)
    
    {
        $dates = $this->Sales->find('list', [
          'fields' => [
            'year' => 'year(datetime)',
            'month' => 'month(datetime)'
          ],
          'keyField' => 'year',
          'valueField' => 'month',
          'order' => [
            'year' => 'desc',
            'month' => 'asc'
          ]
        ]);
        $years = [];
        $startMonth = 10;
        if(!$year)
            $year = 0;


        foreach($dates as $y => $m)
        {
          $month = $m;
          $year_last = $y;
        }
        /*
        if($month < $startMonth)
        {
          foreach($dates as $y => $m)
            $years[$y.''] = intval($y-1)."/".$y;
          
        }
        else
        {
          foreach($dates as $y => $m)
            $years[intval($y+1).''] = $y."/".intval($y+1);
        }
        */
        foreach($dates as $y => $m)
            $years[$y.''] = intval($y-1)."/".$y;
        
        //$years = array_reverse($years);
        if (!$year){
          $year_aux = array_keys($years);
          $year = $year_aux[$year];
        }
        if(isset($_GET['name'])):
        $this->paginate = [
            'contain' => [
                'Users'
            ],
            'sortWhitelist' => [
                'Users.first_name',
                'Users.last_name',
                'datetime', 
                'value', 
                'status', 
                'Sales.id'
            ],
            'conditions' => [
                'OR' => [
                    'Users.first_name LIKE' => '%'.$_GET['name'].'%', 
                    'Users.last_name LIKE' => '%'.$_GET['name'].'%'
                ]
            ],
            'order' => [
                'Sales.id' => 'desc'
            ]
        ];

        else:
        $this->paginate = [
            'contain' => [
                'Users'
            ],
            'order' => [
                'Sales.id' => 'desc'
            ],
            'sortWhitelist' => [
                'Users.first_name', 
                'datetime', 
                'value', 
                'status', 
                'Sales.id'
            ],
            'conditions' => [
                'OR' => [
                    [
                      'year(datetime)' => $year,
                      'month(datetime) < ' => $startMonth
                    ],
                    [
                      'year(datetime)' => $year - 1,
                      'month(datetime) >= ' => $startMonth
                    ]
                ]
            ]
        ];
        endif;
        $sales = $this->paginate($this->Sales);

        $this->set(compact('sales', 'years', 'year'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    	$session = $this->getRequest()->getSession();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
                foreach ($this->request->getData('value') as $key => $value) {
                $product = $this->LoadModel('Products')->get($key);
                    $product['value'] = $value;
                    if(!$this->LoadModel('Products')->save($product)){$error = 1;}
                }

            $sum = $this->LoadModel('Products')->find('all', [
                'fields' => ['sum' => 'SUM(Products.value)'],
                'conditions' => ['sale_id' => $id]
            ])->first();

            $sale = $this->Sales->get($id);
            $sale['value'] = $sum['sum'];
            $this->Sales->save($sale);


            if (@$error != 1) {
                $this->Flash->success(__('Venda atualizada com sucesso.'));
            } else {
                $this->Flash->error(__('Ocorreu um erro.'));
            } 
        }


        $sale = $this->Sales->get($id, [
            'contain' => ['Users', 'Products' => ['Courses', 'Groups']]
            ]);
            
         $groups = $this->loadModel('Groups')->find('all', ['conditions' => ['active' => 1, 'deleted' => 0], 'contain' => ['Courses']]);

        $this->set(compact('sale', 'groups'));
        
        $session->write('referer', $this->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sale = $this->Sales->get($id);

        $query = $this->LoadModel('Products')->query();
             $query->delete()->where(['sale_id' => $id])->execute();

        if ($this->Sales->delete($sale)) {
            $this->Flash->success(__('A venda foi apagada.'));
        } else {
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        return $this->redirect($this->referer());
    }

    public function deleteInvoice($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sale = $this->Sales->get($id);
        $sale['invoice'] = null;

        if ($this->Sales->save($sale)) {
            $this->Flash->success(__('A fatura foi apagada.'));
        } else {
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        return $this->redirect(['action' => 'edit', $id]);
    }

    public function deleteProduct($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->loadModel('Products')->get($id);
        if ($this->loadModel('Products')->delete($product)) {
            
            $sum = $this->LoadModel('Products')->find('all', [
            'fields' => ['sum' => 'SUM(Products.value)'],
            'conditions' => ['sale_id' => $product['sale_id']]
            ])->first();

            $sale = $this->LoadModel('Sales')->get($product['sale_id']);
            $sale['value'] = $sum['sum'];
            $this->LoadModel('Sales')->save($sale);

            $this->Flash->success(__('O produto foi eliminado.'));
        } else {
            $this->Flash->error(__('Não foi possível eliminar o produto.'));
        }

        return $this->redirect(['action' => 'edit', $product['sale_id']]);
    }

    public function validate($id = null)
    {
    	$session = $this->getRequest()->getSession();
    	
        if ($this->request->is(['patch', 'post', 'put'])) {
           $datetime = new \DateTime();
           $date = $datetime->createFromFormat('d/m/Y H:i:s', $this->request->getData('date'));
            if(!$date){
                $this->Flash->error(__('O código inserido não é válido'));
                return $this->redirect(['action' => 'edit', $id]);
            } else {
                $exists = $this->LoadModel('Validations')->find('all', ['conditions' => ['datetime' => $date]]);
                if ($exists->count() > 0) {
                    return $this->redirect(['action' => 'edit', $id, 'e' => $exists->first()['sale_id']]);
                } else {
                    $this->validate_inscription($id, $date);
                }
            }
        }
    }

    public function validateMb(){
       $this->autoRender = false;
       
       $ref = $_GET['ref'];
       $id = $_GET['identificador'];

       $sale = $this->loadModel('Mb_references')->find('all', ['conditions' => ['referencia' => $ref, 'sale_id' => $id]]);
       if($sale->count() > 0){
         $this->validate_inscription($id, null);
       }
    }
    
    public function updatePT(){
    
    	$this->autoRender = false;
    	
    	$sales = $this->Sales->find('all', ['conditions'=> ['status' => 3, 'payment_type is null']])->toArray();
    	
    	foreach($sales as $sale){
	    	
	    	$eupago = $this->loadComponent('Eupago');
            $reference = $eupago->select_payment_type(2, $sale->id, $sale->value);
            if(@$reference->sucesso){
                $ref = $this->loadModel('mb_references')->newEntity();
                $ref['sale_id'] = $sale->id;
                $ref['entidade'] = $reference->entidade;
                $ref['referencia'] = $reference->referencia;
                $ref['valor'] = $reference->valor;
                $ref['estado'] = $reference->estado;
                $ref = $this->loadModel('mb_references')->save($ref);
                
                $sale['payment_type'] = 2;
                $this->Sales->save($sale);

            } 

    	}
    	
    }

    public function validate_inscription($id, $date){
    
    $session = $this->getRequest()->getSession();

      $products = $this->loadModel('Products')->find('all', ['conditions' => ['sale_id' => $id], 'contain' => ['Groups' => 'Courses']])->toArray();

                    //Adiciona às turmas
                    foreach ($products as $key => $value) {
                        $user_group = $this->loadModel('UsersGroups')->newEntity();
                        $user_group['groups_id'] = $value['group_id'];
                        $user_group['groups_courses_id'] = $value['group_courses_id'];
                        $user_group['users_id'] = $value['sales_users_id'];
                        $this->loadModel('UsersGroups')->save($user_group);
                    }

                    //Guarda código
                    if(isset($date)):
                    $validate_code = $this->loadModel('Validations')->newEntity();
                    $validate_code['datetime'] = $date;
                    $validate_code['sale_id'] = $id;
                    $this->loadModel('Validations')->save($validate_code);
                    endif;

                    //Atualiza estado da venda
                    $sale = $this->Sales->get($id, ['contain' => ['Users']]);
                    $sale['status'] = 1;
                   

                    //Emite fatura
                    if($sale['user']['vat_number'] == ''){
                      $this->Flash->error("Não foi possível emitir fatura por ausência de NIF.");
                    } else {

                      $moloni = $this->loadComponent('Moloni');

                      $invoice = $moloni->create_invoice($id);

                      if($invoice == 'error'){
                        $this->Flash->error("Ocorreu um erro na emissão de fatura.");
                      } else {
                        $sale['moloni_id'] = $invoice;
                      }
                    }

                    $this->Sales->save($sale);

                    //Envia email
                    $text = '<p>O pagamento da tua inscrição no curso de <b>'.$products[0]['group']['course']['name'].'</b> foi validado pela EKOS. Podes agora aceder a todos os ficheiros do curso na tua área reservada.</p>
                                <p>Bom estudo!</p>
                             ';

                    $user = $this->loadModel('Users')->get($user_group['users_id']); 

                        $body = $this->email_template($user['first_name'], $text);

                        $email = new Email('default');
                        $email->to($user['email'])
                            ->emailFormat('html')
                            ->subject('EKOS - Inscrição validada')
                            ->send($body);

                    if(isset($date)):
                      return $this->redirect($session->read('referer'));
                    else:
                      return $user;
                    endif;
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

        public function upload($id, $imagem = array(), $dir = 'img/invoices')
    {

        $dir = WWW_ROOT.$dir.DS;

        if($this->request->is('post')) {
            $imagem = $this->request->data['file'];

             if($imagem['error']!=0 || $imagem['size']==0) {
            $this->Flash->error('Alguma coisa deu errado, o upload retornou erro '.$imagem['error'].' e tamanho '.$imagem['size']);
            return $this->redirect(['action' => 'edit', $id]);
        }

            $this->checa_dir($dir);

            $imagem = $this->checa_nome($imagem, $dir);

            if ($path = $this->move_arquivos($imagem, $dir)) {
                $sale = $this->Sales->get($id);
                $sale['invoice'] = $path;
                $this->Sales->save($sale);
                $this->Flash->success('Fatura carregada com sucesso.');

            } else {
                $this->Flash->error('Ocorreu um erro');
            }

            return $this->redirect(['action' => 'edit', $id]);
        }

    }

    public function add()
    {
        $sale = $this->Sales->newEntity();
        $groups = $this->loadModel('Groups')->find('all', ['conditions' => ['active' => 1, 'deleted' => 0], 'contain' => ['Courses']]);

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $sale['users_id'] = $data['users_id'];
            $sale['value'] = 0;
            if($sale = $this->Sales->save($sale)) {

              $groups = $this->loadModel('Groups')->find('list', ['keyField' => 'id','valueField' => 'courses_id'])->toArray(); 
              
              $total = 0;
              foreach ($data['products'] as $key => $value) {

                if($value == 1){
                  $product = $this->loadModel('Products')->newEntity();
                  $product['group_id'] = $key;
                  $product['group_courses_id'] = $groups[$key];
                  $product['sale_id'] = $sale->id;
                  $product['sales_users_id'] = $data['users_id'];
                  $product['value'] = $data['price'][$key]; 
                  $product = $this->loadModel('Products')->save($product);
                  $total += $data['price'][$key];
				  }
              }
                
                $sale['value'] = $total;
                $sale['payment_type'] = 2;
                
                if($this->Sales->save($sale)):
		            $eupago = $this->loadComponent('Eupago');
		            $reference = $eupago->select_payment_type(2, $sale->id, $sale->value);
		            if(@$reference->sucesso){
		                $ref = $this->loadModel('mb_references')->newEntity();
		                $ref['sale_id'] = $sale->id;
		                $ref['entidade'] = $reference->entidade;
		                $ref['referencia'] = $reference->referencia;
		                $ref['valor'] = $reference->valor;
		                $ref['estado'] = $reference->estado;
		                $ref = $this->loadModel('mb_references')->save($ref);
		                return $this->redirect(['action' => 'index']);
		            } else {
		                $this->loadModel('Products')->deleteAll(['sale_id' => $sale->id]);
		                $this->loadModel('sales')->delete($sale);
		                $this->Flash->error(__('Ocorreu um erro.'));
		            }
		        endif;
		        
		     }


        }

        $this->set(compact('sale', 'groups'));
    }
    
    
    public function addProduct($sale_id = null)
    {
    	  $data = $this->request->getData();
    	  
    	  $group = $this->loadModel('Groups')->get($data['group_id']);
    
    	  $product = $this->loadModel('Products')->newEntity();
	      $product['group_id'] = $data['group_id'];
	      $product['group_courses_id'] = $group['courses_id'];
	      $product['sale_id'] = $sale_id;
	      $product['sales_users_id'] = $data['users_id'];
	      $product['value'] = 0; 
	      $product = $this->loadModel('Products')->save($product);
	      
	      
	      
	      return $this->redirect($this->referer());
	      
    }

    public function addInvoice($sale_id = null)
    {

      $this->autoRender = false;

      $sale = $this->loadModel('Sales')->get($sale_id, ['contain' => ['Users']]);

      if($sale['moloni_id'] != '' || $sale['invoice'] != ''){
        $this->Flash->error("Fatura já emitida.");
        return $this->redirect($this->referer());
      }

      if($sale['user']['vat_number'] == ''){
        $this->Flash->error("Não foi possível emitir fatura por ausência de NIF.");
        return $this->redirect($this->referer());
      }


      $moloni = $this->loadComponent('Moloni');

      $invoice = $moloni->create_invoice($sale_id);

      if($invoice == 'error'){
        $this->Flash->error("Ocorreu um erro.");
        return $this->redirect($this->referer());
      } else {
        $sale['moloni_id'] = $invoice;
        $sale = $this->loadModel('Sales')->save($sale);
        $this->Flash->success("Fatura emitida com sucesso.");
        return $this->redirect($this->referer());
      }

    }

     public function getInvoice($id = null) {
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
}
