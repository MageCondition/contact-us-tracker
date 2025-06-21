<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Controller\Adminhtml\Tracker;

use Exception;
use MageCondition\ContactUsTracker\Controller\Adminhtml\ContactUsTracker;
use MageCondition\ContactUsTracker\Model\ContactUsRepository;
use MageCondition\ContactUsTracker\Model\Email\Sender;
use MageCondition\ContactUsTracker\Model\FeedbackRepository;
use MageCondition\ContactUsTracker\Model\ResourceModel\ContactUs;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\View\Result\PageFactory;

class Save extends ContactUsTracker implements HttpPostActionInterface
{
    public function __construct(
        PageFactory $resultPageFactory,
        ContactUsRepository $repository,
        ContactUs $resource,
        \Psr\Log\LoggerInterface $logger,
        protected FeedbackRepository $feedbackRepository,
        protected Sender $emailSender,
        protected AuthSession $authSession,
        Context $context
    ) {
        parent::__construct($resultPageFactory, $repository, $resource, $logger, $context);
    }

    /**
     * Save feedback and send email
     */
    public function execute(): Redirect
    {
        $replyText = (string) $this->getRequest()->getParam('reply_text');
        if ($replyText === '') {
            $this->messageManager->addErrorMessage(__('Reply text cannot be empty.'));
            return $this->getViewRedirect();
        }

        try {
            $contact = $this->repository->get($this->getId());

            $user = $this->authSession->getUser();
            $feedback = $this->feedbackRepository->create();
            $feedback->setContactId($contact->getId());
            $feedback->setAdminUserId((int) $user->getId());
            $feedback->setAdminUserName((string) $user->getName());
            $feedback->setReplyText($replyText);

            $this->feedbackRepository->save($feedback);

            $this->emailSender->send(
                (string) $contact->getName(),
                (string) $contact->getEmail(),
                $replyText,
                (string) $contact->getComment(),
                (string) $user->getName()
            );

            $this->messageManager->addSuccessMessage(__('Reply has been sent.'));
        } catch (Exception $e) {
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage(__('Something went wrong while sending reply.'));
        }

        return $this->getViewRedirect();
    }
}
