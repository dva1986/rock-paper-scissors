<?php

namespace App\Game;

use App\Game\HandShape\ShapeInterface;
use App\Game\Participant\Player;
use App\Game\Result\StageResult;
use App\Game\Result\TotalResult;

class GamePlay
{
    /**
     * @var int
     */
    private $numberOfThrows;

    /**
     * @var array|Player[]
     */
    private $players = [];

    public function __construct(int $numberOfThrows)
    {
        $this->numberOfThrows = $numberOfThrows;
    }

    /**
     * @param Player $player
     */
    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }

    /**
     * @return array|Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return TotalResult
     */
    public function play(): TotalResult
    {
        $stageResults = [];

        $points = array_fill(0, count($this->players), 0);
        for ($throwIn = 1; $throwIn <= $this->numberOfThrows; $throwIn++) {
            $shapes = array_map(
                function(Player $player): ShapeInterface { return $player->getStrategy()->throwShape(); },
                $this->players
            );

            $winnerIndex = $this->getStageWinnerIndex($shapes);
            $winner = null;
            if ($winnerIndex !== null) {
                $winner = $this->players[$winnerIndex];
                $points[$winnerIndex]++;
            }

            $stageResults[] = new StageResult($throwIn, $shapes, $winner);
        }

        return new TotalResult($stageResults, $points, $this->getTotalWinner($points));
    }

    /**
     * @param array $shapes
     *
     * @return int|null
     */
    private function getStageWinnerIndex(array $shapes): ?int
    {
        $points = [];
        for ($i = 0; $i < count($this->players); $i++) {
            for ($j = $i + 1; $j < count($this->players); $j++) {
                $shape1 = $shapes[$i];
                $shape2 = $shapes[$j];

                if ($shape1->compare($shape2)) {
                    $points[] = $i;
                } elseif ($shape2->compare($shape1)) {
                    $points[] = $j;
                }
            }
        }

        $winner = array_filter(
            array_count_values($points),
            function ($point) {
                return $point === count($this->players) - 1;
            }
        );

        return count($winner) > 0 ? array_key_first($winner) : null;
    }

    /**
     * @param array $points
     *
     * @return Player|null
     */
    private function getTotalWinner(array $points): ?Player
    {
        $max = max($points);

        $winner = array_filter(
            $points,
            function ($point) use ($max) {
                return $point === $max;
            }
        );

        return count($winner) === 1 ? $this->players[array_key_first($winner)] : null;
    }
}
