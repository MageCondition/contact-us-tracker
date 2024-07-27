<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Controller\Adminhtml\Tracker;

use MageCondition\ContactUsTracker\Controller\Adminhtml\ContactUsTracker;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Index extends ContactUsTracker implements HttpGetActionInterface
{
    /**
     * Execute action
     */
    public function execute(): Page
    {
        return $this->createResultPage();
    }
}
