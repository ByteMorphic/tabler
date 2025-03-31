<?php

namespace bytemorphic\Tabler;

use Closure;
use Illuminate\Database\Eloquent\Model;

class Action
{
    protected string $label;

    protected ?string $url = null;

    protected ?string $icon = null;

    protected ?Closure $handle = null;

    protected bool $confirmationRequired = false;

    protected ?string $confirmationMessage = null;

    protected array $meta = [];

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public static function make(array $params): static
    {
        $action = new static($params['label']);

        if (isset($params['url'])) {
            $action->url($params['url']);
        }

        if (isset($params['icon'])) {
            $action->icon($params['icon']);
        }

        if (isset($params['handle'])) {
            $action->handle($params['handle']);
        }

        if (isset($params['confirmationRequired']) && $params['confirmationRequired']) {
            $action->requireConfirmation($params['confirmationMessage'] ?? null);
        }

        return $action;
    }

    public function url(string|Closure $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function handle(Closure $callback): static
    {
        $this->handle = $callback;

        return $this;
    }

    public function requireConfirmation(?string $message = null): static
    {
        $this->confirmationRequired = true;
        $this->confirmationMessage = $message;

        return $this;
    }

    public function meta(array $meta): static
    {
        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }

    public function getUrl(Model $model): ?string
    {
        if ($this->url instanceof Closure) {
            return ($this->url)($model);
        }

        return $this->url;
    }

    public function executeHandle(Model $model): mixed
    {
        if ($this->handle) {
            return ($this->handle)($model);
        }

        return null;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'icon' => $this->icon,
            'hasUrl' => $this->url !== null,
            'hasHandler' => $this->handle !== null,
            'confirmationRequired' => $this->confirmationRequired,
            'confirmationMessage' => $this->confirmationMessage,
            'meta' => $this->meta,
        ];
    }
}
