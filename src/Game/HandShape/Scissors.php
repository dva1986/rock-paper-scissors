<?php

namespace App\Game\HandShape;

class Scissors extends AbstractShape
{
    public const SHAPE_NAME = 'scissors';

    /**
     * @return array
     */
    protected function beats(): array
    {
        return [
            Paper::SHAPE_NAME,
        ];
    }
}
