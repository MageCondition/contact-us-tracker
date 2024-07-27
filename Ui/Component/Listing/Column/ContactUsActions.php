<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ContactUsActions extends Column
{
    /**
     * Url path
     */
    private const URL_PATH_EDIT = 'contact_us/tracker/view';
    private const URL_PATH_DELETE = 'contact_us/tracker/delete';

    public function __construct(
        protected UrlInterface $urlBuilder,
        protected Escaper $escape,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $title = $this->escape->escapeHtml($item['name']);
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->urlBuilder->getUrl(
                            self::URL_PATH_EDIT,
                            [
                                'id' => $item['entity_id'],
                            ]
                        ),
                        'label' => __('View'),
                    ],
                ];

                $item[$this->getData('name')]['delete'] = [
                    'href' => $this->urlBuilder->getUrl(
                        self::URL_PATH_DELETE,
                        [
                            'id' => $item['entity_id'],
                        ]
                    ),
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete %1', $title),
                        'message' => __('Are you sure you want to delete this?'),
                    ],
                    'post' => true,
                ];
            }
        }

        return $dataSource;
    }
}
