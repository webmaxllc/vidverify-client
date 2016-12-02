<?php

use Webmax\VidVerifyClient\Model\BorrowerActivity;

class BorrowerActivityTests extends ClientTestCase
{
    const BORROWER_ID = 3;
    const VIDEO_ID = 7;
    const VIDEO_TITLE = 'Video Title';
    const RAW_VIDEO_LENGTH = '0:1:5';
    const RAW_WATCHED_VIDEO_LENGTH = '0:0:3';
    const TIMES_WATCHED = 2;

    public function testAcceptsBorrowerId ()
    {
        $borrowerActivity = $this->createBorrowerActivity();

        $this->assertSame(self::BORROWER_ID, $borrowerActivity->getBorrowerId());
    }

    public function testAcceptsVideoId()
    {
        $borrowerActivity = $this->createBorrowerActivity();

        $this->assertSame(self::VIDEO_ID, $borrowerActivity->getVideoId());
    }

    public function testAcceptsVideoTitle()
    {
        $borrowerActivity = $this->createBorrowerActivity();

        $this->assertSame(self::VIDEO_TITLE, $borrowerActivity->getVideoTitle());
    }

    public function testAcceptsRawVideoLength()
    {
        $borrowerActivity = $this->createBorrowerActivity();

        $this->assertSame(self::RAW_VIDEO_LENGTH, $borrowerActivity->getRawVideoLength());
    }

    public function testAcceptsRawWatchedVideoLength()
    {
        $borrowerActivity = $this->createBorrowerActivity();

        $this->assertSame(self::RAW_WATCHED_VIDEO_LENGTH, $borrowerActivity->getRawWatchedVideoLength());
    }

    public function testAcceptsTimesWatched()
    {
        $borrowerActivity = $this->createBorrowerActivity();

        $this->assertSame(self::TIMES_WATCHED, $borrowerActivity->getTimesWatched());
    }

    private function createBorrowerActivity()
    {
        $activity = new BorrowerActivity();
        $this->injectPropertyValue($activity, "borrowerId", self::BORROWER_ID);
        $this->injectPropertyValue($activity, "videoId", self::VIDEO_ID);
        $this->injectPropertyValue($activity, "videoTitle", self::VIDEO_TITLE);
        $this->injectPropertyValue($activity, "rawVideoLength", self::RAW_VIDEO_LENGTH);
        $this->injectPropertyValue($activity, "rawWatchedVideoLength", self::RAW_WATCHED_VIDEO_LENGTH);
        $this->injectPropertyValue($activity, "timesWatched", self::TIMES_WATCHED);

        return $activity;
    }
}
