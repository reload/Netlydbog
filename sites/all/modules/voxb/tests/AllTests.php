<?php

/**
 * @file
 */

define('VOXB_PATH', dirname(__FILE__) . '/..');

require_once('PHPUnit/Framework.php');
require_once(dirname(__FILE__) . '/VoxbItemTest.php');
require_once(dirname(__FILE__) . '/VoxbTagTest.php');
require_once(dirname(__FILE__) . '/VoxbReviewTest.php');
require_once(dirname(__FILE__) . '/VoxbRateTest.php');

function drupal_get_path($a, $b) {
  return dirname(__FILE__) . '/..';
}

function variable_get($param) {
  switch ($param) {
    case 'voxb_service_url': return 'https://voxb.addi.dk/1.0/xml/voxb.wsdl';
      break;
  }
}

class AllTests {
  public static function suite() {
    $suite = new PHPUnit_Framework_TestSuite('Voxb');
    $suite->addTest(new PHPUnit_Framework_TestSuite('VoxbItemTest'));
    $suite->addTest(new PHPUnit_Framework_TestSuite('VoxbTagTest'));
    $suite->addTest(new PHPUnit_Framework_TestSuite('VoxbReviewTest'));
    $suite->addTest(new PHPUnit_Framework_TestSuite('VoxbRateTest'));

    return $suite;
  }
}
