<?php

namespace Omnipay\Omise;

use Omnipay\Common\AbstractGateway;
use Omnipay\Omise\Message\AuthorizeRequest;
use Omnipay\Omise\Message\CaptureRequest;
use Omnipay\Omise\Message\CompletePurchaseRequest;
use Omnipay\Omise\Message\CreateCardRequest;
use Omnipay\Omise\Message\CreateCustomerRequest;
use Omnipay\Omise\Message\DeleteCardRequest;
use Omnipay\Omise\Message\DeleteCustomerRequest;
use Omnipay\Omise\Message\FetchChargeRequest;
use Omnipay\Omise\Message\PurchaseRequest;
use Omnipay\Omise\Message\RefundRequest;
use Omnipay\Omise\Message\UpdateCardRequest;
use Omnipay\Omise\Message\UpdateCustomerRequest;
use Omnipay\Omise\Message\VoidRequest;

/**
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 */
class Gateway extends AbstractGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     *
     * @return string
     */
    public function getName()
    {
        return 'Omise';
    }

    public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
        );
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function authorize(array $options = array())
    {
        return $this->createRequest(AuthorizeRequest::class, $options);
    }

    public function capture(array $options = array())
    {
        return $this->createRequest(CaptureRequest::class, $options);
    }

    public function purchase(array $options = array())
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function refund(array $options = array())
    {
        return $this->createRequest(RefundRequest::class, $options);
    }

    public function void(array $options = array())
    {
        return $this->createRequest(VoidRequest::class, $options);
    }

    public function fetchCharge(array $options = array())
    {
        return $this->createRequest(FetchChargeRequest::class, $options);
    }

    public function createCard(array $options = array())
    {
        return $this->createRequest(CreateCardRequest::class, $options);
    }

    public function updateCard(array $options = array())
    {
        return $this->createRequest(UpdateCardRequest::class, $options);
    }

    public function deleteCard(array $options = array())
    {
        return $this->createRequest(DeleteCardRequest::class, $options);
    }

    public function completePurchase(array $options = array())
    {
        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }

    public function createCustomer(array $parameters = array())
    {
        return $this->createRequest(CreateCustomerRequest::class, $parameters);
    }

    public function updateCustomer(array $parameters = array())
    {
        return $this->createRequest(UpdateCustomerRequest::class, $parameters);
    }

    public function deleteCustomer(array $parameters = array())
    {
        return $this->createRequest(DeleteCustomerRequest::class, $parameters);
    }
}