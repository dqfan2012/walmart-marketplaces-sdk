<?php

namespace Test\Feeds;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Feeds\BulkUpload;

class BulkUploadTest extends TestCase
{
    public function testSuccessfulBulkUpload()
    {
        $file = __DIR__ . '/files/upload.xml';

        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [ 'Content-Type' => 'application/xml' ],
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <FeedAcknowledgement xmlns:ns2="http://walmart.com/">
          <feedId>E9C04D1FFD99479FBC1341D56DD5F930@AQMB_wA</feedId>
        </FeedAcknowledgement>'));

        $bulkUpload = new BulkUpload($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $xmlStr = $bulkUpload->sendRequest('eyJraWQiOiJkZDk2MDZiNC0w', $file);

        // Create a SimpleXMLElement Object
        $xmlObject = \simplexml_load_string($xmlStr);

        // An XML object could be created
        $this->assertNotFalse($xmlObject);

        // That XML Object is an instance of the SimpleXMLElement class
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlObject);
    } // End public function testSuccessfulBulkUpload
} // End class BulkUploadTest
