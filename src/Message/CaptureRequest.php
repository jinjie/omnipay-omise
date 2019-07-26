<?php

namespace Omnipay\Omise\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class CaptureRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return $this->endpoint.'/charges/'.$this->getTransactionReference().'/capture';
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

        $data = array();
        if ($amount = $this->getAmountInteger()) {
            $data['amount'] = $amount;
        }
        return $data;
    }
}