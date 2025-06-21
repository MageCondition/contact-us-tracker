<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model\Email;

use Exception;
use MageCondition\ContactUsTracker\Model\Config;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Sender
{
    public function __construct(
        protected TransportBuilder $transportBuilder,
        protected StateInterface $inlineTranslation,
        protected StoreManagerInterface $storeManager,
        protected Config $config,
        protected LoggerInterface $logger
    ) {
    }

    /**
     * Send reply email to customer
     */
    public function send(
        string $customerName,
        string $customerEmail,
        string $replyText,
        string $originalComment,
        string $adminName
    ): void {
        if (!$this->config->isEnabled()) {
            return;
        }

        $this->inlineTranslation->suspend();

        try {
            $storeId = $this->storeManager->getStore()->getId();

            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->config->getTemplate())
                ->setTemplateOptions(['area' => 'frontend', 'store' => $storeId])
                ->setTemplateVars([
                    'customer_name'    => $customerName,
                    'reply_text'       => $replyText,
                    'original_comment' => $originalComment,
                    'store'            => $this->storeManager->getStore(),
                    'admin_name'       => $adminName,
                ])
                ->setFromByScope($this->config->getSender())
                ->addTo($customerEmail);

            $copyTo = $this->config->getEmailCopyTo();
            if ($copyTo) {
                $copyTo = array_map('trim', explode(',', $copyTo));
                if ($this->config->getEmailCopyMethod() === 'bcc') {
                    foreach ($copyTo as $address) {
                        $transport->addBcc($address);
                    }
                } else {
                    foreach ($copyTo as $address) {
                        $transport->addTo($address);
                    }
                }
            }

            $transport = $transport->getTransport();
            $transport->sendMessage();
        } catch (Exception $e) {
            $this->logger->critical($e);
        }

        $this->inlineTranslation->resume();
    }
}
