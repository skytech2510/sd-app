<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::with('City', 'State')->where('status_id', '=', 1)->get();

        return Inertia::render(
            'Supplier/Index',
            [
                'suppliers' => $suppliers,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = Cidade::orderBy('nome')->get();
        $states = Estado::orderBy('nome')->get();

        return Inertia::render(
            'Supplier/Create',
            [
                'cities' => $cities,
                'states' => $states,
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
            'fantasy_name' => 'required|string|max:128',
            'document' => 'required|string|max:19',
            'ie' => 'required|string|max:12',
            'zip_code' => 'required|string|max:9',
            'address' => 'required|string|max:128',
            'number_address' => 'required|string|max:24',
            'complement_address' => 'required|string|max:12',
            'region' => 'required|string|max:64',
            'city_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'accountable_name' => 'required|string|max:64',
            'phone' => 'required|string|max:15',
            'cellphone' => 'required|string|max:15',
            'email' => 'required|string|max:64',
            'site' => 'required|string|max:64',
        ]);

        Supplier::create([
            'name' => $request->name,
            'fantasy_name' => $request->fantasy_name,
            'document' => $request->document,
            'ie' => $request->ie,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'number_address' => $request->number_address,
            'complement_address' => $request->complement_address,
            'region' => $request->region,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'accountable_name' => $request->accountable_name,
            'phone' => $request->phone,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'site' => $request->site,

            'status_id' => 1,
            'company_id' => Auth::user()->company_id,
        ]);

        sleep(1);

        return redirect()->route('supplier.index')->with('message', 'Fornecedor Criado Com Sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $cities = Cidade::orderBy('nome')->get();
        $states = Estado::orderBy('nome')->get();

        return Inertia::render(
            'Supplier/Edit',
            [
                'supplier' => $supplier,
                'cities' => $cities,
                'states' => $states,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:128',
            'fantasy_name' => 'required|string|max:128',
            'document' => 'required|string|max:19',
            'ie' => 'required|string|max:12',
            'zip_code' => 'required|string|max:9',
            'address' => 'required|string|max:128',
            'number_address' => 'required|string|max:24',
            'complement_address' => 'required|string|max:12',
            'region' => 'required|string|max:64',
            'city_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'accountable_name' => 'required|string|max:64',
            'phone' => 'required|string|max:15',
            'cellphone' => 'required|string|max:15',
            'email' => 'required|string|max:64',
            'site' => 'required|string|max:64',
        ]);

        $supplier->name = $request->name;
        $supplier->fantasy_name = $request->fantasy_name;
        $supplier->document = $request->document;
        $supplier->ie = $request->ie;
        $supplier->zip_code = $request->zip_code;
        $supplier->address = $request->address;
        $supplier->number_address = $request->number_address;
        $supplier->complement_address = $request->complement_address;
        $supplier->region = $request->region;
        $supplier->city_id = $request->city_id;
        $supplier->state_id = $request->state_id;
        $supplier->accountable_name = $request->accountable_name;
        $supplier->phone = $request->phone;
        $supplier->cellphone = $request->cellphone;
        $supplier->email = $request->email;
        $supplier->site = $request->site;
        $supplier->save();

        sleep(1);

        return redirect()->route('supplier.index')->with('message', 'Fornecedor atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->status_id = 3;
        $supplier->save();
        sleep(1);

        return redirect()->route('supplier.index')->with('message', 'Fornecedor excluído com sucesso');
    }
}
