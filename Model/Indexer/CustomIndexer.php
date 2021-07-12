<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Model\Indexer;

use Magento\Framework\Indexer\ActionInterface as IndexerActionInterface;
use Magento\Framework\Mview\ActionInterface as MviewActionInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Event\ManagerInterface;
use Acme\Intro\Api\IndexBuilderInterface;
use Magento\Framework\Indexer\CacheContext;
use Magento\Catalog\Model\{ Product, Category };
use Magento\Framework\App\Cache\Type\Block;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Custom
 * @package Acme\Intro\Model\Indexer
 */
class CustomIndexer implements IndexerActionInterface, MviewActionInterface, IdentityInterface
{
    /** @var CacheInterface */
    private CacheInterface $cacheManager;

    /** @var CacheContext */
    private CacheContext $cacheContext;

    /** @var ManagerInterface */
    private ManagerInterface $eventManager;

    /** @var IndexBuilderInterface */
    private IndexBuilderInterface $indexBuilder;

    /**
     * @param CacheInterface $cacheManager
     * @param CacheContext $cacheContext
     * @param ManagerInterface $eventManager
     * @param IndexBuilderInterface $indexBuilder
     */
    public function __construct(
        CacheInterface $cacheManager,
        CacheContext $cacheContext,
        ManagerInterface $eventManager,
        IndexBuilderInterface $indexBuilder
    ) {
        $this->cacheManager = $cacheManager;
        $this->cacheContext = $cacheContext;
        $this->eventManager = $eventManager;
        $this->indexBuilder = $indexBuilder;
    }

    /**
     * @inheirtDoc
     */
    public function executeFull()
    {
        $this->indexBuilder->reindexAll();
        $this->eventManager->dispatch('clean_cache_by_tags', ['object' => $this]);
        $this->cacheManager->clean($this->getIdentities());
    }

    /**
     * @inheirtDoc
     * @throws LocalizedException
     */
    public function executeList(array $ids)
    {
        if (!$ids) {
            throw new LocalizedException(
                __('Could not rebuild index for empty products array')
            );
        }
        $this->indexBuilder->reindexList(array_unique($ids));
        $this->cacheContext->registerEntities(Product::CACHE_TAG, $ids);
    }

    /**
     * @inheirtDoc
     * @throws LocalizedException
     */
    public function executeRow($id)
    {
        if (!$id) {
            throw new LocalizedException(
                __('We can\'t rebuild the index for an undefined product.')
            );
        }
        $this->indexBuilder->reindex($id);
    }

    /**
     * @inheirtDoc
     * @throws LocalizedException
     */
    public function execute($ids)
    {
        $this->executeList($ids);
    }

    /**
     * @inheirtDoc
     */
    public function getIdentities()
    {
        return [
            Category::CACHE_TAG,
            Product::CACHE_TAG,
            Block::CACHE_TAG,
        ];
    }
}
