<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Solution;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collections = Collection::with('Supplier', 'Solution')->where('status_id', '=', 1)->get();

        return Inertia::render(
            'Collection/Index',
            [
                'collections' => $collections
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = Supplier::orderBy('name')->get();
        $solution = Solution::orderBy('name')->get();

        return Inertia::render(
            'Collection/Create',
            [
                'suppliers' => $supplier,
                'solutions' => $solution
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:128',
            'supplier_id' => 'required|numeric',
            'solution_id' => 'required|numeric',
        ]);

        Collection::create([
            'name' => $request->name,
            'supplier_id' => $request->supplier_id,
            'solution_id' => $request->solution_id,
            'status_id' => 1,
            'company_id' => Auth::user()->company_id
        ]);

        sleep(1);
        return redirect()->route('collection.index')->with('message', 'Coleção criada com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        $supplier = Supplier::orderBy('name')->get();
        $solution = Solution::orderBy('name')->get();

        return Inertia::render(
            'Collection/Edit',
            [
                'collection' => $collection,
                'suppliers' => $supplier,
                'solutions' => $solution
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'name' => 'required|string|max:128',
            'supplier_id' => 'required|numeric',
            'solution_id' => 'required|numeric',
        ]);

        $collection->name = $request->name;
        $collection->supplier_id = $request->supplier_id;
        $collection->solution_id = $request->solution_id;
        $collection->save();
        sleep(1);

        return redirect()->route('collection.index')->with('message', 'Coleção atualizada com sucesso');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        $collection->status_id = 3;
        $collection->save();
        sleep(1);

        return redirect()->route('collection.index')->with('message', 'Coleção excluída com sucesso');
    }
}
