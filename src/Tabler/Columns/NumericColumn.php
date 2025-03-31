<?php

namespace bytemorphic\Tabler\Columns;

use bytemorphic\Tabler\Column;

class NumericColumn extends Column
{
    protected ?int $decimals = null;

    protected ?string $prefix = null;

    protected ?string $suffix = null;

    public function decimals(int $decimals): static
    {
        $this->decimals = $decimals;

        return $this;
    }

    public function prefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function suffix(string $suffix): static
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'decimals' => $this->decimals,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
        ]);
    }

    public function getType(): string
    {
        return 'numeric';
    }
}
