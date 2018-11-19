<?php

namespace Test\Inventory;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Inventory\GetInventory;

class GetInventoryTest extends TestCase
{
    public function testGetInventoryForASingleItem()
    {
        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [ 'Content-Type' => 'application/xml' ],
        '<?xml version="1.0" encoding="UTF-8"?>
        <inventory xmlns:ns2="http://walmart.com/">
          <sku>create-gmp1a</sku>
          <quantity>
            <unit>EACH</unit>
            <amount>23</amount>
          </quantity>
          <fulfillmentLagTime>4</fulfillmentLagTime>
        </inventory>'));

        $getInventory = new GetInventory($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $xmlStr = $getInventory->sendRequest('eyJraWQiOiJkZDk2MDZiNC0w', '123456NM');

        // Create a SimpleXMLElement Object
        $xmlObject = \simplexml_load_string($xmlStr);

        // An XML object could be created
        $this->assertNotFalse($xmlObject);

        // That XML Object is an instance of the SimpleXMLElement class
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlObject);
    } // End public function testGetInventoryForASingleItem
} // End class GetInventoryTest
