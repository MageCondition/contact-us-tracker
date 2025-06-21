<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_ENABLED = 'contact_us/general/enabled';
    private const XML_PATH_EMAIL_SENDER = 'contact_us/email/sender';
    private const XML_PATH_EMAIL_TEMPLATE = 'contact_us/email/template';
    private const XML_PATH_EMAIL_COPY_TO = 'contact_us/email/copy_to';
    private const XML_PATH_EMAIL_COPY_METHOD = 'contact_us/email/copy_method';

    public function __construct(protected ScopeConfigInterface $storeConfig)
    {
    }

    /**
     * Check if the module is enabled
     */
    public function isEnabled(): bool
    {
        return $this->storeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get email sender identity
     */
    public function getSender(): string
    {
        return (string) $this->storeConfig->getValue(self::XML_PATH_EMAIL_SENDER, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get email template identifier
     */
    public function getTemplate(): string
    {
        return (string) $this->storeConfig->getValue(self::XML_PATH_EMAIL_TEMPLATE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get copy to addresses
     */
    public function getEmailCopyTo(): string
    {
        return (string) $this->storeConfig->getValue(self::XML_PATH_EMAIL_COPY_TO, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get copy method
     */
    public function getEmailCopyMethod(): string
    {
        return (string) $this->storeConfig->getValue(self::XML_PATH_EMAIL_COPY_METHOD, ScopeInterface::SCOPE_STORE);
    }
}
