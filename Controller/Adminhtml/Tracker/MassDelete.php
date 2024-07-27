<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Controller\Adminhtml\Tracker;

use Exception;
use MageCondition\ContactUsTracker\Controller\Adminhtml\ContactUsTracker;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;

class MassDelete extends ContactUsTracker implements HttpPostActionInterface
{
    /**
     * Mass delete contact us records
     */
    public function execute(): Redirect
    {
        $ids = $this->getRequest()->getParam('selected');
        if (!empty($ids)) {
            try {
                $this->resource->massDelete($ids);
                $this->messageManager->addSuccessMessage(__('Records have been successfully deleted'));
            } catch (Exception $e) {
                $this->logger->critical($e);
                $this->messageManager->addErrorMessage(__('Something went wrong while deleting the records.'));
            }
        }

        return $this->getGridRedirect();
    }
}
