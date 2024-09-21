<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Client;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::with('City', 'State')->where('status_id', '=', 1)->get();

        return Inertia::render(
            'Client/Index',
            [
                'clients' => $clients
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
            'Client/Create',
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
            'spouse' => 'required|string|max:128',
            'person_type' => 'required|numeric',
            'document' => 'required|string',
            'extra_document' => 'required|string',
            'birth_date' => 'required|string',
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'zip_code' => 'required|string',
            'address' => 'required|string|max:128',
            'number_address' => 'required|string|max:24',
            'complement_address' => 'required|string|max:12',
            'extra_address' => 'required|string|max:64',
            'region' => 'required|string|max:64',
            'city_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'accountable_name' => 'required|string|max:64',
            'phone' => 'required|string',
            'cellphone' => 'required|string',
            'email' => 'required|string|max:64',
            'site' => 'required|string|max:64',
            'social_network' => 'required|string|max:64',
        ]);

        Client::create([
            'name' => $request->name,
            'spouse' => $request->spouse,
            'person_type' => $request->person_type,
            'document' => $request->document,
            'extra_document' => $request->extra_document,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'number_address' => $request->number_address,
            'complement_address' => $request->complement_address,
            'extra_address' => $request->extra_address,
            'region' => $request->region,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'accountable_name' => $request->accountable_name,
            'phone' => $request->phone,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'site' => $request->site,
            'social_network' => $request->social_network,

            'status_id' => 1,
            'company_id' => Auth::user()->company_id
        ]);

        sleep(1);
        return redirect()->route('client.index')->with('message', 'Cliente criado Com Sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $cities = Cidade::orderBy('nome')->get();
        $states = Estado::orderBy('nome')->get();

        return Inertia::render(
            'Client/Edit',
            [
                'client' => $client,
                'cities' => $cities,
                'states' => $states,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:128',
            'spouse' => 'required|string|max:128',
            'person_type' => 'required|numeric',
            'document' => 'required|string',
            'extra_document' => 'required|string',
            'birth_date' => 'required|string',
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'zip_code' => 'required|string',
            'address' => 'required|string|max:128',
            'number_address' => 'required|string|max:24',
            'complement_address' => 'required|string|max:12',
            'extra_address' => 'required|string|max:64',
            'region' => 'required|string|max:64',
            'city_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'accountable_name' => 'required|string|max:64',
            'phone' => 'required|string',
            'cellphone' => 'required|string',
            'email' => 'required|string|max:64',
            'site' => 'required|string|max:64',
            'social_network' => 'required|string|max:64',
        ]);

        $client->name = $request->name;
        $client->spouse = $request->spouse;
        $client->person_type = $request->person_type;
        $client->document = $request->document;
        $client->extra_document = $request->extra_document;
        $client->birth_date = $request->birth_date;
        $client->gender = $request->gender;
        $client->marital_status = $request->marital_status;
        $client->zip_code = $request->zip_code;
        $client->address = $request->address;
        $client->number_address = $request->number_address;
        $client->complement_address = $request->complement_address;
        $client->extra_address = $request->extra_address;
        $client->region = $request->region;
        $client->city_id = $request->city_id;
        $client->state_id = $request->state_id;
        $client->accountable_name = $request->accountable_name;
        $client->phone = $request->phone;
        $client->cellphone = $request->cellphone;
        $client->email = $request->email;
        $client->site = $request->site;
        $client->social_network = $request->social_network;
        
        $client->save();

        sleep(1);
        return redirect()->route('client.index')->with('message', 'Cliente atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->status_id = 3;
        $client->save();

        sleep(1);
        return redirect()->route('client.index')->with('message', 'Cliente excluído com sucesso');
    }
}
