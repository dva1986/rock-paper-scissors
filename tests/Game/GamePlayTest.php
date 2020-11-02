<?php

namespace App\Tests\Game;

use App\Game\GamePlay;
use App\Game\HandShape\Paper;
use App\Game\HandShape\Rock;
use App\Game\HandShape\Scissors;
use App\Game\Participant\Player;
use App\Game\Strategy\RandomStrategy;
use App\Game\Strategy\StaticStrategy;
use App\Game\Strategy\StrategyInterface;
use PHPUnit\Framework\TestCase;

class GamePlayTest extends TestCase
{
    /**
     * @return \Generator
     */
    public function getTotalResultDataProvider(): iterable
    {
        yield 'the result is draw' => [
            'thrownShapes' => [
                new Paper(),
                new Scissors(),
                new Rock(),
                new Paper(),
                new Scissors(),
                new Rock()
            ],
            'expectedPointsPlayerA' => 2,
            'expectedPointsPlayerB' => 2,
            'expectedWinner' => null,
        ];

        yield 'the winner is player A by 1 point advantage' => [
            'thrownShapes' => [
                new Paper(),
                new Rock(),
                new Rock(),
                new Scissors()
            ],
            'expectedPointsPlayerA' => 2,
            'expectedPointsPlayerB' => 1,
            'expectedWinner' => 'Player A',
        ];

        yield 'the winner is player A by 3 points advantage' => [
            'thrownShapes' => [
                new Rock(),
                new Rock(),
                new Rock(),
                new Paper()
            ],
            'expectedPointsPlayerA' => 3,
            'expectedPointsPlayerB' => 0,
            'expectedWinner' => 'Player A',
        ];

        yield 'the winner is player B with by 2 points advantage' => [
            'thrownShapes' => [
                new Scissors(),
                new Scissors(),
                new Paper()
            ],
            'expectedPointsPlayerA' => 0,
            'expectedPointsPlayerB' => 2,
            'expectedWinner' => 'Player B',
        ];

        yield 'the winner is player A by 4 points advantage' => [
            'thrownShapes' => [
                new Scissors(),
                new Paper(),
                new Scissors(),
                new Rock(),
                new Scissors(),
                new Scissors(),
                new Scissors()
            ],
            'expectedPointsPlayerA' => 1,
            'expectedPointsPlayerB' => 5,
            'expectedWinner' => 'Player B',
        ];
    }

    /**
     * @dataProvider getTotalResultDataProvider
     *
     * @param array       $thrownShapes
     * @param int         $expectedPointsPlayerA
     * @param int         $expectedPointsPlayerB
     * @param string|null $expectedWinner
     */
    public function testTotalResult(array $thrownShapes, int $expectedPointsPlayerA, int $expectedPointsPlayerB, ?string $expectedWinner)
    {
        /** @var StrategyInterface $strategyMock */
        $strategyMock = $this
            ->getMockBuilder(RandomStrategy::class)
            ->getMock();

        foreach ($thrownShapes as $index => $shape) {
            $strategyMock
                ->expects($this->at($index))
                ->method('throwShape')
                ->willReturn($shape);
        }

        $gamePlay = new GamePlay(count($thrownShapes));

        $gamePlay->addPlayer(new Player('Player A', new StaticStrategy()));
        $gamePlay->addPlayer(new Player('Player B', $strategyMock));

        $result = $gamePlay->play();

        $points = $result->getPoints();
        $this->assertArrayHasKey(0, $points);
        $this->assertArrayHasKey(1, $points);

        $this->assertEquals($expectedPointsPlayerA, $points[0]);
        $this->assertEquals($expectedPointsPlayerB, $points[1]);

        if ($expectedWinner !== null) {
            $this->assertNotNull($result->getWinner());
            $this->assertEquals($expectedWinner, $result->getWinner()->getName());
        } else {
            $this->assertNull($result->getWinner());
        }
    }
}
