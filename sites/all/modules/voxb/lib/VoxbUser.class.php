<?php

require_once(VOXB_PATH . '/lib/VoxbBase.class.php');
require_once(VOXB_PATH . '/lib/VoxbProfile.class.php');

/**
 * @file
 *
 * VoxbUser used to select user by SSN and fetch his profiles to VoxbProfile class.
 */
class VoxbUser extends VoxbBase {
  private $profiles;

  public function __construct() {
    parent::getInstance();
  }

  /**
   * Fetch user by his SSN(CPR) number
   *
   * @param string $cpr
   * @param string $identityProvider
   * @param string $institutionName
   *
   * @return boolean
   */
  public function getUserBySSN($cpr, $identityProvider, $institutionName) {
    $response = $this->call('fetchUser', array(
        'authenticationFingerprint' => array(
          'userIdentifierValue' => $cpr,
          'userIdentifierType' => 'CPR',
          'identityProvider' => $identityProvider,
          'institutionName' => $institutionName
        )
      )
    );
    if (!$response || isset($response->error)) {
      return FALSE;
    }
    $this->fetchProfiles($cpr, $response->users);
    return TRUE;
  }

  /**
   * Fetch profiles to VoxbProfile class.
   *
   * @param string $cpr
   * @param object $profiles
   */
  private function fetchProfiles($cpr, $profiles) {
    if (!is_array($profiles)) {
      $profiles = array($profiles);
    }
    foreach ($profiles as $v) {
      $this->profiles[] = new VoxbProfile($v, $cpr);
    }
  }

  /**
   * Return profiles array.
   *
   * @return array
   */
  public function getProfiles() {
    return $this->profiles;
  }
}
