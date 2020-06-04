<?php

namespace Omnipay\Omise\Message;

class FetchChargeRequest extends AbstractRequest
{
    /**
     * Get the charge reference.
     *
     * @return string
     */
    public function getChargeReference()
    {
        return $this->getParameter('chargeReference');
    }

    /**
     * Set the charge reference.
     *
     * @param string
     * @return \Omnipay\Omise\Message\FetchChargeRequest
     */
    public function setChargeReference($value)
    {
        return $this->setParameter('chargeReference', $value);
    }

    public function getEndpoint()
    {
        return $this->endpoint.'/charges/'.$this->getChargeReference();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * @inheritDoc
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('chargeReference');
    }
}