<?php

namespace Omnipay\Omise\Message;

use Omnipay\Tests\TestCase;

class CreateCustomerRequestTest extends TestCase
{
    /**
     * @var CreateCustomerRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new CreateCustomerRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api.omise.co/customers', $this->request->getEndpoint());
    }

    public function testGetData()
    {
        $this->request->setDescription('desc');
        $this->request->setEmail('test@test.com');
        $this->request->setMetadata('{"answer": 42}');
        $data = $this->request->getData();

        $this->assertSame('desc', $data['description']);
        $this->assertSame('test@test.com', $data['email']);
        $this->assertSame('{"answer": 42}', $data['metadata']);
    }
}