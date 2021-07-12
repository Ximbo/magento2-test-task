<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Api;

/**
 * Interface RuleCalculator
 * @package Acme\Intro\Api
 */
interface RuleCalculator
{
    /**
     * Calculate result based on input value
     *
     * @param int $input
     * @return int
     */
    public function calculate(int $input): int;
}
