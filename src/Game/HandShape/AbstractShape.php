<?php

namespace App\Game\HandShape;

abstract class AbstractShape implements ShapeInterface
{
    /**
     * @return array
     */
    abstract protected function beats(): array;

    public function __construct()
    {
        if (static::SHAPE_NAME === null) {
            throw new \LogicException(sprintf('The SHAPE_NAME const cannot be null for class %s', get_class($this)));
        }
    }

    /**
     * @return string
     */
    public function getShapeName(): string
    {
        return $this::SHAPE_NAME;
    }

    /**
     * @param ShapeInterface $compared
     *
     * @return bool
     */
    public function compare(ShapeInterface $compared): bool
    {
        return in_array($compared::SHAPE_NAME, $this->beats());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getShapeName();
    }
}
