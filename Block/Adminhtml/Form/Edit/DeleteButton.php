<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Block\Adminhtml\Form\Edit;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton implements ButtonProviderInterface
{
    public function __construct(
        protected RequestInterface $request,
        protected UrlInterface $urlBuilder
    ) {
    }

    /**
     * Get button data
     */
    public function getButtonData(): array
    {
        $id = (int) $this->request->getParam('id');

        return [
            'label' => __('Delete'),
            'class' => 'delete',
            'on_click' => 'deleteConfirm(\'' . __(
                'Are you sure you want to do this?'
            ) . '\', \'' . $this->urlBuilder->getUrl('*/*/delete', ['id' => $id]) . '\', {data: {}})',
            'sort_order' => 20,
        ];
    }
}
