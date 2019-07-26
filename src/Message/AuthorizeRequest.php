<?php

namespace Omnipay\Omise\Message;

use DateTime;
use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;

class AuthorizeRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return $this->endpoint.'/charges';
    }

    /**
     * Get source param
     *
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParameter('source');
    }

    /**
     * Set source
     *
     * @param string $value
     *
     * @return AbstractRequest provides a fluent interface.
     */
    public function setSource($value)
    {
        return $this->setParameter('source', $value);
    }

    /**
     * Get platform fee fixed
     *
     * @return integer | null
     */
    public function getPlatformFeeFixed()
    {
        return $this->getParameter('platformFeeFixed');
    }

    /**
     * Set platform fee fixed
     *
     * @param integer $value
     *
     * @return AuthorizeRequest
     */
    public function setPlatformFeeFixed($value)
    {
        return $this->setParameter('platformFeeFixed', $value);
    }

    /**
     * Get platform fee percentage
     *
     * @return float | null
     */
    public function getPlatformFeePercentage()
    {
        return $this->getParameter('platformFeePercentage');
    }

    /**
     * Set platform fee percentage
     *
     * @param float $value
     *
     * @return AuthorizeRequest
     */
    public function setPlatformFeePercentage($value)
    {
        return $this->setParameter('platformFeePercentage', $value);
    }

    /**
     * Get expires at in ISO 8601 format
     *
     * @return string|null
     */
    public function getExpiresAt()
    {
        if ($this->getParameter('expiresAt') instanceof DateTime) {
            return $this->getParameter('expiresAt')->format('c');
        }
        return null;
    }

    /**
     * Set expires at
     *
     * @param DateTime $value
     *
     * @return AuthorizeRequest
     */
    public function setExpiresAt($value)
    {
        return $this->setParameter('expiresAt', $value);
    }

    /**
     * Get the raw data array for this message.
     * The format of this varies from gateway to gateway,
     * but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws InvalidRequestException
     * @throws InvalidCreditCardException
     */
    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = array();
        $data['amount'] = $this->getAmountInteger();
        $data['currency'] = strtolower($this->getCurrency());
        $data['description'] = $this->getDescription();
        $data['metadata'] = $this->getMetadata();
        $data['capture'] = 'false';

        if ($this->getPlatFormFeeFixed()) {
            $data['platform_fee']['fixed'] = $this->getPlatFormFeeFixed();
        }

        if ($this->getPlatformFeePercentage()) {
            $data['platform_fee']['percentage'] = $this->getPlatformFeePercentage();
        }

        if ($this->getReturnUrl()) {
            $data['return_uri'] = $this->getReturnUrl();
        }

        if ($this->getClientIp()) {
            $data['ip'] = $this->getClientIp();
        }

        if ($this->getExpiresAt()) {
            $data['expires_at'] = $this->getExpiresAt();
        }

        if ($this->getSource()) {
            $data['source'] = $this->getSource();
        } elseif ($this->getCardReference()) {
            $data['card'] = $this->getCardReference();
            if ($this->getCustomerReference()) {
                $data['customer'] = $this->getCustomerReference();
            }
        } elseif ($this->getCard()) {
            $data['source'] = $this->getCardData();
        } elseif ($this->getCustomerReference()) {
            $data['customer'] = $this->getCustomerReference();
            if ($this->getCardReference()) {
                $data['card'] = $this->getCardReference();
            }
        } else {
            // one of cardReference, token, or card is required
            $this->validate('source');
        }

        return $data;
    }
}