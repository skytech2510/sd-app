<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Optional;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OptionalController extends Controller
{
    public function index()
    {
        $optionals = Optional::with(['status', 'manufacturer'])->get();

        return Inertia::render('Optional/Index', ['optionals' => $optionals]);
    }

    public function create()
    {
        $manufacturers = Manufacturer::where('status_id', '=', 1)->get();

        return Inertia::render(
            'Optional/Create', ['manufacturers' => $manufacturers]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'observation' => 'nullable|string',
        ]);
        Optional::create([
            'name' => $request->name,
            'status_id' => 1,
            'observation' => $request->observation,
            'annotation' => $request->annotation,
            'price' => $request->price,
            'manufacturer_id' => $request->manufacturer_id,

        ]);
        sleep(1);

        return redirect()->route('optional.index')->with('message', 'Solução Criada Com Sucesso');
    }

    public function edit(Request $request)
    {
        $optional_id = $request->optional;
        $optional = Optional::find(['id' => $optional_id])[0];
        $manufacturers = Manufacturer::where('status_id', '=', 1)->get();

        return Inertia::render('Optional/Edit', ['optional' => $optional, 'manufacturers' => $manufacturers]);
    }

    public function update(Request $request)
    {
        $optional = Optional::find(['id' => $request->id])[0];
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $optional->name = $request->name;
        $optional->observation = $request->observation;
        $optional->annotation = $request->annotation;
        $optional->price = $request->price;
        $optional->manufacturer_id = $request->manufacturer_id;
        $optional->save();
        sleep(1);

        return redirect()->route('optional.index')->with('message', 'Solução atualizada com sucesso');

    }
}
