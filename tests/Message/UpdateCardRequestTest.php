<?php

namespace Omnipay\Omise\Message;

use Omnipay\Tests\TestCase;

class UpdateCardRequestTest extends TestCase
{
    /**
     * @var UpdateCardRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new UpdateCardRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setCustomerReference('cust_test_5g0221fe8iwtayocgja');
        $this->request->setCardReference('card_test_5g021zls9ei5suyryss');
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api.omise.co/customers/cust_test_5g0221fe8iwtayocgja/cards/card_test_5g021zls9ei5suyryss', $this->request->getEndpoint());
    }

    public function testHttpMethod()
    {
        $this->assertSame('PATCH', $this->request->getHttpMethod());
    }

    public function testDataWithCard()
    {
        $card = $this->getValidCard();
        $this->request->setCard($card);
        $data = $this->request->getData();
        $this->assertSame($card['expiryMonth'], $data['expiration_month']);
        $this->assertSame($card['expiryYear'], $data['expiration_year']);
        $this->assertSame($card['firstName']. ' ' . $card['lastName'], $data['name']);
        $this->assertSame($card['billingCity'], $data['city']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('UpdateCardSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('card_test_5g021zls9ei5suyryss', $response->getCardReference());
        $this->assertNull($response->getMessage());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('UpdateCardFailure.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCardReference());
        $this->assertSame('customer cust_test_5g0221fe8iwtayocgja was not found', $response->getMessage());
    }
}