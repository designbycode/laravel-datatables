<?php

namespace Designbycode\Datatables\Tests\Stubs;

use Designbycode\Datatables\Http\Controllers\DatatablesController;
use Illuminate\Database\Eloquent\Builder;

class PostController extends DatatablesController
{
    public function builder(): Builder
    {
        return Post::query();
    }

    public function getFormInputTypes(): array
    {
        return [];
    }
}
