<?php

namespace App\Game\Strategy;

use App\Game\HandShape\Paper;
use App\Game\HandShape\Rock;
use App\Game\HandShape\Scissors;
use App\Game\HandShape\ShapeInterface;

class RandomStrategy implements StrategyInterface
{
    /**
     * @var array|ShapeInterface[]
     */
    private $shapeCollection;

    public function __construct()
    {
        $this->shapeCollection = [
            new Paper(),
            new Rock(),
            new Scissors()
        ];
    }

    /**
     * @return ShapeInterface
     * @throws \Exception
     */
    public function throwShape(): ShapeInterface
    {
        $randomIndex = \random_int(0, count($this->shapeCollection) - 1);

        return $this->shapeCollection[$randomIndex];
    }
}
