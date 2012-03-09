<?php

/**
 * @file
 *
 * Base VoxB-client class.
 * Singleton class, supports connection to VoxB server.
 */

class VoxbBase {

  /**
   * Singleton template attribure.
   *
   * @var object
   */
  public static $instance = NULL;

  /**
   * SOAP client attribute.
   *
   * @var object
   */
  public static $soapClient = NULL;

  /**
   * Constructor initialize $this->soapClient attribute.
   */
  private function __construct() {
    $options = array(
      'soap_version' => SOAP_1_2,
      'exceptions' => TRUE,
      'trace' => 1,
      'cache_wsdl' => WSDL_CACHE_NONE
    );

    try {
      VoxbBase::$soapClient = new SoapClient(variable_get('voxb_service_url', ''), $options);
    } catch (Exception $e) {
      VoxbBase::$soapClient = NULL;
    }
  }

  /**
   * Singleton feature.
   */
  public static function getInstance() {
    if (VoxbBase::$instance == NULL) {
      VoxbBase::$instance = new VoxbBase();
    }
    return VoxbBase::$instance;
  }

  /**
   * Use this method to call VoxB server methods.
   *
   * @param string $method
   * @param array $data
   */
  public function call($method, $data) {
    if (VoxbBase::$soapClient == NULL) {
      return FALSE;
    }

    try {
      $response = VoxbBase::$soapClient->$method($data);
    } catch (Exception $e) {
      return FALSE;
    }
    return $response;
  }

  /**
   * Check if the service is available
   */
  public function isServiceAvailable() {
    return (VoxbBase::$soapClient == NULL ? FALSE : TRUE);
  }
}
