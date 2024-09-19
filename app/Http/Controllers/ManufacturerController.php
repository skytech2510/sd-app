<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manufactures = Manufacturer::where('status_id', '=', 1)->get();
        return Inertia::render(
            'Manufacturer/Index',
            [
                'manufacturers' => $manufactures
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Manufacturer/Create',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $user = Auth::user();

        Manufacturer::create([
            'name' => $request->name,
            'status_id' => 1,
            'company_id' => $user->company_id,
        ]);

        sleep(1);
        return redirect()->route('manufacturer.index')->with('message', 'Fabricante Criado Com Sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manufacturer $manufacturer)
    {

        return Inertia::render(
            'Manufacturer/Edit',
            [
                'manufacturer' => $manufacturer
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        
        $manufacturer->name = $request->name;
        $manufacturer->save();
        sleep(1);

        return redirect()->route('manufacturer.index')->with('message', 'Fabricante atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->status_id = 3;
        $manufacturer->save();
        sleep(1);

        return redirect()->route('manufacturer.index')->with('message', 'Fabricante excluído com sucesso');
    }
}
