<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Model\Plugin\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Api\SearchResults;
use Acme\Intro\Api\IndexResultProviderInterface;
use Magento\Catalog\Api\Data\ProductExtensionFactory;

/**
 * Class ProductRepository
 * @package Acme\Intro\Model\Plugin
 */
class Repository
{
    /** @var IndexResultProviderInterface */
    private IndexResultProviderInterface $indexResultProvider;

    /** @var ProductExtensionFactory */
    private ProductExtensionFactory $productExtensionFactory;

    public function __construct(
        IndexResultProviderInterface $indexResultProvider,
        ProductExtensionFactory $productExtensionFactory
    ) {
        $this->indexResultProvider = $indexResultProvider;
        $this->productExtensionFactory = $productExtensionFactory;
    }

    /**
     * Add Test Index Result to product extension attributes
     *
     * @param ProductRepositoryInterface $subject
     * @param SearchResults $searchResult
     * @return SearchResults
     */
    public function afterGetList(ProductRepositoryInterface $subject, SearchResults $searchResult): SearchResults
    {
        /** @var ProductInterface $product */
        foreach ($searchResult->getItems() as $product) {
            $this->addIndexResultToProduct($product);
        }

        return $searchResult;
    }

    /**
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $product
     * @return ProductInterface
     */
    public function afterGet(ProductRepositoryInterface $subject, ProductInterface $product): ProductInterface
    {
        $this->addIndexResultToProduct($product);
        return $product;
    }

    /**
     * @param ProductInterface $product
     * @return void
     */
    private function addIndexResultToProduct(ProductInterface $product): void
    {
        $extensionAttributes = $product->getExtensionAttributes();

        if (empty($extensionAttributes)) {
            $extensionAttributes = $this->productExtensionFactory->create();
        }
        $results = $this->indexResultProvider->getIndexResult($product->getId());
        $extensionAttributes->setResult($results);
        $product->setExtensionAttributes($extensionAttributes);
    }
}
