<?php

namespace Designbycode\Datatables\Http\Traits;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait DatatableTrait
{
    private Builder $builder;

    public function __construct()
    {
        $builder = $this->builder();

        if (! $builder instanceof Builder) {
            throw new Exception('Not an instance of Builder');
        }

        $this->builder = $builder;
    }

    abstract protected function builder(): Builder;

    protected function getData(Request $request): array
    {
        return [
            'data' => [
                'records' => $this->getRecords($request),
            ],
        ];
    }

    private function getRecords(Request $request): LengthAwarePaginator
    {
        return $this->builder->orderBy('id', 'asc')->paginate();
    }
}
