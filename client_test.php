<?php

/**
 * SOAP TEST
 *
 */


/*
$client = new SoapClient("http://libraryservices.qa.pubhub.dk/getlibraryuserorderlist.asmx?wsdl", array(
  'trace' => true,
  'cache_wsdl' => WSDL_CACHE_NONE,
));

print_r($client->__getFunctions());

$product_list = $client->GetLibraryUserOrderList(array(
  'retailerid'      => '810',
  'retailerkeycode' => md5('der89pot'),
  // 'countrycode'     => 'DK',
  // 'fromdate'        => '2009-01-01',
  'cardnumber' => '15673',
  'languagecode'    => 'da',
));

print_r($product_list);
*/

//http://libraryservices.pubhub.dk/getproductlist.asmx

$list = new SoapClient("http://libraryservices.qa.pubhub.dk/getproductlist.asmx?wsdl", array(
  'trace' => true,
  'cache_wsdl' => WSDL_CACHE_NONE,
));

$tmp = $list->GetProductList(array(
  'retailerid' => '810',
  'retailerkeycode' => md5('der89pot'),
  'countrycode' => 'DK',
  'fromdate' => '2009-01-01',
  'languagecode' => 'da',
));

//echo $tmp->GetProductListResult->any;

$debug = new SoapClient("http://libraryservices.qa.pubhub.dk/createloan.asmx?wsdl", array(
  'trace' => true,
  'cache_wsdl' => WSDL_CACHE_NONE,
));

print_r($debug->__getFunctions());
/*
   'retailerid'      => '810',
  'retailerkeycode' => md5('der89pot'),
  'countrycode'     => 'DK',
  'fromdate'        => '2009-01-01',
  'cardnumber' => '15673',
  'languagecode'    => 'da',

      <retailerid>string</retailerid>
      <retailerkeycode>string</retailerkeycode>
      <ebookid>string</ebookid>
      <format>string</format>
      <mobipocketid>string</mobipocketid>
      <cardnumber>string</cardnumber>
      <pincode>string</pincode>
      <languagecode>string</languagecode>
 */
$loan = $debug->CreateLoan(array(
  'retailerid'      => '810',
  'retailerkeycode' => md5('der89pot'),
  'ebookid' => '9788702071849',
  'format' => '71',
  'mobipocketid' => '',
  'cardnumber' => '3208100083',
  'pincode' => '12345',
  'languagecode'    => 'da',
));

print_r($loan);
