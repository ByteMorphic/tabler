<?php

namespace bytemorphic\Tabler;

class Export
{
    protected string $label;

    protected string $type;

    protected array $meta = [];

    public function __construct(string $label, string $type)
    {
        $this->label = $label;
        $this->type = $type;
    }

    public static function make(string $label, string $type): static
    {
        return new static($label, $type);
    }

    public function meta(array $meta): static
    {
        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'type' => $this->type,
            'meta' => $this->meta,
        ];
    }
}
