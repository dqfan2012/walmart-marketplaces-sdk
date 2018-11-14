<?php

namespace Test\Items;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Items\BulkUpload;

class BulkUploadTest extends TestCase
{
    protected $accessToken;

    public function setUp()
    {
        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [],'{
            "access_token": "eyJraWQiOiJkZDk2MDZiNC0wNjVkLTQ5YmQtYTc5OC1kNWFmNzJlM2M5YTAiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiZGlyIn0..-XYkTSspnM3OzBP_.L1HjV3G4mLB81_B2FkkkXMZ3ySQeUZb0Yp0omxEsjttTgmRPYUUVFzevuOYae2wjDTUW__MwKCbwjQzmgrxgyz2-A5U1aIVdkfE4vSGHJ4NwSIC_yn2kxXlz9LZ9-_oz7aBEJijqGQieuhAzzZ8dt-Mu6YmfvqC9iqRWausRE4g29SI4T25BcV9UduU5h5IFBy88AW45Lt3hVaRmjjnq1KU9zCslhvLzdXadSokbGJHyWSgYli-5oKsiDKIm5Iv_aY73MFfiOYYXAePTpKhB8KRvb4FEohHYjZJyZUuOB9r14R7a-eo140I0z1yhhH_5FW4FaWUdc6AWFtjsfAJ2p0r8zLF-uFZ_fGYuOFFdQajiPAT0BQCTEneXUSEH_Lez82U1FVfCPe4Mj17IfdN6cbbPWD60JmaB9uaaVrJ2sRovlm-0p0MP9LYYpCfxyj-hRkebRge4cFkkfGHgcHVYEWdUAD7YKXPPuP_q1dkxFgzH63d1LAckUvg8CGuWwbaREizSUFtfQtwjPHb7sT2P8XoNPWkg-Ej_-tUSzazZDVk4ejp5b4RbltV5dfA9p4pGKO4TRs8mhoSTJWY6f8JVKWamUj0uqti8IzjtMQw5c5yFMwd3m3Q3h1x8TOwtuo8yy3Cws2ZdjkTAn3oQcA0c0_7Jl1G253ews8bFoWPxEh6nxsdeTNgMNY1crK1I.BETgkXDP8wp6bdnGy0UE6g",
            "token_type": "Bearer",
            "expires_in": 900
        }'));

        $bulkUpload = new BulkUpload($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $this->accessToken = $bulkUpload->getAccessToken();
    }

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

        $xml = $bulkUpload->UploadFile($this->accessToken, $file);

        $this->assertNotEmpty($xml);
    }
} // End class BulkUpload
