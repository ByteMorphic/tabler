<?php

namespace bytemorphic\Tabler\Filters;

use bytemorphic\Tabler\Filter;
use Illuminate\Database\Eloquent\Builder;

class TextFilter extends Filter
{
    protected function applyFilter(Builder $query, mixed $value): void
    {
        $query->where($this->name, 'LIKE', "%{$value}%");
    }

    public function getType(): string
    {
        return 'text';
    }
}
