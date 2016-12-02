<?php

class VidVerifyTests extends ClientTestCase
{
    public function testAllActivitiesSuccessResponse()
    {
        $client = $this->createClient($this->getHandledConfig('all-activity'));
    }

    public function testAllActivitiesSuccessResponseIsObject()
    {
        $client = $this->createClient($this->getHandledConfig('all-activity'));

    }

    private function getHandledConfig($which)
    {
        switch ($which) {
            case 'all-activity':
                $response = $this->mockResponse(200, array(), $this->getData('all-activity'));
                break;
            case 'borrower-activity':
                $response = $this->mockResponse(200, array(), $this->getData('borrower-activity'));
                break;
            case 'invoice-report':
                $response = $this->mockResponse(200, array(), $this->getData('invoice-report'));
                break;
            default:
                throw new \InvalidArgumentException('Unable to create listing handler configuration');
        }

        return array(
            'handler' => $this->mockHandler($response)
        );
    }
}
