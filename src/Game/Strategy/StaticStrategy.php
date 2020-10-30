<?php

namespace App\Game\Strategy;

use App\Game\HandShape\Paper;
use App\Game\HandShape\ShapeInterface;

class StaticStrategy implements StrategyInterface
{
    /**
     * @var ShapeInterface
     */
    private $shape;

    public function __construct(ShapeInterface $shape = null)
    {
        $this->shape = $shape ?? new Paper();
    }

    /**
     * @return ShapeInterface
     */
    public function throwShape(): ShapeInterface
    {
        return $this->shape;
    }
}
