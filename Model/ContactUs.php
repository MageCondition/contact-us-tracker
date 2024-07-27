<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model;

use MageCondition\ContactUsTracker\Model\ResourceModel\ContactUs as ContactUsResource;
use Magento\Framework\Model\AbstractModel;

class ContactUs extends AbstractModel
{
    /**
     * Initialize model
     */
    protected function _construct(): void
    {
        $this->_init(ContactUsResource::class);
    }
}
