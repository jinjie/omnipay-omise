<?php

namespace Omnipay\Omise\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class UpdateCustomerRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return $this->endpoint.'/customers/'.$this->getCustomerReference();
    }

    public function getHttpMethod()
    {
        return 'PATCH';
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
        $this->validate('customerReference');

        $data = array();

        if ($this->getDescription()) {
            $data['description'] = $this->getDescription();
        }

        if ($this->getEmail()) {
            $data['email'] = $this->getEmail();
        }

        if ($this->getCardReference()) {
            $data['card'] = $this->getCardReference();
        }

        if ($this->getMetadata()) {
            $data['metadata'] = $this->getMetadata();
        }

        if ($this->getDefaultCard()) {
            $data['default_card'] = $this->getDefaultCard();
        }

        return $data;
    }
}