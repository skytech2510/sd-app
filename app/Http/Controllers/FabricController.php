<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Fabric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class FabricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fabrics = Fabric::with('collection')->where('status_id', '=', 1)->get();
        
        return Inertia::render(
            'Fabric/Index',
            [
                'fabrics' => $fabrics
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $collections = Collection::orderBy('name')->get();

        return Inertia::render(
            'Fabric/Create',
            [
                'collections' => $collections,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fabric_cod' => 'required|string',
            'name' => 'required|string|max:128',
            'fabric_width' => 'required|string',
            'composition' => 'required|string',
            'colors' => 'required|string',
            'collection_id' => 'required|numeric',
            'cost' => 'required|string',
            'discount' => 'required|string',
            'ST' => 'required|string',
            'IPI' => 'required|string',
            'shipping' => 'required|string',
            'price' => 'required|string'
        ]);

        Fabric::create([
            'fabric_cod' => $request->fabric_cod,
            'name' => $request->name,
            'fabric_width' => $request->fabric_width,
            'composition' => $request->composition,
            'colors' => $request->colors,
            'collection_id' => $request->collection_id,
            'cost' => formatMoney($request->cost),
            'discount' => formatMoney($request->discount),
            'ST' => formatMoney($request->ST),
            'IPI' => formatMoney($request->IPI),
            'shipping' => formatMoney($request->shipping),
            'price' => formatMoney($request->price),

            'status_id' => 1,
            'company_id' => Auth::user()->company_id
        ]);

        sleep(1);
        return redirect()->route('fabric.index')->with('message', 'Tecido criado Com Sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fabric $fabric)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fabric $fabric)
    {
        $collections = Collection::orderBy('name')->get();

        return Inertia::render(
            'Fabric/Edit',
            [
                'fabric' => $fabric,
                'collections' => $collections,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fabric $fabric)
    {
        $request->validate([
            'fabric_cod' => 'required|string',
            'name' => 'required|string|max:128',
            'fabric_width' => 'required|string',
            'composition' => 'required|string',
            'colors' => 'required|string',
            'collection_id' => 'required|numeric',
            'cost' => 'required|numeric',
            'discount' => 'required|numeric',
            'ST' => 'required|numeric',
            'IPI' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        $fabric->fabric_cod = $request->fabric_cod;
        $fabric->name = $request->name;
        $fabric->fabric_width = $request->fabric_width;
        $fabric->composition = $request->composition;
        $fabric->colors = $request->colors;
        $fabric->collection_id = $request->collection_id;
        $fabric->cost = $request->cost;
        $fabric->discount = $request->discount;
        $fabric->ST = $request->ST;
        $fabric->IPI = $request->IPI;
        $fabric->price = $request->price;
        $fabric->save();

        sleep(1);
        return redirect()->route('fabric.index')->with('message', 'Tecido atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fabric $fabric)
    {
        $fabric->status_id = 3;
        $fabric->save();

        sleep(1);
        return redirect()->route('fabric.index')->with('message', 'Tecido excluído com sucesso');
    }
}
