<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ContactUs extends AbstractDb
{
    /** @var array[] */
    protected $_serializableFields = ['additional_info' => [null, []]]; // phpcs:ignore

    /**
     * Init main table
     */
    protected function _construct(): void
    {
        $this->_init('contact_us_tracker', 'entity_id');
    }

    /**
     * Mass delete
     *
     * @throws LocalizedException
     */
    public function massDelete(array $ids): void
    {
        $this->getConnection()->delete($this->getMainTable(), ['entity_id IN (?)' => $ids]);
    }
}
