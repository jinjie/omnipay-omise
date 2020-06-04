<?php

namespace Omnipay\Omise\Message;

class PurchaseResponse extends Response
{
    public function isSuccessful()
    {
        return isset($this->data['paid']) && $this->data['paid'] === true &&
            isset($this->data['status']) && $this->data['status'] === 'successful';
    }

    public function getTransactionReference()
    {
        if ($this->isSuccessful() && isset($this->data['id'])) {
            return $this->data['id'];
        }
        return parent::getTransactionReference();
    }

    public function isPending()
    {
        return isset($this->data['status']) && $this->data['status'] === 'pending';
    }
}