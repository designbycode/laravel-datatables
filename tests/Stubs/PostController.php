<?php

namespace Designbycode\Datatables\Tests\Stubs;

use Designbycode\Datatables\Http\Controllers\DatatablesController;
use Illuminate\Database\Eloquent\Builder;

class PostController extends DatatablesController
{
    protected function builder(): Builder
    {
        return Post::query();
    }
}
