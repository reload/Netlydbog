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
#      'connection_timeout' => 10
	  );

    // support for proxy settings via admin
    // @see: http://domain.tld/admin/settings/elib
    $proxy = variable_get('elib_proxy_settings', '');
    if (preg_match('/^[a-z0-9\.-]+:[0-9]{2,5}$/i', $proxy)) {
      list($host, $port) = explode(':', $proxy);
      $this->sc_params['proxy_host'] = $host;
      $this->sc_params['proxy_port'] = $port;
    }
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
		//if(strlen($cardno)>9){
		  $this->elibUsr = new loaner($cardno,$pin);	
		//}
	}
	
	public function validateUser() {
		if(is_a($this->elibUsr, 'loaner')) {
			$params = $this->elibUsr->loginParams();
			$response = $this->soapCall($this->base_url.'validatelibraryuser.asmx?WSDL','ValidateLibraryUser',$params);
			
			$xml = simplexml_load_string($response->ValidateLibraryUserResult->any);

			// if user credentials are valid 101 is returned in xml according to eLib
			if($xml->status->code == '101'){
				return true;
			}
			else {
        watchdog('elib', 'eLib login: “@message” (code: @code)', array(
          '@message' => (string) $xml->status->message,
          '@code' => (string) $xml->status->code
        ), WATCHDOG_ERROR);
				return false;
			}
		}
		else{
			throw new Exception('No user instance: '.__FUNCTION__);
		}
  }

  /**
   *
   * @param int $limit number of records to fetch
   * @param int $fromdate from date as unix timestamp
   * @return simpleml object
   */
  public function getNewBooks($limit = 100, $fromdate = null) {

    if (is_null($fromdate)) {
      $fromdate = strtotime('-1 month');
    }

  	$params['top'] = $limit;
  	$params['listtype'] = 1;
  	#$params['fromdate'] = date('Y-m-d',time()-22592000);
  	$params['fromdate'] = date('Y-m-d', $fromdate);

  	$response = $this->soapCall($this->base_url.'getlibrarylist.asmx?WSDL','GetNewBooks',$params);
  	
  	$xml = array();
  	if(simplexml_load_string($response->GetNewBooksResult->any)){
  		$xml = simplexml_load_string($response->GetNewBooksResult->any);
  	}
  	
  	return $xml;
  	
  }

  public function getPopularBooks($count = 7){
    $params['top'] = $count;
    $params['listtype'] = 1;
    $params['fromdate'] = date('Y-m-d', strtotime('-1 day'));
    $params['todate'] = date('Y-m-d');
    
    $response = $this->soapCall($this->base_url.'getlibrarylist.asmx?WSDL','GetTopList',$params);
    
    $xml = array();
    if(simplexml_load_string($response->GetTopListResult->any)){
      $xml = simplexml_load_string($response->GetTopListResult->any);
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
        if(!in_array(trim($line->identifier),$ids)){
          $ids[] = trim($line->identifier);
        }
      }
  	}
  	
  //	var_dump($ids);
  	
  	return array_slice(array_reverse($ids),0,5);
  }

  public function makeLoan($ebookid){
  	if(is_a($this->elibUsr,'loaner')){
	  	
	  	$params = $this->elibUsr->loginParams();
	  	$params['ebookid'] = $ebookid;
	  	$params['format'] = '230';
	  	$params['mobipocketid'] = '';

		//watchdog('elib', 'eLib SOAP (makeLoan): “@message”', array('@message' => var_export($params,true), WATCHDOG_DEBUG));
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
	  	return $xml;
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
    if(preg_match('/^[0-9]+(X)?$/', $isbn)){
      $response = $this->soapCall($this->base_url.'getproduct.asmx?WSDL','GetProduct',array('ebookid' => $isbn));
      return simplexml_load_string($response->GetProductResult->any);
    }
    else{
    	throw new Exception('the isbn need to be int: "'.$isbn.'" send');
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
      $response = $request->$func($params);
      // var_dump($request->__getLastRequest());
       watchdog('elib', 'eLib soapCall: “@message” [REQUEST]: @request [RESPONSE]: @response', 
                array('@message' => $func . " (" . $wsdl . ")", 
                      '@request' => var_export($request->__getLastRequest(), true), 
                      '@response' => var_export($request->__getLastResponse(), true)
                      , WATCHDOG_DEBUG));
      return $response;
    }
    catch(Exception $e){
      elib_display_error($e);
    	//print ('Der er sket en fejl i forbindelsen med eLib: '. $e->getMessage());
     	//watchdog('elib', 'eLib SOAP: “@message”', array('@message' => $e->getMessage(), WATCHDOG_ERROR));
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
    return $this->cardno;
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
