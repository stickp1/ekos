<?php 
namespace App\Controller\Component;
use Cake\ORM\TableRegistry;

use Cake\Controller\Component;

class MoloniComponent extends Component
{
    public function select_payment_type($payment_type, $sale_id, $amount)
    {
        if($payment_type == 1){

        } elseif($payment_type == 2){

            return $this->mb_ref($sale_id, $amount);

        } elseif($payment_type == 3){

        	return $this->bank_transfer($sale_id, $amount);

        } elseif($payment_type == 4){

        	return $this->cash($sale_id, $amount);
        }
    }


    public function get_token(){

        $this->Session = $this->request->session();

            $con = curl_init();
            $url = "https://api.moloni.pt/v1/grant/?grant_type=password&client_id=formekos&client_secret=4217f0fdd5d8eb363bda777e093d797b7aab5fa5&username=geral@ekos.pt&password=ekoswebsite";    /* Substituir pelo token atual */

                                 
            curl_setopt($con, CURLOPT_URL, $url);
            curl_setopt($con, CURLOPT_HEADER, false);
            curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
                                 
            $res_curl = curl_exec($con);
            curl_close($con);
                                 
            // análise do resultado
            $res_txt = json_decode($res_curl, true);

            $this->Session->write('moloni_token', $res_txt['access_token']);
        
        return $res_txt['access_token'];

    }

    private function get_costumer($id = null) {
        $this->Session = $this->request->session();
        $token = $this->Session->read('moloni_token');


        $table = TableRegistry::get('Users');
        $user = $table->find()
                    ->where(['id' => $id])
                    ->first();

        $con = curl_init();
        $url = "https://api.moloni.pt/v1/customers/countByVat/?access_token=$token";  
        $my_values = array('company_id' => 67506, 'vat' => $user['vat_number']);
                             
        curl_setopt($con, CURLOPT_URL, $url);
        curl_setopt($con, CURLOPT_POST, true);
        curl_setopt($con, CURLOPT_POSTFIELDS, http_build_query($my_values));
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
                             
        $res_curl = curl_exec($con);
        curl_close($con);
                             
        // análise do resultado
        $res_txt = json_decode($res_curl, true);
        if(!isset($res_txt['error'])){
            if($res_txt['count'] == 0){ //criar o utilizador
                $con = curl_init();
                $url = "https://api.moloni.pt/v1/customers/insert/?access_token=$token&human_errors=true";  
                $my_values = array(
                    'company_id' => 67506, 
                    'number' => 'WS'.$id, 
                    'vat' => $user['vat_number'], 
                    'name' => $user['first_name']." ".$user['last_name'], 
                    'language_id' => 1, 
                    'country_id' => 1, 
                    'maturity_date_id' => 393352, 
                    'payment_method_id' => 388907, 
                    'salesman_id' => 112226, 
                    'payment_day' => 0, 
                    'discount' => 0, 
                    'credit_limit' => 0,
                    'delivery_method_id' => 429131);
                                     
                curl_setopt($con, CURLOPT_URL, $url);
                curl_setopt($con, CURLOPT_POST, true);
                curl_setopt($con, CURLOPT_POSTFIELDS, http_build_query($my_values));
                curl_setopt($con, CURLOPT_HEADER, false);
                curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
                                     
                $res_curl = curl_exec($con);
                curl_close($con);
            }

            $con = curl_init();
            $url = "https://api.moloni.pt/v1/customers/getByVat/?access_token=$token";  
            $my_values = array('company_id' => 67506, 'vat' => $user['vat_number']);
                                 
            curl_setopt($con, CURLOPT_URL, $url);
            curl_setopt($con, CURLOPT_POST, true);
            curl_setopt($con, CURLOPT_POSTFIELDS, http_build_query($my_values));
            curl_setopt($con, CURLOPT_HEADER, false);
            curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
                                 
            $res_curl = curl_exec($con);
            curl_close($con);

            // análise do resultado
            return json_decode($res_curl, true)[0]['customer_id'];
            

        }
        else{
            if($res_txt['error_description'] == 'Invalid access token.'){
                $this->get_token();
                return $this->get_costumer($id);
            }
        }

    }

