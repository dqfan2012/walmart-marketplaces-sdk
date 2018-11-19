<?php

namespace WalmartMarketplaceApi\Test\Items;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Prices\UpdatePrice;

class UpdatePriceTest extends TestCase
{
    public function testSuccessfullyUpdatedARegularPrice()
    {
        $file = __DIR__ . '/files/regular_price.xml';

        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [ 'Content-Type' => 'application/xml' ],
        '<?xml version="1.0" encoding="UTF-8"?>
        <ns2:ItemPriceResponse xmlns:ns2="http://walmart.com/">
          <ns2:mart>WALMART_US</ns2:mart>
          <ns2:sku>VEX1437_9507240_9507247</ns2:sku>
          <ns2:currency>USD</ns2:currency>
          <ns2:amount>10.000</ns2:amount>
          <ns2:message>Thank you. Your price has been updated. Please allow up to five minutes for this change to be reflected on the site.</ns2:message>
        </ns2:ItemPriceResponse>'));

        $updatePrice = new UpdatePrice($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $xmlStr = $updatePrice->sendRequest('eyJraWQiOiJkZDk2MDZiNC0w', $file);

        // Create a SimpleXMLElement Object
        $xmlObject = \simplexml_load_string($xmlStr);

        // An XML object could be created
        $this->assertNotFalse($xmlObject);

        // That XML Object is an instance of the SimpleXMLElement class
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlObject);
    } // End public function testSuccessfullyUpdatedARegularPrice


    public function testSuccessfullyUpdatedAPromotionalPrice()
    {
        $file = __DIR__ . '/files/promotional_price.xml';

        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [ 'Content-Type' => 'application/xml' ],
        '<?xml version="1.0" encoding="UTF-8"?>
        <ns2:ItemPriceResponse xmlns:ns2="http://walmart.com/">
          <ns2:mart>WALMART_US</ns2:mart>
          <ns2:sku>VEX1437_9507240_9507247</ns2:sku>
          <ns2:currency>USD</ns2:currency>
          <ns2:amount>10.000</ns2:amount>
          <ns2:message>Thank you. Your price has been updated. Please allow up to five minutes for this change to be reflected on the site.</ns2:message>
        </ns2:ItemPriceResponse>'));

        $updatePrice = new UpdatePrice($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $xmlStr = $updatePrice->sendRequest('eyJraWQiOiJkZDk2MDZiNC0w', $file);

        // Create a SimpleXMLElement Object
        $xmlObject = \simplexml_load_string($xmlStr);

        // An XML object could be created
        $this->assertNotFalse($xmlObject);

        // That XML Object is an instance of the SimpleXMLElement class
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlObject);
    } // End public function testSuccessfullyUpdatedAPromotionalPrice
} // End class UpdatePriceTest
