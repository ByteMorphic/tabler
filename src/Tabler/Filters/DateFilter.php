<?php

namespace bytemorphic\Tabler\Filters;

use bytemorphic\Tabler\Filter;
use Illuminate\Database\Eloquent\Builder;

class DateFilter extends Filter
{
    protected bool $allowNull = false;

    public function nullable(bool $nullable = true): static
    {
        $this->allowNull = $nullable;

        return $this;
    }

    protected function applyFilter(Builder $query, mixed $value): void
    {
        if (is_array($value)) {
            if (! empty($value['from'])) {
                $query->whereDate($this->name, '>=', $value['from']);
            }

            if (! empty($value['to'])) {
                $query->whereDate($this->name, '<=', $value['to']);
            }

            if ($this->allowNull && ! empty($value['null'])) {
                $query->whereNull($this->name);
            }
        }
    }

    public function getType(): string
    {
        return 'date';
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'allowNull' => $this->allowNull,
        ]);
    }
}
