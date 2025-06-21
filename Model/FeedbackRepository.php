<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model;

use Exception;
use MageCondition\ContactUsTracker\Model\ResourceModel\Feedback as FeedbackResource;
use MageCondition\ContactUsTracker\Model\ResourceModel\Feedback\CollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;

class FeedbackRepository
{
    public function __construct(
        protected FeedbackFactory $feedbackFactory,
        protected FeedbackResource $resource,
        protected CollectionFactory $collectionFactory
    ) {
    }

    /**
     * Save feedback entity
     *
     * @throws CouldNotSaveException
     */
    public function save(Feedback $feedback): void
    {
        try {
            $this->resource->save($feedback);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Feedback save error'), $e);
        }
    }

    /**
     * Get feedback list by contact id
     */
    public function getByContactId(int $contactId): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('contact_id', $contactId);
        $collection->setOrder('entity_id', 'ASC');

        return $collection->getItems();
    }

    /**
     * Create empty model
     */
    public function create(): Feedback
    {
        return $this->feedbackFactory->create();
    }
}
