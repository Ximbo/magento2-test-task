<?php
/**
 * @copyright: Copyright © 2021 Acme Company Inc. All rights reserved.
 * @author   : Acme Company <mail@example.com>
 */

namespace Acme\Intro\Model;

use Acme\Intro\Api\RuleCalculatorInterface;

/**
 * Class RuleCalculator
 * @package Acme\Intro\Model
 */
class RuleCalculator implements RuleCalculatorInterface
{
    /**
     * Check value for odd/even. Return 1 for odd and 0 for even input value
     * @inheirtDoc
     */
    public function calculate(int $input): int
    {
        return $input % 2 === 0;
    }
}
