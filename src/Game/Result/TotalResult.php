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
     * @var PlayersPoint
     */
    private $playersPoint;

    /**
     * @var Player|null
     */
    private $winner;

    public function __construct($stageResults, PlayersPoint $playersPoint, ?Player $winner)
    {
        $this->stageResults = $stageResults;
        $this->playersPoint = $playersPoint;
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
     * @return PlayersPoint
     */
    public function getPlayersPoint(): PlayersPoint
    {
        return $this->playersPoint;
    }

    /**
     * @return Player|null
     */
    public function getWinner(): ?Player
    {
        return $this->winner;
    }
}
