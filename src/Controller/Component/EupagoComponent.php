<?php 
namespace App\Controller\Component;
use Cake\ORM\TableRegistry;

use Cake\Controller\Component;

class EupagoComponent extends Component
{
    public function select_payment_type($payment_type, $sale_id, $amount)
    {

        $chave_api = "a9e9-c61e-4326-27ee-4f41";

        if($payment_type == 1){

        } elseif($payment_type == 2){

            return $this->mb_ref($chave_api, $sale_id, $amount);

        } elseif($payment_type == 3){

        	return $this->bank_transfer($sale_id, $amount);

        } elseif($payment_type == 4){

        	return $this->cash($sale_id, $amount);
        }
    }


    public function mb_ref($chave_api, $nota_de_encomenda, $valor_da_encomenda ) {
        
        //Chamada do serviço SOAP - produção
        $client =new \SoapClient('https://clientes.eupago.pt/eupagov16.wsdl');

        //Cada canal tem a sua chave 
        $arraydados = array(
        "chave" => $chave_api, "valor"=>$valor_da_encomenda, "id" => $nota_de_encomenda, 'per_dup' => 0, 'data_fim' => date('Y-m-d', strtotime('+5 days'))
        );
        $result = $client->gerarReferenciaMBDL($arraydados);

        //Verifica erros na execução do serviço e exibe o resultado 
        if (is_soap_fault($result)) {
        trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring:
        {$result->faultstring})", E_ERROR); } else {
        //estados possíveis: 0 sucesso. -10 Chave inválida. -9 Valores incorretos 
            if ($result->estado == 0) {
                return $result;
        } else {
            } 
        }
    }

   


}