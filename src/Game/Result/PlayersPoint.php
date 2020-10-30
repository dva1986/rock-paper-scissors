<?php

namespace App\Game\Result;

class PlayersPoint
{
    /**
     * @var int
     */
    private $playerA;

    /**
     * @var int
     */
    private $playerB;

    public function __construct(int $playerA, int $playerB)
    {
        $this->playerA = $playerA;
        $this->playerB = $playerB;
    }

    /**
     * @return int
     */
    public function getPlayerA(): int
    {
        return $this->playerA;
    }

    /**
     * @return int
     */
    public function getPlayerB(): int
    {
        return $this->playerB;
    }
}