    private function get_product($id = null, $name) {
        $this->Session = $this->request->session();
        $token = $this->Session->read('moloni_token');


        $con = curl_init();
        $url = "https://api.moloni.pt/v1/products/getByReference/?access_token=$token";  
        $my_values = array('company_id' => 67506, 'reference' => "WS".$id);
                             
        curl_setopt($con, CURLOPT_URL, $url);
        curl_setopt($con, CURLOPT_POST, true);
        curl_setopt($con, CURLOPT_POSTFIELDS, http_build_query($my_values));
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
                             
        $res_curl = curl_exec($con);
        curl_close($con);
                             
        // análise do resultado
        $res_txt = json_decode($res_curl, true);

        if(!isset($res_txt['error'])){
            if(!$res_txt){ //criar o produto
                $con = curl_init();
                $url = "https://api.moloni.pt/v1/products/insert/?access_token=$token&human_errors=true";  
                $my_values = array(
                    'company_id' => 67506, 
                    'reference' => 'WS'.$id, 
                    'type' => 2,
                    'category_id' => 747137, 
                    'name' => $name, 
                    'price' => 0,
                    'unit_id' => 477102,
                    'has_stock' => 0,
                    'exemption_reason' => 0
                    );
                                     
                curl_setopt($con, CURLOPT_URL, $url);
                curl_setopt($con, CURLOPT_POST, true);
                curl_setopt($con, CURLOPT_POSTFIELDS, http_build_query($my_values));
                curl_setopt($con, CURLOPT_HEADER, false);
                curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
                                     
                $res_curl = curl_exec($con);
                curl_close($con);

                $con = curl_init();
                $url = "https://api.moloni.pt/v1/products/getByReference/?access_token=$token";  
                $my_values = array('company_id' => 67506, 'reference' => "WS".$id);
                                     
                curl_setopt($con, CURLOPT_URL, $url);
                curl_setopt($con, CURLOPT_POST, true);
                curl_setopt($con, CURLOPT_POSTFIELDS, http_build_query($my_values));
                curl_setopt($con, CURLOPT_HEADER, false);
                curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
                                     
                $res_curl = curl_exec($con);
                curl_close($con);

            }

            

            // análise do resultado
            return json_decode($res_curl, true)[0]['product_id'];
            

        }
        else{
            if($res_txt['error_description'] == 'Invalid access token.'){
                $this->get_token();
                return $this->get_product($id);
            }
        }

    }

    public function create_invoice($id){

        $table = TableRegistry::get('Sales');
        $sale = $table->find()
                    ->where(['id' => $id])
                    ->contain(['Products' => ['Courses']])
                    ->first();

        $costumer = $this->get_costumer($sale['users_id']);

        $products = array();
        foreach ($sale['products'] as $key => $product) {
            $products[$key]['product_id'] = $this->get_product($product['group_courses_id'], $product['course']['name']);
            $products[$key]['price'] = $product['value']/1.23;
            $products[$key]['qty'] = 1;
            $products[$key]['name'] = $product['course']['name'];
            $products[$key]['taxes'][0]['tax_id'] = 564042;
        }

        $token = $this->Session->read('moloni_token');
        $con = curl_init();
                $url = "https://api.moloni.pt/v1/invoiceReceipts/insert/?access_token=$token";  
                $my_values = array(
                    'company_id' => 67506, 
                    'date' => date("Y-m-d"),
                    'expiration_date' => date("Y-m-d"),
                    'document_set_id' => 116197,
                    'customer_id' => $costumer,
                    'status' => 1,
                    'products' => $products
                    );
                                     
                curl_setopt($con, CURLOPT_URL, $url);
                curl_setopt($con, CURLOPT_POST, true);
                curl_setopt($con, CURLOPT_POSTFIELDS, http_build_query($my_values));
                curl_setopt($con, CURLOPT_HEADER, false);
                curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
                                     
                $res_curl = curl_exec($con);
                curl_close($con);

                // análise do resultado
                $result = json_decode($res_curl, true);

        if(isset($result['valid'])){
            return $result['document_id'];
        } else {
            return 'error';
        }

    }

    public function get_invoice($id){

        $this->get_token();
        $token = $this->Session->read('moloni_token');
        $con = curl_init();
                $url = "https://api.moloni.pt/v1/documents/getPDFLink/?access_token=$token";  
                $my_values = array(
                    'company_id' => 67506, 
                    'document_id' => $id,
                    );
                                     
                curl_setopt($con, CURLOPT_URL, $url);
                curl_setopt($con, CURLOPT_POST, true);
                curl_setopt($con, CURLOPT_POSTFIELDS, http_build_query($my_values));
                curl_setopt($con, CURLOPT_HEADER, false);
                curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
                                     
                $res_curl = curl_exec($con);
                curl_close($con);

                // análise do resultado
                $result = json_decode($res_curl, true);

            return $result;

    }


}