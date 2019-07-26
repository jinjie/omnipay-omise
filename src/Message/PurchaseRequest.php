<?php

namespace Omnipay\Omise\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AuthorizeRequest
{

    public function getEndpoint()
    {
        return $this->endpoint.'/charges';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     * @throws InvalidRequestException
     * @throws InvalidCreditCardException
     */
    public function getData()
    {
        $data = parent::getData();
        $data['capture'] = 'true';
        return $data;
    }
}