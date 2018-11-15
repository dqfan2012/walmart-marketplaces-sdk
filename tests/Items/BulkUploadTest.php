<?php

namespace Test\Items;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Items\BulkUpload;

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

        $xml = $bulkUpload->UploadFile($file, 'eyJraWQiOiJkZDk2MDZiNC0w');

        $this->assertNotEmpty($xml);
    }
} // End class BulkUpload
