<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
use Acme\Intro\Api\Data\IndexResultExtensionInterface;

/**
 * Interface IndexResultInterface
 * @package Acme\Intro\Api\Data
 */
interface IndexResultInterface extends ExtensibleDataInterface
{
    const PRODUCT_ID = "product_id";
    const RESULT = 'result';

    /**
     * @return int
     */
    public function getProductId(): int;

    /**
     * @return int
     */
    public function getResult(): int;

    /**
     * @param int $id
     * @return $this
     */
    public function setProductId(int $id): self;

    /**
     * @param int $result
     * @return $this
     */
    public function setResult(int $result): self;

    /**
     * @return IndexResultExtensionInterface|null
     */
    public function getExtensionAttributes(): ?IndexResultExtensionInterface;

    /**
     * @param IndexResultExtensionInterface $extensionAttributes
     * @return self
     */
    public function setExtensionAttributes(IndexResultExtensionInterface $extensionAttributes): self;
}
