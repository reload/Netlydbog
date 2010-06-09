<?php 

class eLibClient{
	
	private $elibUsr;
	private $retailerid;
	private $retailerkeycode;
	private $languagecode;
	private $baseurl;
	private $sc_params;
	
	public function __construct($retailerid,$retailerkeycode,$languagecode){
		$this->retailerid = $retailerid;
		$this->retailerkeycode = $retailerkeycode;
		$this->languagecode = $languagecode;
		$this->baseurl = 'http://localhost:8080/webservices/';
	  $this->sc_params = array(
	    'trace' => true, 
      'cache_wsdl' => WSDL_CACHE_NONE, 
      'proxy_host' => 'localhost', 
      'proxy_port' => 8080
	  );	
	}
	public function validateUser($cardno,$pin){
		try{
			$request = new SoapClient($this->baseurl.'validatelibraryuser.asmx?wsdl',$this->sc_params);
		}
		catch(Exception $e){
			//$this->echoError($e->getMessage());
		}
	}
}
  



/*class eLibUser{
	private $cardnumber;
	private $pin;
	
	public function validateUser(){
		try{
			$request = new SoapClient('localhost:8080/webservices/validatelibraryuser.asmx?WSDL');
			
			var_dump($request->__getFunctions());
		}
		catch (Exception $e){
			print $e->getMessage();
		}
		
	}
	
	public function __construct($cardnumber,$pin){
		$this->cardnumber = $cardnumber;
		#TODO: salt the pin?
		$this->pin = $pin;
	}
	public function getCardNo(){
		return $this->cardnumber;
	}
	public function getPin(){
		return $this->pin;
	}
}
*/


$client = new eLibClient('810',md5('der89pot'),'da');





?>