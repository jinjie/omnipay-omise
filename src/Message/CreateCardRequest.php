<?php

namespace Omnipay\Omise\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class CreateCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return $this->endpoint.'/customers/'.$this->getCustomerReference();
    }

    /**
     * @return array|mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('cardReference', 'customerReference');

        $data = array();

        $data['card'] = $this->getCardReference();

        return $data;
    }
}