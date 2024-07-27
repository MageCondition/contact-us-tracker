<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model\ResourceModel\ContactUs;

use MageCondition\ContactUsTracker\Model\ContactUs;
use MageCondition\ContactUsTracker\Model\ResourceModel\ContactUs as ContactUsResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Init model and recourse model for collection
     */
    protected function _construct(): void
    {
        $this->_init(ContactUs::class, ContactUsResource::class);
    }
}
