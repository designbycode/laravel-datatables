<?php

namespace Designbycode\Datatables;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

abstract class DatatablesController extends Controller
{
    use DatatableTrait;

    public function index(Request $request)
    {
        config('datatable.limit', 25);

        return $this->getResponse($request);
    }

    public function show(string $id)
    {

    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->builder->create($request->only($this->getCreatableColumns()));
    }

    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->builder->update($request->only($this->getUpdatableColumns()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse|void
     */
    public function destroy(string $ids)
    {
        if ($this->allowDeletion) {
            $this->builder->whereIn('id', explode(',', $ids))->delete();

            return redirect()->back()->with('success', 'Successfully deleted');
        }
    }
}
