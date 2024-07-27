<?php

declare(strict_types=1);

namespace MageCondition\ContactUsTracker\Model\ResourceModel\Grid;

use MageCondition\ContactUsTracker\Model\ResourceModel\ContactUs;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

class Collection extends SearchResult
{
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        string $mainTable = 'contact_us_tracker',
        string $resourceModel = ContactUs::class,
        ?string $connectionName = null,
        ?string $identifierName = null,
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $mainTable,
            $resourceModel,
            $identifierName,
            $connectionName
        );
    }

    /**
     * Truncate comment line if length is more than 75 characters
     */
    public function getItems(): array
    {
        $items = parent::getItems();

        foreach ($items as $item) {
            if (strlen($item->getComment()) > 75) {
                $item->setComment(substr($item->getComment(), 0, 75) . '...');
            }
        }

        return $items;
    }
}
