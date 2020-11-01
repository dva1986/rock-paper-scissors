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

        $playerA = new Player('Player A', new StaticStrategy());
        $playerB = new Player('Player B', new RandomStrategy());
        $game = new GamePlay($this->numberOfThrows, $playerA, $playerB);
        $result = $game->play();

        $table = new Table($output);
        $table->setHeaders(['#', $playerA, $playerB, 'Winner']);
        foreach ($result->getStageResults() as $stageResult) {
            $table->addRow([
                $stageResult->getThrowIn(),
                $stageResult->getShapeA(),
                $stageResult->getShapeB(),
                $stageResult->getWinner()
            ]);
        }
        $table
            ->addRow(new TableSeparator())
            ->addRow($this->createTableCell($this->formatPoints($playerA, $result->getPlayersPoint()->getPlayerA())))
            ->addRow($this->createTableCell($this->formatPoints($playerB, $result->getPlayersPoint()->getPlayerB())))
            ->addRow($this->createTableCell($this->formatWinner($result)))
            ->render();

        return Command::SUCCESS;
    }

    /**
     * @param string $string
     *
     * @return array
     */
    private function createTableCell(string $string): array
    {
        return [new TableCell($string, ['colspan' => 4])];
    }

    /**
     * @param Player $player
     * @param int    $points
     *
     * @return string
     */
    private function formatPoints(Player $player, int $points): string
    {
        return sprintf("%s: %s", $player, $points);
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
                "Winner: %s (+%s pts)",
                $result->getWinner()->getName(),
                abs($result->getPlayersPoint()->getPlayerA() - $result->getPlayersPoint()->getPlayerB())
            );
        }

        return $finalRow;
    }
}
