<?php

namespace Omnipay\Omise\Message;

class VoidRequest extends RefundRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data['void'] = true;

        return $data;
    }
}