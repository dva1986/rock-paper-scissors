<?php

namespace App\Game\HandShape;

class Rock extends AbstractShape
{
    public const SHAPE_NAME = 'rock';

    /**
     * @return array
     */
    protected function beats(): array
    {
        return [
            Scissors::SHAPE_NAME,
        ];
    }
}
