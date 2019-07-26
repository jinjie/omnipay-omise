<?php

namespace Omnipay\Omise\Message;

use Omnipay\Tests\TestCase;

class CreateCardRequestTest extends TestCase
{
    /**
     * @var CreateCardRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new CreateCardRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setCustomerReference('cust_test_5fvso4s8fo3tluea6lb');
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api.omise.co/customers/cust_test_5fvso4s8fo3tluea6lb', $this->request->getEndpoint());
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     */
    public function testCustomerReferenceIsRequired()
    {
        $this->request->setCustomerReference(null);
        $this->request->getData();
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     */
    public function testCardReferenceIsRequired()
    {
        $this->request->getData();
    }

    public function testDataWithCardReference()
    {
        $this->request->setCard(null);
        $this->request->setCardReference('xyz');
        $data = $this->request->getData();
        $this->assertSame('xyz', $data['card']);
    }
}