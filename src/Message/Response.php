<?php

namespace Omnipay\Omise\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{
    /**
     * @var array
     */
    protected $headers = [];

    public function __construct(RequestInterface $request, $data, $headers=[])
    {
        $this->request = $request;
        $this->data = json_decode($data, true);
        $this->headers = $headers;
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['object'] !== 'error';
    }

    public function getChargeReference()
    {
        if (isset($this->data['object']) && $this->data['object'] == 'charge') {
            return $this->data['id'];
        }

        return null;
    }

    public function getTransactionReference()
    {
        if (isset($this->data['object']) 
            && 'charge' === $this->data['object'] 
            && isset($this->data['transaction'])
        ) {
            return $this->data['transaction'];
        }

        $hasTransactionObjects = ['refund'];
        if (isset($this->data['object']) 
            && in_array($this->data['object'], $hasTransactionObjects, true) 
            && isset($this->data['transaction'])
        ) {
            return $this->data['transaction'];
        }

        return parent::getTransactionReference();
    }

    public function getCardReference()
    {
        if (isset($this->data['object']) && 'customer' === $this->data['object']) {
            if (isset($this->data['default_card']) && !empty($this->data['default_card'])) {
                return $this->data['default_card'];
            }

            return null;
        }

        if (isset($this->data['object']) && 'card' === $this->data['object']) {
            if (!empty($this->data['id'])) {
                return $this->data['id'];
            }
        }

        if (isset($this->data['object']) && 'charge' === $this->data['object']) {
            if (! empty($this->data['card'])) {
                if (! empty($this->data['card']['id'])) {
                    return $this->data['card']['id'];
                }
            }
        }
        return null;
    }

    public function getMessage()
    {
        if (!$this->isSuccessful() 
            && 'error' === $this->data['object'] 
            && isset($this->data['message'])
        ) {
            return $this->data['message'];
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
        return null;
    }

    public function getRequestId()
    {
        if (isset($this->headers['X-Request-Id'])) {
            return $this->headers['X-Request-Id'][0];
        }
        return null;
    }
}