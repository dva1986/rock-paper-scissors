<?php

namespace App\Game\Result;

use App\Game\HandShape\ShapeInterface;
use App\Game\Participant\Player;

class StageResult
{
    /**
     * @var int
     */
    private $throwIn;

    /**
     * @var ShapeInterface
     */
    private $shapeA;

    /**
     * @var ShapeInterface
     */
    private $shapeB;

    /**
     * @var Player|null
     */
    private $winner;

    public function __construct(int $throwIn, ShapeInterface $shapeA, ShapeInterface $shapeB, ?Player $winner)
    {
        $this->throwIn = $throwIn;
        $this->shapeA = $shapeA;
        $this->shapeB = $shapeB;
        $this->winner = $winner;
    }

    /**
     * @return int
     */
    public function getThrowIn(): int
    {
        return $this->throwIn;
    }

    /**
     * @return ShapeInterface
     */
    public function getShapeA(): ShapeInterface
    {
        return $this->shapeA;
    }

    /**
     * @return ShapeInterface
     */
    public function getShapeB(): ShapeInterface
    {
        return $this->shapeB;
    }

    /**
     * @return Player|null
     */
    public function getWinner(): ?Player
    {
        return $this->winner;
    }
}
