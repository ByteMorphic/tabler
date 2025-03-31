<?php

namespace bytemorphic\Tabler;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Tabler
{
    protected string $resource;

    protected string $defaultSort = 'id';

    protected string $defaultSortDirection = 'asc';

    protected $perPageOptions = [10, 25, 50];

    protected array $search = [];

    protected int $defaultPerPage = 10;

    /**
     * Define the table columns.
     */
    abstract public function columns(): array;

    /**
     * Define available filters.
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * Define available actions.
     */
    public function actions(): array
    {
        return [];
    }

    /**
     * Define available exports.
     */
    public function exports(): array
    {
        return [];
    }

    /**
     * Boot the table.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Get the query for the table.
     */
    public function query(): Builder
    {
        return app($this->resource)->query();
    }

    /**
     * Process the table query with filters, search, and sorting.
     */
    public function processQuery(array $request): Builder
    {
        $query = $this->query();

        // Apply search
        if (! empty($request['search']) && ! empty($this->search)) {
            $search = $request['search'];
            $query->where(function (Builder $q) use ($search) {
                foreach ($this->search as $field) {
                    $q->orWhere($field, 'LIKE', "%{$search}%");
                }
            });
        }

        // Apply filters
        if (! empty($request['filters'])) {
            foreach ($this->filters() as $filter) {
                if (isset($request['filters'][$filter->getName()])) {
                    $filter->apply($query, $request['filters'][$filter->getName()]);
                }
            }
        }

        // Apply sorting
        $sortField = $request['sort'] ?? $this->defaultSort;
        $sortDirection = $request['direction'] ?? $this->defaultSortDirection;

        // Find column for custom sort handling
        $sortColumn = collect($this->columns())->first(function ($column) use ($sortField) {
            return $column->getName() === $sortField;
        });

        if ($sortColumn && $sortColumn->hasSortCallback()) {
            $sortColumn->applySorting($query, SortDirection::from($sortDirection));
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        return $query;
    }

    /**
     * Get the data for the table.
     */
    public function getData(array $request): array
    {
        $query = $this->processQuery($request);

        $perPage = $request['perPage'] ?? $this->defaultPerPage;
        $page = $request['page'] ?? 1;

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        $data = $paginator->map(function ($model) {
            return $this->mapRowData($model);
        });

        return [
            'data' => $data,
            'meta' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ],
        ];
    }

    /**
     * Map a model to row data.
     */
    protected function mapRowData(Model $model): array
    {
        $rowData = ['id' => $model->getKey()];

        foreach ($this->columns() as $column) {
            $rowData[$column->getName()] = $column->getValue($model);
        }

        return $rowData;
    }

    /**
     * Get the table configuration.
     */
    public function getConfig(): array
    {
        return [
            'columns' => collect($this->columns())->map->toArray()->values()->toArray(),
            'filters' => collect($this->filters())->map->toArray()->values()->toArray(),
            'actions' => collect($this->actions())->map->toArray()->values()->toArray(),
            'exports' => collect($this->exports())->map->toArray()->values()->toArray(),
            'perPageOptions' => $this->perPageOptions,
            'defaultSort' => $this->defaultSort,
            'defaultSortDirection' => $this->defaultSortDirection,
            'defaultPerPage' => $this->defaultPerPage,
        ];
    }
}
