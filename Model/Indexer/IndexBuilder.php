<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Model\Indexer;

use Acme\Intro\Api\IndexBuilderInterface;

use Psr\Log\LoggerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Acme\Intro\Api\RuleCalculatorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class IndexBuilder
 * @package Acme\Intro\Model\Indexer
 */
class IndexBuilder implements IndexBuilderInterface
{
    /** @var LoggerInterface  */
    private LoggerInterface $logger;

    /** @var RuleCalculatorInterface  */
    private RuleCalculatorInterface $ruleCalculator;

    /** @var ResourceConnection  */
    private ResourceConnection $resource;

    /** @var AdapterInterface  */
    private AdapterInterface $connection;

    /**
     * @param LoggerInterface $logger
     * @param RuleCalculatorInterface $ruleCalculator
     * @param ResourceConnection $resource
     */
    public function __construct(
        LoggerInterface $logger,
        RuleCalculatorInterface $ruleCalculator,
        ResourceConnection $resource
    ) {
        $this->logger = $logger;
        $this->ruleCalculator = $ruleCalculator;
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
    }

    /**
     * @inheirtDoc
     * @throws LocalizedException
     */
    public function reindexAll(): void
    {
        $this->handle(function() {
            $this->doReindexAll();
        });
    }

    /**
     * @inheirtDoc
     * @throws LocalizedException
     */
    public function reindexList(array $ids): void
    {
        $this->handle(function() use ($ids) {
            $this->doReindexList($ids);
        });
    }

    /**
     * @inheirtDoc
     * @throws LocalizedException
     */
    public function reindex(int $id): void
    {
        $this->handle(function() use ($id) {
            $this->doReindex($id);
        });
    }

    /**
     * @return void
     */
    private function doReindexAll(): void
    {
        $this->connection->truncateTable($this->getIndexTable());
        $select = $this->connection
            ->select()
            ->from(
                $this->getProductTable(),
                ['entity_id']
            )
        ;
        $ids = $this->connection->fetchCol($select);
        $ids = array_map(function($id) {
            return (int) $id;
        }, $ids);
        $this->buildProductIndex($ids);
    }

    /**
     * @param int $id
     * @return void
     */
    private function doReindex(int $id): void
    {
        $this->doReindexList([$id]);
    }

    /**
     * @param int[] $ids
     * @return void
     */
    private function doReindexList(array $ids): void
    {
        $this->cleanProductIndex($ids);
        $this->buildProductIndex($ids);
    }

    /**
     * @param int[] $ids
     * @return void
     */
    private function buildProductIndex(array $ids): void
    {
        $rows = [];
        foreach ($ids as $id) {
            $rows[] = $this->makeIndexRow($id);
        }
        $this->storeProductIndex($rows);
    }

    /**
     * Clean product index
     *
     * @param int[] $ids
     */
    private function cleanProductIndex(array $ids): void
    {
        $where = ['product_id IN (?)' => $ids];
        $this->connection->delete($this->getIndexTable(), $where);
    }

    /**
     * @param array $rows
     * [
     *  [
     *      'product_id' => $product_id,
     *      'result'     => $result,
     *  ]
     * ]
     * @return void
     */
    private function storeProductIndex(array $rows): void
    {
        $this->connection->insertMultiple($this->getIndexTable(), $rows);
    }

    /**
     * Helper method for building row
     *
     * @param int $product_id
     * @return array
     * [
     *      'product_id' => $product_id
     *      'result'     => $result,
     * ]
     */
    private function makeIndexRow(int $product_id): array
    {
        $result = $this->ruleCalculator->calculate($product_id);
        return compact('product_id', 'result');
    }

    /**
     * @return string
     */
    private function getIndexTable(): string
    {
        return $this->getTable('test_custom_product_index');
    }

    /**
     * @return string
     */
    private function getProductTable(): string
    {
        return $this->getTable('catalog_product_entity');
    }

    /**
     * Retrieve table name
     *
     * @param string $tableName
     * @return string
     */
    private function getTable(string $tableName): string
    {
        return $this->resource->getTableName($tableName);
    }

    /**
     * @param callable $callback
     * @throws LocalizedException
     */
    private function handle(callable $callback): void
    {
        try {
            $callback();
        } catch (\Exception $e) {
            $this->logger->critical($e);
            throw new LocalizedException(
                __(
                    "Test Custom Product Index indexing failed with message:\n%1\nSee details in exception log.",
                    $e->getMessage()
                )
            );
        }
    }
}
