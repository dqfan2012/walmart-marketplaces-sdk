<?php

namespace Test\Feeds;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Feeds\AllFeedStatuses;

class AllFeedStatusesTest extends TestCase
{
    public function testSuccessfullySentAllFeedStatusesApiRequest()
    {
        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [ 'Content-Type' => 'application/xml' ],
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <ns2:list xmlns:ns2="http://walmart.com/">
          <ns2:totalResults>1</ns2:totalResults>
          <ns2:offset>0</ns2:offset>
          <ns2:limit>50</ns2:limit>
          <ns2:results>
            <ns2:feed>
              <ns2:feedId>12234EGGT564YTEGFA@AQMBAQA</ns2:feedId>
              <ns2:feedSource>MARKETPLACE_PARTNER</ns2:feedSource>
              <ns2:feedType>item</ns2:feedType>
              <ns2:partnerId>1413254255</ns2:partnerId>
              <ns2:itemsReceived>1</ns2:itemsReceived>
              <ns2:itemsSucceeded>1</ns2:itemsSucceeded>
              <ns2:itemsFailed>0</ns2:itemsFailed>
              <ns2:itemsProcessing>0</ns2:itemsProcessing>
              <ns2:feedStatus>PROCESSED</ns2:feedStatus>
              <ns2:feedDate>2018-07-20T21:56:12.605Z</ns2:feedDate>
              <ns2:batchId>HP_REQUEST_BATCH</ns2:batchId>
              <ns2:modifiedDtm>2018-07-20T21:56:17.948Z</ns2:modifiedDtm>
              <ns2:fileName>ItemFeed99_ParadiseCounty_paperback.xml</ns2:fileName>
              <ns2:itemDataErrorCount>0</ns2:itemDataErrorCount>
              <ns2:itemSystemErrorCount>0</ns2:itemSystemErrorCount>
              <ns2:itemTimeoutErrorCount>0</ns2:itemTimeoutErrorCount>
              <ns2:channelType>WM_TEST</ns2:channelType>
            </ns2:feed>
          </ns2:results>
        </ns2:list>'));

        $allFeedStatuses = new AllFeedStatuses($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $xmlStr = $allFeedStatuses->sendRequest('eyJraWQiOiJkZDk2MDZiNC0w', 'Macnk3nsd38hgtn12');

        // Create a SimpleXMLElement Object
        $xmlObject = \simplexml_load_string($xmlStr);

        // An XML object could be created
        $this->assertNotFalse($xmlObject);

        // That XML Object is an instance of the SimpleXMLElement class
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlObject);
    } // End public function testSuccessfullySentAllFeedStatusesApiRequest
} // End class AllFeedStatusesTest
