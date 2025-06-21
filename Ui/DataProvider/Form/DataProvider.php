<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Ui\DataProvider\Form;

use MageCondition\ContactUsTracker\Model\FeedbackRepository;
use MageCondition\ContactUsTracker\Model\ResourceModel\ContactUs\Collection;
use MageCondition\ContactUsTracker\Model\ResourceModel\ContactUs\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    protected array $loadedData = [];

    /** @var Collection */
    protected $collection; // phpcs:ignore

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        protected StoreManagerInterface $storeManager,
        protected FeedbackRepository $feedbackRepository,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     */
    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $storeMapping = $this->getStoreMapping();
        foreach ($items as $item) {
            $data = $item->getData();

            $pretty = '';
            if (!empty($data['additional_info'])) {
                $decoded = json_decode((string) $data['additional_info'], true) ?: [];
                $prettyLines = [];

                foreach ($decoded as $key => $value) {
                    $prettyLines[] = $key . ': ' . (is_scalar($value) ? $value : json_encode($value));
                }

                $pretty = implode("\n", $prettyLines);
            }

            if ($pretty) {
                $data['additional_info_pretty'] = $pretty;
            }

            $data['store_name'] = $storeMapping[$data['store_id']] ?? $data['store_id'];

            $replies = $this->feedbackRepository->getByContactId((int) $item->getId());
            $data['replies'] = !empty($replies);

            if ($replies) {
                $prettyReplies = [];
                foreach ($replies as $reply) {
                    $prettyReplies[] = sprintf(
                        '[%s] %s: %s',
                        $reply->getCreatedAt(),
                        $reply->getAdminUserName(),
                        $reply->getReplyText()
                    );
                }
                $data['replies_pretty'] = implode("\n", $prettyReplies);
            }

            $this->loadedData[$item->getId()] = $data;
        }

        return $this->loadedData;
    }

    /**
     * Get store mapping
     */
    protected function getStoreMapping(): array
    {
        $storeMapping = [];

        foreach ($this->storeManager->getStores() as $store) {
            $storeMapping[$store->getId()] = $store->getName();
        }

        return $storeMapping;
    }
}
