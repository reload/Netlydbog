<?php 

/**
 * Adapter for eLib webservices
 * 
 * @author troelslenda
 *
 */

class eLibClient{
	
	private $elibUsr;
	private $retailerid;
	private $retailerkeycode;
	private $languagecode;
	private $sc_params;
	public $base_url;
	
	public function __construct($retailerid,$retailerkeycode,$languagecode){
		$this->retailerid = $retailerid;
		$this->retailerkeycode = $retailerkeycode;
		$this->languagecode = $languagecode;
		$this->sc_params = array(
	    'trace' => true, 
      'cache_wsdl' => WSDL_CACHE_NONE, 
      'proxy_host' => 'localhost', 
      'proxy_port' => 8080
	  );	
	}
	
	public function setLoaner($cardno,$pin){
		$this->elibUsr = new loaner($cardno,$pin);
	}
	
	public function validateUser(){
		if(is_a($this->elibUsr,'loaner')){
			$params = $this->elibUsr->loginParams();
			$response = $this->soapCall($this->base_url.'validatelibraryuser.asmx?WSDL','ValidateLibraryUser',$params);
			
			$xml = simplexml_load_string($response->ValidateLibraryUserResult->any);
			
			// if user credentials are valid 101 is returned in xml according to eLib
			if($xml->status->code == '101'){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			throw new Exception('no user instance');
		}
		
  }
  /**
   * 
   * @param int $isbn
   * @return SimpleXMLElement
   */
  public function getBook($isbn){
    if(is_int($isbn)){
      $response = $this->soapCall($this->base_url.'getproduct.asmx?WSDL','GetProduct',array('ebookid' => $isbn));
      return simplexml_load_string($response->GetProductResult->any);
    }
    else{
    	throw new Exception('the isbn need to be int');
    }
  }
  public function getBooks($fromdate){
    return $this->soapCall($this->base_url.'getproductlist.asmx?wsdl','GetProductList',array('countrycode'=> 'dk','fromdate' => $fromdate));
  }
  
  public function soapCall($wsdl,$func,$ext_params=NULL){
    $params = array(
      'retailerid' => $this->retailerid,
      'retailerkeycode' => md5($this->retailerkeycode),
      'languagecode' => $this->languagecode
    );
    if(is_array($ext_params)){
      $params = array_merge($params,$ext_params);
    }
    try{
      $request = new SoapClient($wsdl,$this->sc_params);
      return ($request->$func($params));
    }
    catch(Exception $e){
      watchdog('elib', 'validate_user_error: “@message”', array('@message' => $e->getMessage(), WATCHDOG_ERROR));
    }
  }
}
  

class loaner{
	
	private $cardno;
	private $pin;
	private $cpr;
	
	public function __construct($cardno='', $pin='',$cpr=''){
		$this->cardno = $cardno;
		$this->pin = $pin;
		$this->cpr = $cpr;
	}
	public function getId(){
		if($this->cardno == ''){
			return $this->cpr;
		}
		else{
			return $this->cardno;
		}
	}
	public function getPin(){
		return $this->pin;
	}
	public function loginParams(){
		return array(
		  'cardnumber' => $this->getId(),
      'pincode' => $this->getPin()
		);
	}
}

?>