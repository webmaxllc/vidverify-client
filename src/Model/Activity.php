<?php

namespace Webmax\VidVerifyClient\Model;

use DateTime;
use DateInterval;

class Activity
{
    /**
     * Borrower id
     *
     * @var integer
     */
    private $borrowerId;

    /**
     * Property id
     *
     * @var integer
     */
    private $videoId;

    /**
     * Video title
     *
     * @var string
     */
    private $videoTitle;

    /**
     * Video start time
     *
     * @var DateTime
     */
    private $videoStartTime;

    /**
     * Video length (raw)
     *
     * @var string
     */
    private $rawVideoLength;

    /**
     * Amount of video watched (raw)
     *
     * @var string
     */
    private $rawWatchedVideoLength;


    public function getBorrowerId()
    {
        return $this->borrowerId;
    }

    public function getVideoId()
    {
        return $this->videoId;
    }

    public function getVideoTitle()
    {
        return $this->videoTitle;
    }

    public function getVideoStartTime()
    {
        return $this->videoStartTime;
    }

    public function getRawVideoLength()
    {
        return $this->videoLength;
    }

    public function getVideoLength()
    {
        return $this->convertToInterval($this->rawVideoLength);
    }

    public function getRawWatchedVideoLength()
    {
        return $this->watchedVideoLength;
    }

    public function getWatchedVideoLength()
    {
        return $this->convertToInterval($this->rawWatchedVideoLength);
    }

    private function convertToInterval($string)
    {
        $parts = explode(":", $string, 3);
        $stdString = sprintf("PT%dH%dM%dS", $parts[0], $parts[1], $parts[2]);

        return new DateInterval($stdString);
    }
}
