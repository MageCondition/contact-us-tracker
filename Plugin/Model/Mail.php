<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Plugin\Model;

use Exception;
use MageCondition\ContactUsTracker\Model\Config;
use MageCondition\ContactUsTracker\Model\ContactUsRepository;
use Magento\Contact\Model\Mail as Subject;
use Magento\Framework\DataObject;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Mail
{
    private const DATA_TO_UNSET = ['name', 'email', 'telephone', 'comment', 'form_key', 'hideit'];

    public function __construct(
        protected ContactUsRepository   $contactUsRepository,
        protected StoreManagerInterface $storeManager,
        protected Config                $config,
        protected LoggerInterface       $logger
    ) {
    }

    /**
     * Creates a contact us entity before sending an email.
     *
     * The contact us entity will be saved in the database even if email sending fails.
     */
    public function beforeSend(Subject $subject, string|array $replyTo, array $variables): array
    {
        if (!$this->config->isEnabled()) {
            return [$replyTo, $variables];
        }

        $contactUs = $this->contactUsRepository->createEmptyModel();
        $data = clone $variables['data'];
        $additionalInfo = [];

        $contactUs->setName($data->getName() ?? '');
        $contactUs->setEmail($data->getEmail() ?? '');
        $contactUs->setPhone($data->getTelephone() ?? '');
        $contactUs->setComment($data->getComment() ?? '');
        $this->unsetExtraData($data);

        foreach ($data->getData() as $key => $value) {
            $additionalInfo[$key] = $value;
        }

        if ($additionalInfo) {
            $contactUs->setAdditionalInfo($additionalInfo);
        }

        try {
            $contactUs->setStoreId($this->storeManager->getStore()->getId());
            $this->contactUsRepository->save($contactUs);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return [$replyTo, $variables];
    }

    /**
     * Unsets extra data from the data object.
     */
    private function unsetExtraData(DataObject $data): void
    {
        $data->unsetData(self::DATA_TO_UNSET);
    }
}
