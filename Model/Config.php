<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_ENABLED = 'contact_us/general/enabled';

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
}
