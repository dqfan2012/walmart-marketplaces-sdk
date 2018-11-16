<?php

namespace Test\Items;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Items\RetireItem;

class RetireItemTest extends TestCase
{
    public function testSuccessfullyRetiredItem()
    {
        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [ 'Content-Type' => 'application/xml' ],
        '<?xml version="1.0" encoding="UTF-8"?>
        <ItemRetireResponse xmlns:ns2="http://walmart.com/">
        <sku>34931712</sku>
        <message>Thank you. Your item has been submitted for retirement from Walmart Catalog. Please note that it can take up to 48 hours for items to be retired from our catalog.</message>
        </ItemRetireResponse>'));

        $retireItem = new RetireItem($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $xml = $retireItem->sendRequest('eyJraWQiOiJkZDk2MDZiNC0w', '123456NM');

        $this->assertNotEmpty($xml);
    } // End public function testSuccessfullyRetiredItem
} // End class RetireItemTest
