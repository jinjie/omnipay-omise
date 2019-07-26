<?php

namespace Omnipay\Omise\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class RefundRequest extends AbstractRequest
{

    public function getEndpoint()
    {
        return $this->endpoint.'/charges/'.$this->getTransactionReference().'/refunds';
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
        $this->validate('transactionReference', 'amount');
        $data = array();
        $data['amount'] = $this->getAmountInteger();

        if ($this->getMetadata()) {
            $data['metadata'] = $this->getMetadata();
        }
        return $data;
    }
}