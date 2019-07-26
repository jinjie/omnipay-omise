<?php


namespace Omnipay\Omise\Message;


use Omnipay\Tests\TestCase;

class DeleteCardRequestTest extends TestCase
{
    /**
     * @var DeleteCardRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new DeleteCardRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setCustomerReference('cust_test_5g0221fe8iwtayocgja');
        $this->request->setCardReference('card_test_5g021zls9ei5suyryss');
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api.omise.co/customers/cust_test_5g0221fe8iwtayocgja/cards/card_test_5g021zls9ei5suyryss', $this->request->getEndpoint());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('DeleteCardSuccess.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertEquals('card_test_5fw57ajzt3tldd9u5i0', $response->getCardReference());
        $this->assertNull($response->getMessage());
    }
    public function testSendFailure()
    {
        $this->setMockHttpResponse('DeleteCardFailure.txt');
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCardReference());
        $this->assertSame('customer cust_test_5g0221fe8iwtayocgja was not found', $response->getMessage());
    }
}