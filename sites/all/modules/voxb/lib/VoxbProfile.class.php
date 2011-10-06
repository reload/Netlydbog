<?php

require_once(VOXB_PATH . '/lib/VoxbBase.class.php');

/**
 * @file
 *
 * User profile class.
 * A VoxB user may have different amount of profiles (min 1).
 */
class VoxbProfile extends VoxbBase {
  private $userId;
  private $aliasName;
  private $profileLink;
  private $cpr;

  /**
   * VoxB itemIds on which user has already actred (tagged/reviewed/rated).
   */
  private $actedItems = array();

  /**
   * You may create VoxbProfile object without parametes
   * if you for example would like to create a new user/profile.
   *
   * @param object $xml
   * @param string $crp
   */
  public function __construct($xml = NULL, $cpr = NULL) {
    if ($xml) {
      $this->cpr = $cpr;
      $this->fetch($xml);
    }
    parent::getInstance();
  }

  /**
   * Fetching data fro simpleXml object to class attributes
   *
   * @param object $xml
   */
  private function fetch($xml) {
    $this->userId = intval($xml->userId);
    $this->aliasName = (string)$xml->userAlias->aliasName;
    $this->profileLInk = (string)$xml->userAlias->profileLink;
  }

  /**
   * Getter function.
   */
  public function getUserId() {
    return $this->userId;
  }

  /**
   * Getter function.
   */
  public function getAliasName() {
    return $this->aliasName;
  }

  /**
   * Getter function.
   */
  public function getProfileLink() {
    return $this->getProfileLink;
  }

  /**
   * Setter function.
   */
  public function setAliasName($x) {
    $this->aliasName = $x;
  }

  /**
   * Setter function.
   */
  public function setProfileLink($x) {
    $this->profileLink = $x;
  }

  /**
   * Setter function.
   */
  public function setCpr($x) {
    $this->cpr = $x;
  }

  /**
   * Create user method creates not only an user.
   * If a user with such credentials (CPR, identity provider and institution name)
   * already exist in VoxB database only a new profile will be added to his account.
   * This business logic is on the VoxB server side.
   *
   * @param string $identityProvider
   * @param string $institutionName
   */
  public function createUser($identityProvider, $institutionName) {
    $response = $this->call('createUser', array(
      'userAlias' => array(
        'aliasName' => $this->aliasName,
        'profileLink' => $this->profileLink
      ),
      'authenticationFingerprint' => array(
        'userIdentifierValue' => $this->cpr,
        'userIdentifierType' => 'CPR',
        'identityProvider' => $identityProvider,
        'institutionName' => $institutionName
      )
    ));

    if (isset($response->userId)) {
      $this->userId = $response->userId;
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Check if this user can add reviews.
   * If the user already posted a review/tag/rating
   * he is not able to perform this action.
   *
   * @param integer $faustNum
   * @return boolean
   */
  public function isAbleToReview($faustNum) {
    return $this->isServiceAvailable();
  }

  /**
   * Check if this user can add tags.
   * If the user already posted a review/tag/rating
   * he is not able to perform this action.
   *
   * @param integer $faustNum
   * @return boolean
   */
  public function isAbleToTag($faustNum) {
    // user is always able to add more tags
    return $this->isServiceAvailable();
  }

  /**
   * Check if this user can rate.
   * If the user already posted a review/tag/rating
   * he is not able to perform this action.
   *
   * @param integer $faustNum
   * @return boolean
   */
  public function isAbleToRate($faustNum) {
    return $this->isServiceAvailable();
  }

  /**
   * Retuns an array which shows user actions on items
   * array(
   *  array(
   *    voxbIdentifier:integer
   *    tags:array
   *    review:array
   *    rating:integer
   *  )
   * )
   *
   * @return array
   */
  private function getActedItems() {
    if (empty($this->actedItems)) {
      $response = $this->call('fetchMyData', array('userId' => $this->userId));
      if (!$response) return array();

      if (!is_array($response->result))
        $response->result = array($response->result);

      foreach ($response->result as $v) {
        if ($v->object && $v->object->objectIdentifierType == 'FAUST') {
          $this->actedItems[$v->object->objectIdentifierValue] = array(
            'voxbIdentifier' => $v->voxbIdentifier,
            'tags' => @$v->item->tags ? (is_array($v->item->tags->tag) ? $v->item->tags->tag : array($v->item->tags->tag)) : array(),
            'review' => array(
              'title' => @$v->item->review->reviewTitle,
              'data' => @$v->item->review->reviewData
            ),
            'rating' => @$v->item->rating
          );
        }
      }
    }
    return $this->actedItems;
  }

  /**
   * Update array of acted items
   *
   */
  public function updateActedItems() {
    $this->actedItems = array();
    $this->getActedItems();
  }

  /**
   * Seter function.
   *
   * @param integer $x
   */
  public function setUserId($x) {
    $this->userId = $x;
  }

  /**
   * This is a public method
   * to be used after successfull authntication to store VoxbIdentifiers in the SESSION
   */
  public function fetchMyData() {
    if (!$this->userId) return FALSE;
    $this->getActedItems();
    return TRUE;
  }

  /**
   * This method return VoxB user data on specified item
   * Or NULL if he didn't act on it yet
   * @param $faustNumber
   * @return array
   */
  public function getVoxbUserData($faustNumber) {
    $actedItems = $this->getActedItems();

    return $actedItems[$faustNumber];
  }

}
