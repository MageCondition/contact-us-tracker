<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Ui\DataProvider\Form;

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
            $storeId = $item->getStoreId();
            $this->loadedData[$item->getId()] = $item->getData();
            $this->loadedData[$item->getId()]['store_name'] = $storeMapping[$storeId] ?? $storeId;
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
