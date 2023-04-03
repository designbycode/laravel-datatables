<?php

namespace Designbycode\Datatables\Http\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait DatatableTrait
{
    protected bool $allowDeletion = true;

    protected bool $allowCreation = true;

    protected bool $createUsingDialog = false;

    protected bool $allowSearching = true;

    protected int $default_limit = 25;

    public Builder $builder;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $builder = $this->builder();

        if (! $builder instanceof Builder) {
            throw new Exception('Not an instance of Builder');
        }

        $this->builder = $builder;
    }

    /**
     * Use Model::query() image model controller
     */
    abstract public function builder(): Builder;

    /**
     * Get all response data to be added to index
     *
     * @return array[]
     */
    public function getResponse(Request $request): array
    {
        return [
            'data' => [
                'name' => $this->getDataTableName(),
                'name_singular' => Str::singular($this->getDataTableName()),
                'settings' => [
                    'allow' => [
                        'deletions' => $this->allowDeletion,
                        'creation' => $this->allowCreation,
                        'searching' => $this->allowSearching,
                    ],
                    'create_with_dialog' => $this->createUsingDialog,
                    'pagination_limit' => $this->getLimit($request),
                ],
                'database' => [
                    'typings' => $this->getModelDatabaseTypings(),
                    'input_types' => $this->getFormInputTypes(),
                ],
                'columns' => [
                    'updatable' => $this->getUpdatableColumns(),
                    'creatable' => $this->getCreatableColumns(),
                    'displayable' => $this->getDisplayableColumns(),
                ],
                'records' => $this->getRecords($request),
            ],
        ];
    }

    /**
     * Get the name of the database table
     */
    protected function getDataTableName(): string
    {
        return $this->builder->getModel()->getTable();
    }

    /**
     * Get the paginated limit
     */
    private function getLimit(Request $request): int
    {
        return $request->limit ?? $this->default_limit;
    }

    /**
     * They will give the typing of the database field
     */
    private function getModelDatabaseTypings(): array
    {
        return array_intersect_key($this->getTableColumns(), array_flip(array_values($this->getCreatableColumns())));
    }

    /**
     * Get array of database columns
     */
    protected function getTableColumns(): array
    {
        $table = $this->builder->getModel()->getTable();
        $builder = $this->builder->getModel()->getConnection()->getSchemaBuilder();
        $columns = $builder->getColumnListing($table);
        $columnsWithType = collect($columns)->mapWithKeys(function ($item, $key) use ($builder, $table) {
            $key = $builder->getColumnType($table, $item);

            return [$item => $key];
        });

        return $columnsWithType->toArray();
    }

    /**
     * Give array of fields that is fillable
     */
    protected function getCreatableColumns(): array
    {
        return $this->builder->getModel()->getFillable();
    }

    /**
     * Create form input types
     */
    abstract public function getFormInputTypes(): array;

    /**
     * Only column field that can be updated
     */
    protected function getUpdatableColumns(): array
    {
        return $this->getDisplayableColumns();
    }

    /**
     * Give array of database columns
     */
    private function getDisplayableColumns(): array
    {
        return array_diff($this->getDisplayableColumnNames(), $this->builder->getModel()->getHidden(), $this->builder->getModel()->getDates());
    }

    /**
     * Gives the names of database column
     */
    protected function getDisplayableColumnNames(): array
    {
        return Schema::getColumnListing($this->builder->getModel()->getTable());
    }

    /**
     * Build query and return collection of data
     */
    private function getRecords(Request $request): LengthAwarePaginator
    {
        $builder = $this->builder;

        if ($this->hasSearchQuery($request)) {
            $builder = $this->buildSearch($builder, $request);
        }

        return $this->builder->orderBy('id', 'asc')->paginate($this->getLimit($request))
            ->through(function ($model) {
                return Arr::only($model->toArray(), $this->getDisplayableColumns());
            });
    }

    /**
     * Check if search query is present
     */
    protected function hasSearchQuery(Request $request): bool
    {
        return count(array_filter($request->only('column', 'operator', 'value'))) === 3;
    }

    private function buildSearch(Builder $builder, Request $request): Builder
    {
        $queryParts = $this->resolveQueryParts($request->operator, $request->value);

        if (! $this->hasSearchQuery($request)) {
            dd('no');
        }

        return $builder->where($request->column, $queryParts['operator'], $queryParts['value']);
    }

    /**
     * Query part for search builder.
     */
    private function resolveQueryParts($operator, $value): mixed
    {
        return Arr::get([
            'equals' => [
                'operator' => '=',
                'value' => $value,
            ],
            'contains' => [
                'operator' => 'LIKE',
                'value' => "%{$value}%",
            ],
            'starts_with' => [
                'operator' => 'LIKE',
                'value' => "{$value}%",
            ],
            'ends_with' => [
                'operator' => 'LIKE',
                'value' => "%{$value}",
            ],
            'greater_than' => [
                'operator' => '>',
                'value' => $value,
            ],
            'greater_or_equal_than' => [
                'operator' => '>=',
                'value' => $value,
            ],
            'less_than' => [
                'operator' => '<',
                'value' => $value,
            ],
            'less_or_equal_than' => [
                'operator' => '<=',
                'value' => $value,
            ],
        ], $operator);
    }
}
