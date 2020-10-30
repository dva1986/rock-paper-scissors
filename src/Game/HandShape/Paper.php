<?php

namespace App\Game\HandShape;

class Paper extends AbstractShape
{
    public const SHAPE_NAME = 'paper';

    /**
     * @return array
     */
    protected function beats(): array
    {
        return [
            Rock::SHAPE_NAME,
        ];
    }
}
