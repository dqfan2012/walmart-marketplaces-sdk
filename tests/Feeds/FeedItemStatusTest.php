<?php

namespace Test\Feeds;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Feeds\FeedItemStatus;

class FeedItemStatusTest extends TestCase
{
    public function testSuccessfullySentFeedItemStatusApiRequest()
    {
        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [ 'Content-Type' => 'application/xml' ],
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <ns2:PartnerFeedResponse xmlns:ns2="http://walmart.com/">
          <ns2:feedId>640787F441ASSFF1C4FB7BB749E20C0A3</ns2:feedId>
          <ns2:feedStatus>PROCESSED</ns2:feedStatus>
          <ns2:feedSubmissionDate>2018-07-20T21:56:12.605Z</ns2:feedSubmissionDate>
          <ns2:itemsReceived>1</ns2:itemsReceived>
          <ns2:itemsSucceeded>1</ns2:itemsSucceeded>
          <ns2:itemsFailed>0</ns2:itemsFailed>
          <ns2:itemsProcessing>0</ns2:itemsProcessing>
          <ns2:offset>0</ns2:offset>
          <ns2:limit>50</ns2:limit>
          <ns2:itemDetails>
            <ns2:itemIngestionStatus>
              <ns2:martId>0</ns2:martId>
              <ns2:sku>234325346-8fbf-4fa0-a70c-2424rfwefq</ns2:sku>
              <ns2:wpid>7K69FC732QRRE5KTFS</ns2:wpid>
              <ns2:index>0</ns2:index>
              <ns2:itemid>24234</ns2:itemid>
              <ns2:productIdentifiers>
                <ns2:productIdentifier>
                  <ns2:productIdType>GTIN</ns2:productIdType>
                  <ns2:productId>086756453</ns2:productId>
                </ns2:productIdentifier>
                <ns2:productIdentifier>
                  <ns2:productIdType>ISBN</ns2:productIdType>
                  <ns2:productId>13432543634</ns2:productId>
                </ns2:productIdentifier>
              </ns2:productIdentifiers>
              <ns2:ingestionStatus>SUCCESS</ns2:ingestionStatus>
            </ns2:itemIngestionStatus>
          </ns2:itemDetails>
        </ns2:PartnerFeedResponse>'));

        $feedItemStatus = new FeedItemStatus($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $xml = $feedItemStatus->sendRequest('eyJraWQiOiJkZDk2MDZiNC0w', 'Macnk@3nsd38hgtn12');

        $this->assertNotEmpty($xml);
    } // End public function testSuccessfullySentFeedStatusApiRequest
} // End class FeedStatusTest
