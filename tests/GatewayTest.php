<?php

namespace Omnipay\Omise;

use Omnipay\Tests\GatewayTestCase;

/**
 * @property Gateway gateway
 */
class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testAuthorize()
    {
        $request = $this->gateway->authorize(array('amount' => '10.00'));
        $this->assertInstanceOf(Message\AuthorizeRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testCapture()
    {
        $request = $this->gateway->capture(array('amount' => '10.00'));
        $this->assertInstanceOf(Message\CaptureRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));
        $this->assertInstanceOf(Message\PurchaseRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testRefund()
    {
        $request = $this->gateway->refund(array('amount' => '10.00'));
        $this->assertInstanceOf(Message\RefundRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testVoid()
    {
        $request = $this->gateway->void();
        $this->assertInstanceOf(Message\VoidRequest::class, $request);
    }

    public function testUpdateCard()
    {
        $request = $this->gateway->updateCard(array('cardReference' => 'cus_1MZSEtqSghKx99'));
        $this->assertInstanceOf(Message\UpdateCardRequest::class, $request);
        $this->assertSame('cus_1MZSEtqSghKx99', $request->getCardReference());
    }
    public function testDeleteCard()
    {
        $request = $this->gateway->deleteCard(array('cardReference' => 'cus_1MZSEtqSghKx99'));
        $this->assertInstanceOf(Message\DeleteCardRequest::class, $request);
        $this->assertSame('cus_1MZSEtqSghKx99', $request->getCardReference());
    }
}