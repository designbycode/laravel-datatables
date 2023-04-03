<?php

namespace Designbycode\Datatables\Http\Interfaces;

interface DatatableInterface
{
    public function index();

    public function show(string $id);

    public function create();

    public function store();

    public function edit(string $id);

    public function update(string $id);

    public function destroy(string $ids);
}
