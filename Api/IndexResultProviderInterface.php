<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Api;

use Acme\Intro\Api\Data\IndexResultInterface;

/**
 * Interface IndexResultProviderInterface
 * @package Acme\Intro\Api
 */
interface IndexResultProviderInterface
{
    /**
     * @param int $productId
     * @return IndexResultInterface
     */
    public function getIndexResult(int $productId): IndexResultInterface;
}
