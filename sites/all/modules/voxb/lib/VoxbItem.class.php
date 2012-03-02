<?php

/**
 * @file
 */

error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

require_once(drupal_get_path('module', 'ding_voxb') . '/lib/VoxbBase.class.php');
require_once(drupal_get_path('module', 'ding_voxb') . '/lib/VoxbReviewsController.class.php');
require_once(drupal_get_path('module', 'ding_voxb') . '/lib/VoxbTags.class.php');

/**
 * This is the main VoxB-client class.
 * It has a method to fetch item information from VoxB server.
 * And parse it from simplexml object to different kind of VoxB-objects: tags, ratings, reviews
 */
class VoxbItem extends VoxbBase {
  private $tags;
  private $reviews;

  private $reviewHandlers;
  private $objectIdentifierValue;
  private $objectIdentifierType;
  private $rating = 0;
  private $ratingCount = 0;

  public function __construct() {
    parent::getInstance();

    /**
     * Review is a review too.
     */
    $this->tags = new VoxbTags();
    $this->reviews = new VoxbReviewsController($this->reviewHandlers);
  }

  /**
   * Fetching item from voxb server by ISBN.
   *
   * @param string $isbn
   */
  public function fetchByISBN($isbn) {
    $data = array(
      'fetchData' => array(
        'objectIdentifierValue' => $isbn,
        'objectIdentifierType' => 'ISBN'
      ),
      'output' => array('contentType' => 'all')
    );
    $o = $this->call('fetchData', $data);
    if ($o->totalItemData) {
      $this->fetchData($o->totalItemData);
    }

    if ($o->error) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Fetching item from voxb server by faust number.
   *
   * @param string $faustNum
   */
  public function fetchByFaust($faustNum) {
    $data = array(
      'fetchData' => array(
        'objectIdentifierValue' => $faustNum,
        'objectIdentifierType' => 'FAUST'
      ),
      'output' => array('contentType' => 'all')
    );
    $this->reviews = new VoxbReviewsController($this->reviewHandlers);

    $o = $this->call('fetchData', $data);
    if ($o->totalItemData) {
      $this->fetchData($o->totalItemData);
    }

    if ($o->error) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Add review handlers to factory
   *
   * @param string $name
   * @param object $object
   */
  public function addReviewHandler($name, $object) {
    $this->reviewHandlers[$name] = $object;
  }

  /**
   * Method is fetching data from a VoxB object.
   */
  private function fetchData($o) {
    $this->objectIdentifierValue = $o->fetchData->objectIdentifierValue;
    $this->objectIdentifierType = $o->fetchData->objectIdentifierType;

    // Fetch Tags
    $this->tags = new VoxbTags();
    $this->tags->fetch($o->summaryTags);

    // Fetch Reviews
    $this->reviews = new VoxbReviewsController($this->reviewHandlers);
    $this->reviews->fetch($o->userItems);

    // Fetch Rating
    $this->rating = $o->totalRatings->averageRating;
    $this->ratingCount = $o->totalRatings->totalNumberOfRaters;
  }

  /**
   * Getter function.
   */
  public function getTags() {
    return $this->tags;
  }

  /**
   * Getter function.
   */
  public function getReviews($type) {
    return $this->reviews->get($type);
  }

  /**
   * Getter function.
   */
  public function getRating() {
    return $this->rating;
  }

  /**
   * Getter function, returns amount of users rated this item.
   */
  public function getRatingCount() {
    return $this->ratingCount;
  }

  /**
   * Rate the item.
   *
   * @param string $faustNum
   * @param integer $rating (0 to 100)
   * @param integer $userId
   */
  public function rateItem($faustNum, $rating, $userId) {
    $response = $this->call('createMyData', array(
      'userId' => $userId,
      'item' => array(
        'rating' => $rating
      ),
      'object' => array(
        'objectIdentifierValue' => $faustNum,
        'objectIdentifierType' => 'FAUST'
      )
    ));

    if (!$response || $response->error) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * This method is updating user item rating
   *
   * @param $record_id
   * @param $rating
   */
  public function updateRateItem($record_id, $rating) {
    $response = $this->call('updateMyData', array(
      'voxbIdentifier' => $record_id,
      'item' => array(
        'rating' => $rating,
      ),
    ));

    if (!$response || $response->error) {
      return FALSE;
    }

    return TRUE;
  }
}
