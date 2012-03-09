<?php

/**
 * @file
 *
 * Single tag class.
 */

class VoxbTagRecord extends VoxbBase {
  private $name;
  private $count;

  public function __construct($sXml = NULL) {
    if ($sXml) {
      $this->name = $sXml->tag;
      $this->count = $sXml->tagCount;
    }
    parent::getInstance();
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Returns amount of taggings to this tag.
   *
   * @return integer
   */
  public function getCount() {
    return $this->count;
  }

 /**
  * Create a tag.
  *
  * @param string $faustNum
  * @param string $tag
  * @param integer $userId
  */
  public function create($faustNum, $tag, $profile) {
    // check if user has already added tags to this item
    if ($profile && $data = $profile->getVoxbUserData($faustNum)) {
      // update tags list
      return $this->updateTags($data['voxbIdentifier'], $data['tags'], $tag);
    }
    // create a new tag
    $response = $this->call('createMyData', array(
      'userId' => $profile->getUserId(),
      'item' => array(
        'tags' => array(
          'tag' => $tag
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
   * Convert object to array.
   */
  public function toArray() {
    return array(
      'name' => $this->name,
      'count' => $this->count
    );
  }

/**
 * This method updates tags list
 *
 * @param $voxbId
 * @param $tags - list of existing tags (obly added by one user)
 * @param $tag - new tag
 */
  public function updateTags($voxbId, $tags, $tag) {
    $tags[] = $tag;
    $response = $this->call('updateMyData', array(
      'voxbIdentifier' => $voxbId,
      'item' => array(
        'tags' => array(
          'tag' => $tags
        )
      )
    ));

    if (!$response || $response->error) {
      return FALSE;
    }
    return TRUE;
  }
}
