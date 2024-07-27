<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Plugin\Model;

use Exception;
use MageCondition\ContactUsTracker\Model\Config;
use MageCondition\ContactUsTracker\Model\Repository;
use Magento\Contact\Model\Mail as Subject;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Mail
{
    public function __construct(
        protected Repository $contactUsRepository,
        protected StoreManagerInterface $storeManager,
        protected Config $config,
        protected LoggerInterface $logger
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
        $data = $variables['data'];
        $additionalInfo = [];

        $contactUs->setName($data['name'] ?? '');
        unset($data['name']);

        $contactUs->setEmail($data['email'] ?? '');
        unset($data['email']);

        $contactUs->setPhone($data['telephone'] ?? '');
        unset($data['telephone']);

        $contactUs->setComment($data['comment'] ?? '');
        unset($data['comment']);

        foreach ($data as $key => $value) {
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
}
