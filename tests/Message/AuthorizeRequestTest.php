<?php

namespace Omnipay\Omise\Message;

use Omnipay\Tests\TestCase;

class AuthorizeRequestTest extends TestCase
{
    /**
     * @var AuthorizeRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => '10.00',
                'currency' => 'SGD',
                'card' => $this->getValidCard(),
                'description' => 'Order test',
                'metadata' => array(
                    'foo' => 'bar',
                ),
                'platformFeeFixed' => 10,
                'platformFeePercentage' => 1.0,
            )
        );
    }

    public function testGetData()
    {
        $expiresAt = new \DateTime();
        $this->request->setExpiresAt($expiresAt);

        $data = $this->request->getData();
        $this->assertSame(1000, $data['amount']);
        $this->assertSame('sgd', $data['currency']);
        $this->assertSame('Order test', $data['description']);
        $this->assertSame('false', $data['capture']);
        $this->assertSame(array('foo' => 'bar'), $data['metadata']);
        $this->assertSame($expiresAt->format('c'), $data['expires_at']);
        $this->assertSame(10, $data['platform_fee']['fixed']);
        $this->assertSame(1.0, $data['platform_fee']['percentage']);
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The source parameter is required
     */
    public function testCardCustomerSourceConditionallyRequired()
    {
        $this->request->setCard(null);
        $this->request->getData();
    }

    public function testDataWithCard()
    {
        $card = $this->getValidCard();
        $this->request->setCard($card);
        $data = $this->request->getData();
        $this->assertSame($card['number'], $data['source']['number']);
    }

    public function testDataWithCustomerReference()
    {
        $this->request->setCard(null);
        $this->request->setCustomerReference('abc');
        $data = $this->request->getData();
        $this->assertSame('abc', $data['customer']);
    }

    public function testDataWithCardReference()
    {
        $this->request->setCardReference('token_test_balabala');
        $data = $this->request->getData();
        $this->assertSame('token_test_balabala', $data['card']);
    }

    public function testDataWithCustomerReferenceAndCardReference()
    {
        $this->request->setCardReference('token_test_balabala');
        $this->request->setCustomerReference('abc');
        $data = $this->request->getData();
        $this->assertSame('abc', $data['customer']);
        $this->assertSame('token_test_balabala', $data['card']);
    }

    public function testDataWithSource()
    {
        $this->request->setReturnUrl('https://www.omise.co/example_return_uri');
        $this->request->setSource('src_test_59wbyjr7jz44d8nzcd6');

        $data = $this->request->getData();
        $this->assertSame('src_test_59wbyjr7jz44d8nzcd6', $data['source']);
        $this->assertSame('https://www.omise.co/example_return_uri', $data['return_uri']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('chrg_test_5fvso4gk1mapqrty0cb', $response->getTransactionReference());
        $this->assertSame('card_test_5fvso3c9stiq4z4lh0g', $response->getCardReference());
        $this->assertSame('5d4e1475-118f-4a93-b747-aab627435a7d', $response->getRequestId());
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
    }
}