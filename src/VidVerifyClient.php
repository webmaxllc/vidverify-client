<?php

namespace Webmax\VidVerifyClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\ClientInterface;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializerBuilder;
use Webmax\VidVerifyClient\Model\VidVerifyResponse;

/**
 * VidVerify API client
 *
 * @author Frank Bardon Jr. <frankbardon@gmail.com>
 * @todo Fully unit test.
 */
class VidVerifyClient
{
    /**
     * Guzzle HTTP client
     *
     * @var GuzzleClient
     */
    private $client;

    /**
     * Are we in debug mode?
     *
     * @var boolean
     */
    private $debug;

    /**
     * JMS Serializer
     *
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * JMS Serializer cache directory
     *
     * @var string
     */
    private $serializerCacheDirectory;

    /**
     * VidVerify sponsor
     *
     * @var string
     */
    private $sponsor;

    /**
     * VidVerify sponsor key
     *
     * @var string
     */
    private $sponsorKey;

    /**
     * VidVerify client key
     *
     * @var string
     */
    private $clientKey;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param string $endpoint
     * @param string $sponsor
     * @param string $sponsorKey
     * @param string $clientKey
     * @param array $config
     */
    public function __construct(
        $apiKey,
        $endpoint,
        $sponsor,
        $sponsorKey,
        $clientKey,
        $config = array(),
        $serializerCacheDirectory = null,
        $debug = false
    ) {
        $config = array_merge_recursive($this->getDefaultConfig($apiKey, $endpoint), $config);

        if ($debug) {
            $config['debug'] = true;
        }

        $this->sponsor = $sponsor;
        $this->sponsorKey = $sponsorKey;
        $this->clientKey = $clientKey;
        $this->debug = $debug;
        $this->serializerCacheDirectory = $serializerCacheDirectory ?: sys_get_temp_dir();
        $this->client = new GuzzleClient($config);
    }

    /**
     * Send a VidVerify command packet
     *
     * @param CommandPacket $cp
     * @return VidVerifyResponse
     */
    public function sendCommandPacket(CommandPacket $cp)
    {
        $response = $this->client->request('POST', 'job', array(
            'json' => $cp
        ));

        $serializer = $this->getSerializer();

        return $serializer->deserialize($response->getBody(), 'Webmax\VidVerifyClient\Model\VidVerifyResponse', 'json');
    }

    /**
     * Get base Guzzle client
     *
     * @return ClientInterface
     */
    public function getGuzzleClient()
    {
        return $this->client;
    }

    /**
     * Get or create JMS serializer
     *
     * @return SerializerInterface
     */
    public function getSerializer()
    {
        if (null === $this->serializer) {
            $serializer = SerializerBuilder::create()
                ->addMetadataDir(realpath(__DIR__.'/../metadata'), 'Webmax\\VidVerifyClient\\Model')
                ->setDebug($this->debug);

            // Only cache when not debugging.
            if (!$this->debug) {
                $serializer->setCacheDir($this->serializerCacheDirectory);
            }

            $this->serializer = $serializer->build();
        }

        return $this->serializer;
    }

    /**
     * Get default client configuration
     *
     * @param string $apiKey
     * @param string $endpoint
     * @return array
     */
    protected function getDefaultConfig($apiKey, $endpoint)
    {
        return array(
            'base_uri' => sprintf('https://%s.vidverify.com/', $endpoint),
            'connect_timeout' => 3,
            'timeout' => 5,
            'headers' => array(
                'Content-Type' => 'application/json',
                'x-api-key' => $apiKey,
            )
        );
    }
}
