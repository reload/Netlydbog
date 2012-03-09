<?php

/**
 * @file
 */

require_once(dirname(__FILE__) . '/VoxbTest.php');
require_once(dirname(__FILE__) . '/../lib/VoxbProfile.class.php');

class VoxbTagTest extends VoxbTest {

  public function setUp() {
    parent::setUp();

    parent::createUser(5);
  }

  public function tearDown() {
    parent::tearDown();
  }

  public function testAddTag() {
    $item = new VoxbItem();
    $item->fetchByFaust('111111111');
    $tagsNumBefore = $item->getTags()->getCount();

    $profile = new VoxbProfile();
    $profile->setUserId($this->users[4]);
    $profile->fetchMyData();

    $tag = new VoxbTagRecord();
    $tag->create('111111111', 'testTag', $profile);

    $item->fetchByFaust('111111111');
    $tagsNumAfter = $item->getTags()->getCount();

    $this->assertEquals($tagsNumAfter, ($tagsNumBefore + 1));
  }

  public function testUpdateTag() {
    $obj = VoxbBase::getInstance();
    $profile = new VoxbProfile();
    $profile->setUserId($this->users[0]);
    $profile->fetchMyData();

    // add a new tag (and keep old tags)
    $tag = new VoxbTagRecord();
    $this->assertTrue($tag->create('111111111', 'tag_new', $profile));
    $item = new VoxbItem();
    $item->fetchByFaust('111111111');
    $this->assertEquals($item->getTags()->getCount(), 5);
  }
}
