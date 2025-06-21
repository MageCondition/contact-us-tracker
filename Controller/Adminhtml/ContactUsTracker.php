<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Controller\Adminhtml;

use MageCondition\ContactUsTracker\Model\ContactUsRepository;
use MageCondition\ContactUsTracker\Model\ResourceModel\ContactUs as ContactUsResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;

abstract class ContactUsTracker extends Action
{
    public function __construct(
        protected PageFactory         $resultPageFactory,
        protected ContactUsRepository $repository,
        protected ContactUsResource   $resource,
        protected LoggerInterface     $logger,
        Context                       $context
    ) {
        parent::__construct($context);
    }

    /**
     * Create result page
     */
    protected function createResultPage(): Page
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MageCondition_ContactUsTracker::contact_us_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Contact Us Tracker'));

        return $resultPage;
    }

    /**
     * Get id from request
     */
    protected function getId(): int
    {
        return (int) $this->getRequest()->getParam('id');
    }

    /**
     * Get grid redirect
     */
    protected function getGridRedirect(): Redirect
    {
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('contact_us/tracker/index');

        return $redirect;
    }

    /**
     * Get view redirect
     */
    protected function getViewRedirect(): Redirect
    {
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath(
            'contact_us/tracker/view',
            ['id' => $this->getId()]
        );

        return $redirect;
    }
}
