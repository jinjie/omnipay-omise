<?php

namespace Omnipay\Omise\Message;

class PurchaseResponse extends Response
{
    public function isSuccessful()
    {
        return isset($this->data['paid']) && $this->data['paid'] === true &&
            isset($this->data['status']) && $this->data['status'] === 'successful';
    }

    public function getMessage()
    {
        if (!$this->isSuccessful()
            && 'error' === $this->data['object']
            && isset($this->data['message'])
        ) {
            return $this->data['message'];
        }

        if (!$this->isSuccessful()
            && 'charge' === $this->data['object']
            && isset($this->data['failure_message'])
        ) {
            return $this->data['failure_message'];
        }

        return null;
    }

    public function getCode()
    {
        if (!$this->isSuccessful()
            && 'error' === $this->data['object']
            && isset($this->data['code'])
        ) {
            return $this->data['code'];
        }

        if (!$this->isSuccessful()
            && 'charge' === $this->data['object']
            && isset($this->data['failure_code'])
        ) {
            return $this->data['failure_code'];
        }

        return null;

    }
}