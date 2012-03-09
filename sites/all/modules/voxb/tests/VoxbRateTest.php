<?php

/**
 * @file
 */

require_once(dirname(__FILE__) . '/VoxbTest.php');

class VoxbRateTest extends VoxbTest {

  public function setUp() {
    parent::setUp();

    parent::createUser(5);
  }

  public function  tearDown() {
    parent::tearDown();
  }

  public function testRate() {
    $item = new VoxbItem();
    $item->fetchByFaust('111111111');

    $ratingBefore = $item->getRating();
    $ratingCountBefore = $item->getRatingCount();

    $item->rateItem('111111111', 100, $this->users[4]);

    $item = new VoxbItem();
    $item->fetchByFaust('111111111');

    $ratingAfter = $item->getRating();
    $ratingCountAfter = $item->getRatingCount();

    $this->assertEquals($ratingCountAfter, ($ratingCountBefore + 1));
    $this->assertEquals($ratingAfter, 64);
  }

  public function testRateUpdate() {
    $profile = new VoxbProfile();
    $profile->setUserId($this->users[0]);
    $record_data = $profile->getVoxbUserData('111111111');

    $item = new VoxbItem();
    $item->fetchByFaust('111111111');

    $r = $item->rateItem('111111111', 90, $this->users[0]);

    $this->assertFalse($r);

    $item->updateRateItem($record_data['voxbIdentifier'], 100);

    $ratingAfter = $item->getRating();

    $this->assertEquals($ratingAfter, 55);
  }
}
