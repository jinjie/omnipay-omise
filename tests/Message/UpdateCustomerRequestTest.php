<?php

namespace Omnipay\Omise\Message;

use Omnipay\Tests\TestCase;

class UpdateCustomerRequestTest extends TestCase
{
    /**
     * @var UpdateCustomerRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new UpdateCustomerRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setCustomerReference('cust_test_5g0221fe8iwtayocgja');
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api.omise.co/customers/cust_test_5g0221fe8iwtayocgja', $this->request->getEndpoint());
    }

    public function testHttpMethod()
    {
        $this->assertSame('PATCH', $this->request->getHttpMethod());
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     */
    public function testCustomerReferenceIsRequired()
    {
        $this->request->setCustomerReference(null);
        $this->request->getData();
    }

    public function testGetDate()
    {
        $this->request->setDescription('desc');
        $this->request->setEmail('test@test.com');
        $this->request->setMetadata('{"answer": 42}');
        $this->request->setDefaultCard('card_test_bala');
        $data = $this->request->getData();

        $this->assertSame('desc', $data['description']);
        $this->assertSame('test@test.com', $data['email']);
        $this->assertSame('{"answer": 42}', $data['metadata']);
        $this->assertSame('card_test_bala', $data['default_card']);
    }

}