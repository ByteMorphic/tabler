<?php

namespace bytemorphic\Tabler\Filters;

use bytemorphic\Tabler\Filter;
use Illuminate\Database\Eloquent\Builder;

class NumericFilter extends Filter
{
    protected function applyFilter(Builder $query, mixed $value): void
    {
        if (is_array($value)) {
            if (isset($value['min']) && $value['min'] !== '') {
                $query->where($this->name, '>=', $value['min']);
            }

            if (isset($value['max']) && $value['max'] !== '') {
                $query->where($this->name, '<=', $value['max']);
            }
        } elseif (is_numeric($value)) {
            $query->where($this->name, $value);
        }
    }

    public function getType(): string
    {
        return 'numeric';
    }
}
