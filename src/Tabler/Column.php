<?php

namespace bytemorphic\Tabler;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Column
{
    protected string $name;

    protected ?string $label = null;

    protected bool $sortable = false;

    protected ?Closure $sortCallback = null;

    protected ?Closure $valueCallback = null;

    protected ?Closure $exportCallback = null;

    protected array $exportStyle = [];

    protected array $meta = [];

    /**
     * Create a new column instance.
     */
    public function __construct(string $name, ?string $label = null)
    {
        $this->name = $name;
        $this->label = $label ?? $this->formatLabel($name);
    }

    /**
     * Create a new column instance.
     */
    public static function make(string $name, ?string $label = null): static
    {
        return new static($name, $label);
    }

    /**
     * Format a label from the given name.
     */
    protected function formatLabel(string $name): string
    {
        return ucfirst(str_replace('_', ' ', $name));
    }

    /**
     * Get the name of the column.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the label of the column.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set the column as sortable.
     */
    public function sortable(bool $sortable = true): static
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * Set a custom sort callback.
     */
    public function sortUsing(Closure $callback): static
    {
        $this->sortCallback = $callback;
        $this->sortable = true;

        return $this;
    }

    /**
     * Check if the column has a sort callback.
     */
    public function hasSortCallback(): bool
    {
        return $this->sortCallback !== null;
    }

    /**
     * Apply sorting to the query.
     */
    public function applySorting(Builder $query, SortDirection $direction): void
    {
        if ($this->sortCallback) {
            ($this->sortCallback)($query, $direction);
        } else {
            $query->orderBy($this->name, $direction->value);
        }
    }

    /**
     * Set a custom value callback.
     */
    public function value(Closure $callback): static
    {
        $this->valueCallback = $callback;

        return $this;
    }

    /**
     * Get the value for the column.
     */
    public function getValue(Model $model): mixed
    {
        if ($this->valueCallback) {
            return ($this->valueCallback)($model);
        }

        return $model->{$this->name};
    }

    /**
     * Set a custom export callback.
     */
    public function exportAs(Closure $callback): static
    {
        $this->exportCallback = $callback;

        return $this;
    }

    /**
     * Set export styles for the column.
     */
    public function exportStyle(array $style): static
    {
        $this->exportStyle = $style;

        return $this;
    }

    /**
     * Get the export value for the column.
     */
    public function getExportValue(Model $model): mixed
    {
        if ($this->exportCallback) {
            return ($this->exportCallback)($this->getValue($model), $model);
        }

        return $this->getValue($model);
    }

    /**
     * Set additional metadata for the column.
     */
    public function meta(array $meta): static
    {
        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }

    /**
     * Convert the column to an array.
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'sortable' => $this->sortable,
            'type' => $this->getType(),
            'meta' => $this->meta,
        ];
    }

    /**
     * Get the column type.
     */
    abstract public function getType(): string;
}
