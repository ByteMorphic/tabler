<?php

namespace bytemorphic\Tabler;

use Closure;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    protected string $name;

    protected ?string $label = null;

    protected ?Closure $callback = null;

    public function __construct(string $name, ?string $label = null)
    {
        $this->name = $name;
        $this->label = $label ?? $this->formatLabel($name);
    }

    public static function make(string $name, ?string $label = null): static
    {
        return new static($name, $label);
    }

    protected function formatLabel(string $name): string
    {
        return ucfirst(str_replace('_', ' ', $name));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function using(Closure $callback): static
    {
        $this->callback = $callback;

        return $this;
    }

    public function apply(Builder $query, mixed $value): void
    {
        if ($this->callback) {
            ($this->callback)($query, $value);

            return;
        }

        $this->applyFilter($query, $value);
    }

    abstract protected function applyFilter(Builder $query, mixed $value): void;

    abstract public function getType(): string;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'type' => $this->getType(),
        ];
    }
}
