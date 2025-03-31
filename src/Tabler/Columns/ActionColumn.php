<?php

namespace bytemorphic\Tabler\Columns;

use bytemorphic\Tabler\Column;

class ActionColumn extends Column
{
    public static function new(): static
    {
        return new static('actions', 'Actions');
    }

    public function getType(): string
    {
        return 'action';
    }
}
