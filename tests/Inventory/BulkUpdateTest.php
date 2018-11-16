<?php

namespace Test\Inventory;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Inventory\BulkUpdate;

class BulkUpdateTest extends TestCase
{
    public function testSuccesfullyRanBulkUpdate()
    {
        $file = __DIR__ . '/files/upload.xml';

        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [ 'Content-Type' => 'application/xml' ],
        '<?xml version="1.0" encoding="UTF-8"?>
        <FeedAcknowledgement xmlns:ns2="http://walmart.com/">
          <feedId>62a05384-37cd-4afc-95ca-c68241e6902a</feedId>
        </FeedAcknowledgement>'));

        $bulkUpdate = new BulkUpdate($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $xml = $bulkUpdate->sendRequest('eyJraWQiOiJkZDk2MDZiNC0w', $file);

        $this->assertNotEmpty($xml);
    } // End public function testSuccesfullyRanBulkUpdate
} // End class BulkUpdateTest
