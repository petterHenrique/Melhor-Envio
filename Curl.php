<?php
/**
 * User: Srdi
 * Date: 18-Feb-17
 * Time: 20:42
 */
class Curl
{

	private $headers = array();
	private $curl;
	private $callback;

	public function __construct(){
		$this->init();
	}

	private function init(){
		$this->curl = curl_init();
	}

	public function setOpt($option, $value)
    {
        return curl_setopt($this->curl, $option, $value);
    }

    public function setHeader($key, $value)
    {
        $this->headers[$key] = $key.': '.$value;
        $this->setOpt(CURLOPT_HTTPHEADER, array_values($this->headers));
        return $this;
    }
    /**
     * GET alias for request method
     *
     * @param $url
     * @param array $params
     * @param array $headers
     * @param array $userOptions
     * @return mixed
     */
    public function get($url, $params = array(), $userOptions = array(), $headers = false) {
        return $this->request('GET',$url,$params, $this->headers, $userOptions, $headers);
    }

    public function getMelhor($url){
    	$ch = $this->curl;
        $this->setOpt(CURLOPT_URL, $url);
        $this->setOpt(CURLOPT_RETURNTRANSFER, true);
        $this->setOpt(CURLOPT_HTTPHEADER, $this->headers);
        $this->callback = json_decode(curl_exec($ch));
        curl_close($ch);
    }


    /**
     * POST alis for request method
     *
     * @param $url
     * @param array $params
     * @param array $headers
     * @param array $userOptions
     * @return mixed
     */

    public function postMelhor($url, $params){
    	
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        $this->callback = json_decode(curl_exec($ch));
        curl_close($ch);
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function post($url, $params = array(), $userOptions = array()) {
        return $this->request('POST',$url,$params,$this->headers, $userOptions);
    }
    /**
     * Curl run request
     *
     * @param $method
     * @param string $url
     * @param array $params
     * @param array $headers
     * @param array $userOptions
     * @return mixed
     * @throws Exception
     */
    private function request($method, $url, $params = array(), $headers = array(), $userOptions = array(), $boolheaders) {
        $ch = $this->curl;
        $method = strtoupper($method);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => $boolheaders== true ? $headers : 
            array(
				'Content-Type' =>'application/json'
            )
        );
        array_merge($options,$userOptions);
        switch ($method) {
            case 'GET':
                if($params) {
                    $url = $url.'?'.http_build_query($params);
                }
                break;
            case 'POST':
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('Unsuported method.');
                break;
        }
        $options[CURLOPT_URL] = $url;

        //echo var_dump($options);

        curl_setopt_array($ch, $options);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($options));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        if($errno = curl_errno($ch)) {
            var_dump($errno);
            $errorMessage = curl_strerror($errno);
            throw new Exception("Curl error $errno - $errorMessage");
        }
        curl_close($ch);
        return $response;
    }
}