<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model\ResourceModel\Feedback;

use MageCondition\ContactUsTracker\Model\Feedback;
use MageCondition\ContactUsTracker\Model\ResourceModel\Feedback as FeedbackResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Init model and resource model for collection
     */
    protected function _construct(): void
    {
        $this->_init(Feedback::class, FeedbackResource::class);
    }
}
