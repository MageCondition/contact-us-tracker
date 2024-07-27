<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Controller\Adminhtml\Tracker;

use Exception;
use MageCondition\ContactUsTracker\Controller\Adminhtml\ContactUsTracker;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;

class Delete extends ContactUsTracker implements HttpPostActionInterface
{
    /**
     * Delete contact us record
     */
    public function execute(): Redirect
    {
        try {
            $this->repository->deleteById($this->getId());
            $this->messageManager->addSuccessMessage(__('Record has been successfully deleted'));
            return $this->getGridRedirect();
        } catch (Exception $e) {
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->getViewRedirect();
    }
}
