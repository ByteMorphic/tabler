<?php

namespace bytemorphic\Tabler\Columns;

use bytemorphic\Tabler\Column;
use Illuminate\Database\Eloquent\Model;

class BooleanColumn extends Column
{
    protected ?string $trueLabel = 'Yes';

    protected ?string $falseLabel = 'No';

    public function trueLabel(string $label): static
    {
        $this->trueLabel = $label;

        return $this;
    }

    public function falseLabel(string $label): static
    {
        $this->falseLabel = $label;

        return $this;
    }

    public function getValue(Model $model): mixed
    {
        $value = parent::getValue($model);

        return (bool) $value;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'trueLabel' => $this->trueLabel,
            'falseLabel' => $this->falseLabel,
        ]);
    }

    public function getType(): string
    {
        return 'boolean';
    }
}
