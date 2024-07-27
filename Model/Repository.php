<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model;

use Exception;
use MageCondition\ContactUsTracker\Model\ResourceModel\ContactUs as ContactUsResource;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class Repository
{
    public function __construct(
        protected ContactUsFactory $contactUsFactory,
        protected ContactUsResource $contactUsResource
    ) {
    }

    /**
     * Save contact us entity
     *
     * @throws CouldNotSaveException
     */
    public function save(ContactUs $contactUs): void
    {
        try {
            $this->contactUsResource->save($contactUs);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Contact us save error'), $e);
        }
    }

    /**
     * Get contact us entity by id
     *
     * @throws NoSuchEntityException
     */
    public function get(int $entityId): ContactUs
    {
        $contactUs = $this->createEmptyModel();
        $this->contactUsResource->load($contactUs, $entityId);
        if (!$contactUs->getId()) {
            throw new NoSuchEntityException(__('Contact us entity with id "%1" does not exist.', $entityId));
        }
        return $contactUs;
    }

    /**
     * Create empty model
     */
    public function createEmptyModel(): ContactUs
    {
        return $this->contactUsFactory->create();
    }

    /**
     * Delete contact us entity
     *
     * @throws Exception
     */
    public function delete(ContactUs $contactUs): void
    {
        $this->contactUsResource->delete($contactUs);
    }

    /**
     * Delete contact us entity by id
     *
     * @throws NoSuchEntityException
     * @throws Exception
     */
    public function deleteById(int $entityId): void
    {
        $this->delete($this->get($entityId));
    }
}
