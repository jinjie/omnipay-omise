<?php

namespace Omnipay\Omise\Message;

use Omnipay\Tests\TestCase;

class FetchChargeRequestTest extends TestCase
{
    /**
     * @var FetchChargeRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new FetchChargeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setTransactionReference('chrg_test_5g5idked981unmzjzhl');
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api.omise.co/charges/chrg_test_5g5idked981unmzjzhl', $this->request->getEndpoint());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('FetchChargeSuccess.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('chrg_test_5h0xs9ogsnmqe7y59hi', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('FetchChargeFailure.txt');
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCardReference());
        $this->assertSame('charge chrg_test_5h0xs9ogsnmqe7y59hi was not found', $response->getMessage());
    }
}