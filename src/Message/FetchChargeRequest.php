<?php

namespace Omnipay\Omise\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class FetchChargeRequest extends AbstractRequest
{

    public function getEndpoint()
    {
        return $this->endpoint.'/charges/'.$this->getTransactionReference();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionReference');

        return array();
    }
}