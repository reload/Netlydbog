<?php

require_once(VOXB_PATH . '/lib/VoxbTagRecord.class.php');

/**
 * @file
 *
 * This class handles tags collection.
 */
class VoxbTags implements Iterator{
  private $items = array();
  private $position;

  public function __construct() {
    $this->position = 0;
  }

  /**
   * Method fetch data from simpleXml object received
   * from the server to an array of VoxbTagRecord objects.
   *
   * @param object $o
   */
  public function fetch($o) {
    if (!is_array($o)) {
      $o = array($o);
    }
    foreach ($o as $v) {
      $this->items[] = new VoxbTagRecord($v);
    }
  }

  /**
   * Iterator interface method.
   */
  public function rewind() {
    $this->position = 0;
  }

  /**
   * Iterator interface method.
   */
  public function current() {
    return $this->items[$this->position];
  }

  /**
   * Iterator interface method.
   */
  public function key() {
    return $this->position;
  }

  /**
   * Iterator interface method.
   */
  public function next() {
    ++$this->position;
  }

  /**
   * Iterator interface method.
   */
  public function valid() {
    return isset($this->items[$this->position]);
  }

  /**
   * Convert object to array
   */
  public function toArray() {
    $ret = array();
    foreach ($this->items as $v) {
      $ret[] = $v->toArray();
    }
    return $ret;
  }

  /**
   * Get amount of tags
   */
  public function getCount() {
    return count($this->items);
  }
}
