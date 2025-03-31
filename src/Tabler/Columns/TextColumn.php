<?php

namespace bytemorphic\Tabler\Columns;

use bytemorphic\Tabler\Column;

class TextColumn extends Column
{
    public function getType(): string
    {
        return 'text';
    }
}
