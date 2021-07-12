<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Model;

use Acme\Intro\Api\Data\IndexResultInterface;
use Acme\Intro\Api\Data\IndexResultExtensionInterface;

/**
 * Class IndexResult
 * @package Acme\Intro\Model
 */
class IndexResult implements IndexResultInterface
{
    /** @var int */
    private int $productId;

    /** @var int */
    private int $result;

    /** @var array */
    private array $extensionAttributes;

    /**
     * @inheirtDoc
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @inheirtDoc
     */
    public function getResult(): int
    {
        return $this->result;
    }

    /**
     * @inheirtDoc
     */
    public function setProductId(int $id): IndexResultInterface
    {
        $this->productId = $id;
        return $this;
    }

    /**
     * @inheirtDoc
     */
    public function setResult(int $result): IndexResultInterface
    {
        $this->result = $result;
        return $this;
    }


    /**
     * @inheirtDoc
     */
    public function getExtensionAttributes(): ?IndexResultExtensionInterface
    {
        return $this->extensionAttributes;
    }

    /**
     * @inheirtDoc
     */
    public function setExtensionAttributes(IndexResultExtensionInterface $extensionAttributes): IndexResultInterface
    {
        $this->extensionAttributes = $extensionAttributes;
        return $this;
    }
}
