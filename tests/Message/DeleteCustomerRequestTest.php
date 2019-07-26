<?php

namespace Omnipay\Omise\Message;

use Omnipay\Tests\TestCase;

class DeleteCustomerRequestTest extends TestCase
{
    /**
     * @var DeleteCustomerRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new DeleteCustomerRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setCustomerReference('cust_test_5g0221fe8iwtayocgja');
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api.omise.co/customers/cust_test_5g0221fe8iwtayocgja', $this->request->getEndpoint());
    }

    public function testHttpMethod()
    {
        $this->assertSame('DELETE', $this->request->getHttpMethod());
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     */
    public function testCustomerReferenceIsRequired()
    {
        $this->request->setCustomerReference(null);
        $this->request->getData();
    }

    public function testGetData()
    {
        $this->assertNull($this->request->getData());
    }
}