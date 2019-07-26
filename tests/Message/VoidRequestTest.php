<?php

namespace Omnipay\Omise\Message;

use Omnipay\Tests\TestCase;

class VoidRequestTest extends TestCase
{
    /**
     * @var VoidRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new VoidRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setTransactionReference('chrg_test_5g5idked981unmzjzhl');
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api.omise.co/charges/chrg_test_5g5idked981unmzjzhl/refunds', $this->request->getEndpoint());
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The amount parameter is required
     */
    public function testAmountIsRequired()
    {
        $this->request->send();
    }

    public function testSendSuccess()
    {
        $this->request->setAmount('10.0');
        $this->setMockHttpResponse('VoidSuccess.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('chrg_test_5fvso4gk1mapqrty0cb', $response->getTransactionReference());
        $this->assertNull($response->getCardReference());
        $this->assertNull($response->getMessage());
    }

    public function testSendError()
    {
        $this->request->setAmount('10.0');
        $this->setMockHttpResponse('VoidFailure.txt');
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCardReference());
        $this->assertSame('chrg_test_5g5idked981unmzjzhl was not found', $response->getMessage());
    }
}