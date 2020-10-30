<?php

namespace App\Game\HandShape;

interface ShapeInterface
{
    public const SHAPE_NAME = null;

    /**
     * @param ShapeInterface $compared
     *
     * @return bool
     */
    public function compare(ShapeInterface $compared): bool;

    /**
     * @return string
     */
    public function getShapeName(): string;
}
