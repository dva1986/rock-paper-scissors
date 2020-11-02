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
     * @var ShapeInterface|array
     */
    private $shapes;

    /**
     * @var Player|null
     */
    private $winner;

    public function __construct(int $throwIn, array $shapes, ?Player $winner)
    {
        $this->throwIn = $throwIn;
        $this->shapes = $shapes;
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
     * @return array|ShapeInterface[]
     */
    public function getShapes(): array
    {
        return $this->shapes;
    }

    /**
     * @return Player|null
     */
    public function getWinner(): ?Player
    {
        return $this->winner;
    }
}
