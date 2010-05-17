<?php

/**
 * SOAP TEST
 *
 * getproduct.asmx
 * getproductlist.asmx
 * validatelibraryuser.asmx
 */


$client = new SoapClient("http://localhost:8080/webservices/getlibraryuserorderlist.asmx?wsdl", array(
  'trace' => true, 
  'cache_wsdl' => WSDL_CACHE_NONE, 
  'proxy_host' => 'localhost', 
  'proxy_port' => 8080,
));

// print_r($client->__getFunctions());

$product_list = $client->GetLibraryUserOrderList(array(
  'retailerid'      => '810',
  'retailerkeycode' => md5('der89pot'),
  // 'countrycode'     => 'DK',
  // 'fromdate'        => '2009-01-01',
  'cardnumber' => '15673',
  'languagecode'    => 'da',
));

print_r($product_list);
// $xmlobj = simplexml_load_string($product_list->GetCategoryListResult->any);
// print_r($xmlobj);
// foreach ($xmlobj->data->categoryitem as $x) {
//   // print_r($x);
//   $title = iconv('utf-8', 'iso-8859-1', $x->name[0]);
//   echo $title . '<br />';
// }
