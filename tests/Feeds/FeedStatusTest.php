<?php

namespace Test\Feeds;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Feeds\FeedStatus;

class FeedStatusTest extends TestCase
{
    public function testSuccessfullySentFeedStatusApiRequest()
    {
        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [ 'Content-Type' => 'application/xml' ],
        '<?xml version="1.0" encoding="UTF-8"?>
        <PartnerFeedResponse xmlns:ns2="http://walmart.com/">
          <feedId>1c349f8f-aec0-411f-8454-ead47d12946f</feedId>
          <feedStatus>PROCESSED</feedStatus>
          <ingestionErrors />
          <itemsReceived>11</itemsReceived>
          <itemsSucceeded>11</itemsSucceeded>
          <itemsFailed>0</itemsFailed>
          <itemsProcessing>0</itemsProcessing>
          <offset>0</offset>
          <limit>0</limit>
          <itemDetails>
            <itemIngestionStatus>
              <martId>0</martId>
              <sku>sku1</sku>
              <index>8</index>
              <ingestionStatus>SUCCESS</ingestionStatus>
              <ingestionErrors />
            </itemIngestionStatus>
            <itemIngestionStatus>
              <martId>0</martId>
              <sku>sku2</sku>
              <index>6</index>
              <ingestionStatus>SUCCESS</ingestionStatus>
              <ingestionErrors />
            </itemIngestionStatus>
            <itemIngestionStatus>
              <martId>0</martId>
              <sku>sku3</sku>
              <index>9</index>
              <ingestionStatus>SUCCESS</ingestionStatus>
              <ingestionErrors />
            </itemIngestionStatus>
          </itemDetails>
        </PartnerFeedResponse>'));

        $feedStatus = new FeedStatus($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $xmlStr = $feedStatus->sendRequest('eyJraWQiOiJkZDk2MDZiNC0w', 'Macnk3nsd38hgtn12');

        // Create a SimpleXMLElement Object
        $xmlObject = \simplexml_load_string($xmlStr);

        // An XML object could be created
        $this->assertNotFalse($xmlObject);

        // That XML Object is an instance of the SimpleXMLElement class
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlObject);
    } // End public function testSuccessfullySentFeedStatusApiRequest
} // End class FeedStatusTest
