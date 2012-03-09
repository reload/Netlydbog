<?php

/**
 * @file
 */

require_once(dirname(__FILE__) . '/VoxbTest.php');

class VoxbReviewTest extends VoxbTest {

  public function setUp() {
    parent::setUp();

    parent::createUser(5);
  }

  public function tearDown() {
    parent::tearDown();
  }

  public function testAddReview() {
    $profile = new VoxbProfile();
    $profile->setUserId($this->users[4]);
    $profile->fetchMyData();

    $item = new VoxbItem();
    $item->addReviewHandler('review', new VoxbReviews());
    $item->fetchByFaust('111111111');

    $reviews = $item->getReviews('review');
    $reviewsNumBefore = $reviews->getCount();

    $profile = new VoxbProfile();
    $profile->setUserId($this->users[4]);
    $profile->fetchMyData();

    $review = new VoxbReviewRecord();
    $review->create('111111111', 'TestReview', $profile);

    $item = new VoxbItem();
    $item->addReviewHandler('review', new VoxbReviews());
    $item->fetchByFaust('111111111');
    $reviews = $item->getReviews('review');
    $reviewsNumAfter = $item->getReviews('review')->getCount();

    $this->assertEquals($reviewsNumAfter, ($reviewsNumBefore + 1));
  }

  public function testUpdateReview() {
    $profile = new VoxbProfile();
    $profile->setUserId($this->users[0]);
    $profile->fetchMyData();

    $item = new VoxbItem();
    $item->addReviewHandler('review', new VoxbReviews());
    $item->fetchByFaust('111111111');

    $reviews = $item->getReviews('review');
    $reviewsNumBefore = $reviews->getCount();

    // Attempt to update a review
    $review = new VoxbReviewRecord();
    $r = $review->create('111111111', 'SecondReview', $profile);

    $this->assertTrue($r);

    $item = new VoxbItem();
    $item->addReviewHandler('review', new VoxbReviews());
    $item->fetchByFaust('111111111');

    $reviews = $item->getReviews('review');
    $reviewsNumAfter = $reviews->getCount();
    $reviews = $reviews->toArray();

    $this->assertEquals($reviewsNumBefore, $reviewsNumAfter);

    $this->assertEquals($reviews[0]['text'], 'SecondReview');
  }
}
