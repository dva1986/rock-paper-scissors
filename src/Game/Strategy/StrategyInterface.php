<?php

namespace App\Game\Strategy;

use App\Game\HandShape\ShapeInterface;

interface StrategyInterface
{
    /**
     * @return ShapeInterface
     */
    public function throwShape(): ShapeInterface;
}
