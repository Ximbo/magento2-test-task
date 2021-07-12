<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Model\ResourceModel\IndexResult;

use Magento\Framework\App\ResourceConnection;
use Acme\Intro\Api\Data\IndexResultInterface;
use Magento\Framework\EntityManager\MetadataPool;

/**
 * Class Loader
 * @package Acme\Intro\Model\ResourceModel\IndexResult
 */
class Loader
{
    /** @var MetadataPool */
    private MetadataPool $metadataPool;

    /** @var ResourceConnection */
    private ResourceConnection $resourceConnection;

    /**
     * @param MetadataPool $metadataPool
     * @param ResourceConnection $resourceConnection
     */
    public function __construct
    (
        MetadataPool $metadataPool,
        ResourceConnection $resourceConnection
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param int $productId
     * @return int
     * @throws \Exception
     */
    public function getResultIdByProductId(int $productId): int
    {
        $metadata = $this->metadataPool->getMetadata(IndexResultInterface::class);
        $connection = $this->resourceConnection->getConnection();

        $select = $connection
            ->select()
            ->from($metadata->getEntityTable(), IndexResultInterface::ID)
            ->where(IndexResultInterface::PRODUCT_ID . ' = ?', $productId);
        $id = $connection->fetchCol($select);

        return (int) $id;
    }
}
