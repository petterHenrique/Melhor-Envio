<?php

include ("Curl.php");

class MelhorEnvio{

	private $token;

	private $urlBase;

	private $curlInstance;

	public function __construct($token, $urlBase){

		$this->token = $token;
		$this->urlBase = $urlBase;
		$this->init();
	}

	private function init(){
		$this->curlInstance = new Curl();
		$this->curlInstance->setHeader("accept",  "application/json");
		$this->curlInstance->setHeader("authorization",  "Bearer {$this->token}");
		$this->curlInstance->setHeader("content-type", "application/json");
	}

	public function listarTransportadoras(){
		
		$lista = $this->curlInstance->getMelhor("{$this->urlBase}/shipment/companies");

		$arrayTransportadoras = array();

		$transportadoras = $this->curlInstance->getCallback();

		foreach ($transportadoras as $transportadora) {
			
			$objeto = array(
				'codigoServico' => $transportadora->id,
				'nome' => $transportadora->name
			);

			array_push($arrayTransportadoras, (object)$objeto);
		}

		return $arrayTransportadoras;
	}

	public function calcularFrete($from, $to, $produtos, $options, $services){

		$parametros = array(
			"from" => [
				"postal_code" => $from->cep,
				"address" => $from->endereco,
				"number" => $from->numero
			],
			"to" => [
				"postal_code" => $to->cep,
				"address" => $to->endereco,
				"number" => $to->numero
			],
			"products" => [],
			"options" => [
				"receipt" => false, 
			    "own_hand" => false, 
			    "collect" => false
			],
			"services" => "1,2"
		);
		
		$indice = 0;

		foreach ($produtos as $produto) {

			$parametros['products'][$indice]['weight'] = $produto->peso;
			$parametros['products'][$indice]['width'] = $produto->largura;
			$parametros['products'][$indice]['height'] = $produto->altura;
			$parametros['products'][$indice]['length'] = $produto->comprimento;
			$parametros['products'][$indice]['quantity'] = $produto->qtd;
			$parametros['products'][$indice]['insurance_value'] = 100;

			$indice++;
		}

		$this->curlInstance->postMelhor("{$this->urlBase}/shipment/calculate", $parametros);

		$resposta = $this->curlInstance->getCallback();

		
		return $this->tratarRespostaCalcularFrete($resposta);

	}

	private function tratarRespostaCalcularFrete($json){

		$response = array(
			'fretes' => [],
			'erros' => []
		);

		//se existir erro
		if(!empty($json->message) && !empty($json->errors)){

			$i=0;

			foreach ($json->errors as $erro) {
				$response['erros'][$i][] = $erro;
			}

		}else{

			$indice = 0;

			foreach ($json as $frete) {

				$objeto = array(
					'nome' => $frete->name,
					'preco' => $frete->custom_price,
					'prazoEntrega' => $frete->delivery_time
				);

				$response['fretes'][$indice][] = $objeto;

				$indice ++;
			}
		}

		return $response;
	}

}





?>