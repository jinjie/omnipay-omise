<?php

namespace Omnipay\Omise\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => '10.00',
                'currency' => 'USD',
                'card' => $this->getValidCard(),
            )
        );
    }

    public function testCaptureIsTrue()
    {
        $data = $this->request->getData();
        $this->assertSame('true', $data['capture']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('chrg_test_5fvso4gk1mapqrty0cb', $response->getTransactionReference());
        $this->assertSame('card_test_5fvso3c9stiq4z4lh0g', $response->getCardReference());
        $this->assertNull($response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCardReference());
        $this->assertSame('token tokn_test_4xs9408a642a1htto8z was not found', $response->getMessage());
        $this->assertSame('not_found', $response->getCode());
    }

    public function testSendErrorWithInvalidSecurityCode()
    {
        $this->setMockHttpResponse('PurchaseFailure_invalid_security_code.txt');
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getCardReference());
        $this->assertSame('invalid_security_code', $response->getCode());
    }
}