<?php

namespace Test\Items;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Items\GetItem;

class GetItemTest extends TestCase
{
    public function testGetASingleItem()
    {
        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [ 'Content-Type' => 'application/xml' ],
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <ns2:ItemResponses xmlns:ns2="http://walmart.com/">
            <ns2:ItemResponse>
                <ns2:mart>WALMART_US</ns2:mart>
                <ns2:sku>08F8DYUHDSJBSHW4R</ns2:sku>
                <ns2:wpid>2342TWFEFGR4T</ns2:wpid>
                <ns2:upc>12415246356</ns2:upc>
                <ns2:gtin>135246354764</ns2:gtin>
                <ns2:productName>Seagate 8TB </ns2:productName>
                <ns2:productType>Hard Drives</ns2:productType>
                <ns2:price>
                    <ns2:currency>USD</ns2:currency>
                    <ns2:amount>23.95</ns2:amount>
                </ns2:price>
                <ns2:publishedStatus>PUBLISHED</ns2:publishedStatus>
            </ns2:ItemResponse>
            <ns2:totalItems>1</ns2:totalItems>
        </ns2:ItemResponses>'));

        $getItem = new GetItem($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $xml = $getItem->sendRequest('eyJraWQiOiJkZDk2MDZiNC0w', '123456NM');

        $this->assertNotEmpty($xml);
    } // End public function testSuccessfulGetItemApiRequest
} // End class GetItemTest
