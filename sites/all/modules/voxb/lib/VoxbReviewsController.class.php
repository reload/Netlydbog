<?php

require_once(VOXB_PATH . '/lib/VoxbBase.class.php');

/**
 * @file
 *
 * VoxbReviews class.
 * This class handles reviews colection.
 */
class VoxbReviewsController {
  private $handlers;

  public function __construct($handlers) {
    $this->handlers = $handlers;
  }

  public function fetch($sXml) {
    foreach ($this->handlers as $handler) {
      $handler->fetch($sXml);
    }
  }

  public function get($type) {
    if ($this->handlers[$type]) {
      return $this->handlers[$type];
    }
  }
}
