<?php

namespace App\Command;

use App\Game\GamePlay;
use App\Game\Participant\Player;
use App\Game\Result\TotalResult;
use App\Game\Strategy\RandomStrategy;
use App\Game\Strategy\StaticStrategy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class StartGameCommand extends Command
{
    protected static $defaultName = 'app:game:start';

    /**
     * @var int
     */
    private $numberOfThrows;

    public function __construct(int $numberOfThrows)
    {
        $this->numberOfThrows = $numberOfThrows;

        parent::__construct();
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Start of the game "Rock paper scissors"');

        $game = new GamePlay($this->numberOfThrows);
        $game->addPlayer(new Player('Player A', new StaticStrategy()));
        $game->addPlayer(new Player('Player B', new RandomStrategy()));
        $result = $game->play();

        $table = new Table($output);
        $players = $game->getPlayers();
        $headers = array_merge(['#'], $players, ['Winner']);

        $table->setHeaders($headers);
        foreach ($result->getStageResults() as $stageResult) {
            $row = array_merge([$stageResult->getThrowIn()], $stageResult->getShapes(), [$stageResult->getWinner()]);
            $table->addRow($row);
        }

        $table
            ->addRow(new TableSeparator())
            ->addRow($this->createTableCell($this->formatPoints($game->getPlayers(), $result->getPoints()), count($players)))
            ->addRow($this->createTableCell($this->formatWinner($result), count($players)))
            ->render();

        return Command::SUCCESS;
    }

    /**
     * @param string $string
     * @param int    $totalPlayers
     *
     * @return array
     */
    private function createTableCell(string $string, int $totalPlayers): array
    {
        return [new TableCell($string, ['colspan' => 2 + $totalPlayers])];
    }

    /**
     * @param array $players
     * @param array $points
     *
     * @return string
     */
    private function formatPoints(array $players, array $points): string
    {
        $strArray = [];
        foreach ($players as $index => $player) {
            $strArray[] = sprintf("%s: %s", $player, $points[$index] ?? null);
        }

        return implode("\n", $strArray);
    }

    /**
     * @param TotalResult $result
     *
     * @return string
     */
    private function formatWinner(TotalResult $result): string
    {
        $finalRow = 'Draw';
        if ($result->getWinner() !== null) {
            $finalRow = sprintf(
                "Winner: %s",
                $result->getWinner()
            );
        }

        return $finalRow;
    }
}
