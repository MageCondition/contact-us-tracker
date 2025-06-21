<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model;

use MageCondition\ContactUsTracker\Model\ResourceModel\Feedback as FeedbackResource;
use Magento\Framework\Model\AbstractModel;

class Feedback extends AbstractModel
{
    /**
     * Initialize model
     */
    protected function _construct(): void
    {
        $this->_init(FeedbackResource::class);
    }
}
