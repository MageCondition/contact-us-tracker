<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Store\Model\StoreManagerInterface;

class Store extends AbstractSource
{
    public function __construct(protected StoreManagerInterface $storeManager)
    {
    }

    /**
     * Get all stores
     */
    public function getAllOptions(): array
    {
        if ($this->_options) {
            return $this->_options;
        }

        $this->_options = $this->toOptionArray();
        return $this->_options;
    }

    /**
     * To option array
     */
    public function toOptionArray(): array
    {
        $options = [];

        foreach ($this->storeManager->getStores() as $store) {
            $options[] = ['label' => $store->getName(), 'value' => $store->getId()];
        }

        return $options;
    }
}
