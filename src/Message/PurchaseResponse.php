<?php

namespace Omnipay\Omise\Message;

class PurchaseResponse extends Response
{
    public function isSuccessful()
    {
        return isset($this->data['paid']) && $this->data['paid'] === true &&
            isset($this->data['status']) && $this->data['status'] === 'successful';
    }

    public function isPending()
    {
        return isset($this->data['status']) && $this->data['status'] === 'pending';
    }
}