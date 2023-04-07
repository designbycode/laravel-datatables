<?php

namespace Designbycode\Datatables;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

abstract class DatatablesController extends Controller
{
    use DatatableTrait;

    public function index(Request $request)
    {
        return $this->getResponse($request);
    }

    public function show(string $id)
    {
        // TODO: Implement show() method.
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store()
    {
        // TODO: Implement store() method.
    }

    public function edit(string $id)
    {
        // TODO: Implement edit() method.
    }

    public function update(string $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy(string $ids)
    {
        // TODO: Implement destroy() method.
    }
}
