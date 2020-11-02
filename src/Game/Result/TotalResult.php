<?php

namespace App\Game\Result;

use App\Game\Participant\Player;

class TotalResult
{
    /**
     * @var array|StageResult[]
     */
    private $stageResults = [];

    /**
     * @var array|int
     */
    private $points;

    /**
     * @var Player|null
     */
    private $winner;

    public function __construct(array $stageResults, array $points, ?Player $winner)
    {
        $this->stageResults = $stageResults;
        $this->points = $points;
        $this->winner = $winner;
    }

    /**
     * @return StageResult[]|array
     */
    public function getStageResults()
    {
        return $this->stageResults;
    }

    /**
     * @return array
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * @return Player|null
     */
    public function getWinner(): ?Player
    {
        return $this->winner;
    }
}
