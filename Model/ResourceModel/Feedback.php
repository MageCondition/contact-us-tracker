<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Feedback extends AbstractDb
{
    /**
     * Init main table
     */
    protected function _construct(): void
    {
        $this->_init('contact_us_feedback', 'entity_id');
    }
}
