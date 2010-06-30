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
	
	public function __construct($languagecode){
		//$this->retailerid = $retailerid;
		//$this->retailerkeycode = $retailerkeycode;
		$this->languagecode = $languagecode;
		$this->sc_params = array(
	    'trace' => true, 
      'cache_wsdl' => WSDL_CACHE_NONE, 
      #'proxy_host' => 'localhost', 
      #'proxy_port' => 8080
	  );	
	}
	public function GetUrl($retailerorderid){
		$params['retailerorderid'] = $retailerorderid;
		$params['md5checksum'] = md5($this->retailerid.$retailerorderid.$this->retailerkeycode);
		
		$response = $this->soapCall($this->base_url.'getlibraryloanurl.asmx?WSDL','GetLibraryLoanUrl',$params);
		
		$xml = simplexml_load_string($response->GetLibraryLoanUrlResult->any);
		return $xml;
	}
	
	public function setLibrary($lib){
		$this->retailerid = $lib;
    $this->retailerkeycode = elib_libraries_get_library_keycode($lib);
	}
	
	public function setLoaner($cardno,$pin,$lib){
		$this->retailerid = $lib;
		$this->retailerkeycode = elib_libraries_get_library_keycode($lib);
		if(strlen($cardno)>9){
		  $this->elibUsr = new loaner($cardno,$pin);	
		}
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
			throw new Exception('No user instance: '.__FUNCTION__);
		}
  }
  public function getNewBooks(){
  	$params['top'] = 5;
  	$params['listtype'] = 1;
  	$params['fromdate'] = date('Y-m-d',time()-12592000);
  	
  	$response = $this->soapCall($this->base_url.'getlibrarylist.asmx?WSDL','GetNewBooks',$params);
  	
  	$xml = array();
  	if(simplexml_load_string($response->GetNewBooksResult->any)){
  		$xml = simplexml_load_string($response->GetNewBooksResult->any);
  	}
  	
  	return $xml;
  	
  }
  public function getLatestLoans(){
    
  	$params['fromdate'] = date('Y-m-d',time()-2592000);
    
  	$response = $this->soapCall($this->base_url.'getlibrarylist.asmx?WSDL','GetLastLoans',$params);
  	$xml = simplexml_load_string($response->GetLastLoansResult->any);

  	//var_dump($xml);
  	
  	$ids = array();
  	
    if(($xml->data->orderinformationitem)){
      foreach($xml->data->orderinformationitem as $line){
        if(!in_array(trim($line->ebookid),$ids)){
          $ids[] = trim($line->ebookid);
        }
      }
  	}
  	
  //	var_dump($ids);
  	
  	return array_reverse($ids);
  
  	
  	
  	
  }
  public function makeLoan($ebookid,$format){
  	if(is_a($this->elibUsr,'loaner')){
	  	switch ($format){
	  		case 'stream':
	  			$f = 71;
	  			break;
	  		default:
	  			$f = 75;
	  			break;
	  	}
	  	$params = $this->elibUsr->loginParams();
	  	$params['ebookid'] = $ebookid;
	  	//krumo($f);
	  	$params['format'] = $f;
	  	$params['mobipocketid'] = '';
	  	krumo($params);
	  	
	  	$response = $this->soapCall($this->base_url.'createloan.asmx?WSDL','CreateLoan',$params);
	  	 	 	
	  	$xml = simplexml_load_string($response->CreateLoanResult->any);
	  	
	  	return $xml;
  	}
    else{
      throw new Exception('No user instance: '.__FUNCTION__);
    }
  	
  }
  
  // not used?!
  public function getSingleLoan($retailerorderid){
  	$response = $this->soapCall($this->base_url.'getlibraryuserorder.asmx?WSDL','GetLibraryUserOrder',array('retailerorderid' => $retailerorderid));
  	$xml = simplexml_load_string($response->GetLibraryUserOrderResult->any);    
    return $xml->data->orderitem;
    
  }
  public function getLoans(){
  	
  	if(is_a($this->elibUsr,'loaner')){
	  	$response = $this->soapCall($this->base_url.'getlibraryuserorderlist.asmx?WSDL','GetLibraryUserOrderList',array('cardnumber' => $this->elibUsr->getId()));
	   	$xml = simplexml_load_string($response->GetLibraryUserOrderListResult->any);
	  	return $xml->data;
  	}
    else{
      throw new Exception('No user instance: '.__FUNCTION__);
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
      $request = @new SoapClient($wsdl,$this->sc_params);
      return ($request->$func($params));
    }
    catch(Exception $e){
      elib_display_error($e);
    	//	print ('Der er sket en fejl i forbindelsen med eLib: '. $e->getMessage());
     // watchdog('elib', 'eLib SOAP: “@message”', array('@message' => $e->getMessage(), WATCHDOG_ERROR));
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