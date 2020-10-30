<?php

namespace App\Game;

use App\Game\Participant\Player;
use App\Game\Result\PlayersPoint;
use App\Game\Result\StageResult;
use App\Game\Result\TotalResult;

class GamePlay
{
    /**
     * @var int
     */
    private $numberOfThrows;

    /**
     * @var Player
     */
    private $playerA;

    /**
     * @var Player
     */
    private $playerB;

    public function __construct(int $numberOfThrows, Player $playerA, Player $playerB)
    {
        $this->numberOfThrows = $numberOfThrows;
        $this->playerA = $playerA;
        $this->playerB = $playerB;
    }

    /**
     * @return TotalResult
     */
    public function play(): TotalResult
    {
        $stageResults = [];
        $pointsPlayerA = $pointsPlayerB = 0;

        for ($throwIn = 1; $throwIn <= $this->numberOfThrows; $throwIn++) {
            $shapeA = $this->playerA->getStrategy()->throwShape();
            $shapeB = $this->playerB->getStrategy()->throwShape();

            $winner = null;
            if ($shapeA->compare($shapeB)) {
                $winner = $this->playerA;
                $pointsPlayerA++;
            } elseif ($shapeB->compare($shapeA)) {
                $winner = $this->playerB;
                $pointsPlayerB++;
            }
            $stageResults[] = new StageResult($throwIn, $shapeA, $shapeB, $winner);
        }

        $playersPoint = new PlayersPoint($pointsPlayerA, $pointsPlayerB);

        return new TotalResult($stageResults, $playersPoint, $this->getTotalWinner($playersPoint));
    }

    /**
     * @param PlayersPoint $playersPoint
     *
     * @return Player|null
     */
    private function getTotalWinner(PlayersPoint $playersPoint): ?Player
    {
        $winner = null;
        if ($playersPoint->getPlayerA() !== $playersPoint->getPlayerB()) {
            $winner = $playersPoint->getPlayerA() > $playersPoint->getPlayerB() ? $this->playerA : $this->playerB;
        }

        return $winner;
    }
}
