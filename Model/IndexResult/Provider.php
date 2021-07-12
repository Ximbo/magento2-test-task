<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Model\IndexResult;

use Acme\Intro\Api\IndexResultProviderInterface;
use Acme\Intro\Api\Data\IndexResultInterface;
use Magento\Framework\EntityManager\EntityManager;
use Acme\Intro\Model\ResourceModel\IndexResult\Loader;
use Acme\Intro\Model\IndexResultFactory;

/**
 * Class Provider
 * @package Acme\Intro\Model\IndexResult
 */
class Provider implements IndexResultProviderInterface
{
    /** @var EntityManager */
    private EntityManager $entityManager;

    /** @var Loader */
    private Loader $loader;

    /** @var IndexResultFactory */
    private IndexResultFactory $indexResultFactory;

    /**
     * @param EntityManager $entityManager
     * @param Loader $loader
     * @param IndexResultFactory $indexResultFactory
     */
    public function __construct(
        EntityManager $entityManager,
        Loader $loader,
        IndexResultFactory $indexResultFactory
    ) {
        $this->entityManager = $entityManager;
        $this->loader = $loader;
        $this->indexResultFactory = $indexResultFactory;
    }

    /**
     * @inheirtDoc
     * @throws \Exception
     */
    public function getIndexResult(int $productId): int
    {
        $result = $this->loader->getResultByProductId($productId);
        return (int) $result[0];
        $results = [];
        foreach($ids as $id) {
            $result = $this->indexResultFactory->create();
            $results[] = $this->entityManager->load($result, $id);
        }

        return $results;

        $result = $this->indexResultFactory->create();
        $entity =  $this->entityManager->load($result, $id);
        return $entity;
    }
}
