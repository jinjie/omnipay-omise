<?php

namespace Omnipay\Omise\Message;

class CreateCustomerRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return $this->endpoint.'/customers';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
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

        return $data;
    }
}