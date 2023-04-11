<?php

namespace Designbycode\Datatables\Tests\Stubs;

use Designbycode\Datatables\DatatablesController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostController extends DatatablesController
{
    public function builder(): Builder
    {
        return Post::query();
    }

    public function index(Request $request): array
    {
        return $this->getResponse($request);
    }
}
