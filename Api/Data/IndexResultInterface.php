<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface IndexResultInterface
 * @package Acme\Intro\Api\Data
 */
interface IndexResultInterface extends ExtensibleDataInterface
{
    const PRODUCT_ID = "product_id";
    const RESULT = 'result';

    /**
     * @return IndexResultInterface|null
     */
    public function getExtensionAttributes(): ?IndexResultInterface;

    /**
     * @param IndexResultInterface $extensionAttributes
     * @return self
     */
    public function setExtensionAttributes(IndexResultInterface $extensionAttributes): self;
}
