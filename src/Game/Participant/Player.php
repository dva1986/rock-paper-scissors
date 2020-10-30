<?php

namespace App\Game\Participant;

use App\Game\Strategy\StrategyInterface;

class Player
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var StrategyInterface
     */
    private $strategy;

    /**
     * Player constructor.
     *
     * @param string            $name
     * @param StrategyInterface $strategy
     */
    public function __construct(string $name, StrategyInterface $strategy)
    {
        $this->name = $name;
        $this->strategy = $strategy;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return StrategyInterface
     */
    public function getStrategy(): StrategyInterface
    {
        return $this->strategy;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }
}
