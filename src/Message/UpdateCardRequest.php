<?php

namespace Omnipay\Omise\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;

class UpdateCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return $this->endpoint.'/customers/'.$this->getCustomerReference().
            '/cards/'.$this->getCardReference();
    }

    public function getHttpMethod()
    {
        return 'PATCH';
    }

    /**
     * @return array|mixed
     * @throws InvalidCreditCardException
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('cardReference');
        $this->validate('customerReference');

        if ($this->getCard()) {
            return $this->getCardData();
        } else {
            return array();
        }
    }

    protected function getCardData()
    {
        $data = array();
        $card = $this->getCard();
        if (!empty($card)) {
            if ($card->getExpiryMonth()) {
                $data['expiration_month'] = $card->getExpiryMonth();
            }
            if ($card->getExpiryYear()) {
                $data['expiration_year'] = $card->getExpiryYear();
            }
            if ($card->getName()) {
                $data['name'] = $card->getName();
            }
            if ($card->getCity()) {
                $data['city'] = $card->getCity();
            }
            if ($card->getPostcode()) {
                $data['postal_code'] = $card->getPostcode();
            }
        }
        return $data;
    }
}