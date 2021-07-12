<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Api;

/**
 * Interface IndexBuilderInterface
 * @package Acme\Intro\Api
 */
interface IndexBuilderInterface
{
    /**
     * Reindex all
     *
     * @return void
     */
    public function reindexAll(): void;

    /**
     * Reindex partial indexation by ID list
     *
     * @param int[] $ids
     * @return void
     */
    public function reindexList(array $ids): void;

    /**
     * Reindex partial indexation by ID
     *
     * @param int $id
     * @return void
     */
    public function reindex(int $id): void;
}
