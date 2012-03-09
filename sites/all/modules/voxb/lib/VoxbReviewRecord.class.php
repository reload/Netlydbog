<?php

/**
 * @file
 *
 * VoxbReviewRecord single review class.
 * This object is storing reviews attributes.
 */
class VoxbReviewRecord extends VoxbBase{

  private $title;
  private $text;
  private $authorVoxbId;
  private $authorName;
  private $voxbId;

  /**
   * Constructor as parameter gets a part of SimpleXml object received from the server.
   *
   * @param $voxbObj
   */
  public function __construct($voxbObj = NULL) {
    parent::getInstance();
    if ($voxbObj) {
      $this->title = (string)$voxbObj->review->reviewTitle;
      $this->text = (string)$voxbObj->review->reviewData;
      $this->authorVoxbId = (int)$voxbObj->userId;
      $this->authorName = (string)$voxbObj->userAlias->aliasName;
      $this->voxbId = intval($voxbObj->voxbIdentifier);
    }
  }

  /**
   * Getter function.
   *
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Getter function.
   *
   * @return string
   */
  public function getText() {
    return $this->text;
  }

  /**
   * Getter function.
   *
   * @return string
   */
  public function getAuthorVoxbId() {
    return $this->authorVoxbId;
  }

  /**
   * Getter function.
   *
   * @return string
   */
  public function getAuthorName() {
    return $this->authorName;
  }

  /**
   * Getter function.
   *
   * @return string
   */
  public function getVobId() {
    return $this->voxbId;
  }

  /**
   * Returns class attributes as array.
   * This method is user in Ajax responders.
   *
   * @return array
   */
  public function toArray() {
    return array(
      'title' => $this->title,
      'text' => $this->text,
      'authorId' => $this->authorVoxbId,
      'authorName' => $this->authorName,
      'voxbId' => $this->voxbId
    );
  }

  /**
   * @todo Finish this method as soon as this VoxB functionality will be tested.
   *
   * Delete review record from VoxB.
   *
   * @return boolean
   */
  public function delete() {
    $response = $this->call('deleteMyData', array(
      'voxbIdentifier' => $this->voxbId
    ));

    if ($response->error) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Create review.
   *
   * @param string $faustNum
   * @param string $review
   * @param integer $userId
   */
  public function create($faustNum, $review, $profile) {
    // check if user has already reviewed this item
    $data = $profile->getVoxbUserData($faustNum);
    if ($data && ($data['review']['title'] == 'review' || !$data['review']['title'])) {
      // Update reviews
      return $this->update($data['voxbIdentifier'], $review);
    }

    $response = $this->call('createMyData', array(
      'userId' => $profile->getUserId(),
      'item' => array(
        'review' => array(
          'reviewTitle' => 'review',
          'reviewData' => $review,
          'reviewType' => 'TXT'
        )
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
   * Update review method
   *
   * @param integer $voxbId
   * @param string $review
   */
  private function update($voxbId, $review) {
    $response = $this->call('updateMyData', array(
      'voxbIdentifier' => $voxbId,
      'item' => array(
        'review' => array(
          'reviewTitle' => 'review',
          'reviewData' => $review,
          'reviewType' => 'TXT'
        )
      )
    ));

    if (!$response || $response->error) {
      return FALSE;
    }
    return TRUE;
  }
}
