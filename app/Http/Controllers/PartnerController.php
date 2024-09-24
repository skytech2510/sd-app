<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Partner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PartnerController extends Controller
{
    //

    public function index(Request $request)
    {
        $partners = Partner::when($request->term, function ($query) use ($request) {
            $query->where('name', 'LIKE', '%'.$request->term.'%')->paginate();
        }, function ($query) {
            $query->orderBy('id')->paginate();
        })->get();

        return Inertia::render('Partner/Index', []);
    }

    public function create()
    {
        $cities = Cidade::get();
        $states = Estado::get();

        return Inertia::render('Partner/Create', ['cities' => $cities, 'states' => $states]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'CPF' => 'required|string|regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/',
            'birthday' => 'required|string',
            'gender' => 'required|string',
            'CEP' => 'required|string|regex:/^\d{5}\-\d{3}$/',
            'address' => 'required|string',
            'number_address' => 'required|integer',
            'complement_address' => 'required|string',
            'region' => 'required|string',
            'city_id' => 'required|exists:cidades,id',
            'state_id' => 'required|exists:estados,id',
            'accountable_name' => 'required|string',
            'phone' => 'required|regex:/^\(\d{2}\)\d{5}-\d{4}$/',
            'cellphone' => 'required|string',
            'email' => [
                'required', // Make the email field required
                'email', // Check for valid email format
                'unique:partners,email', // Ensure the email is unique in the partners table
            ],
            'site' => 'required|string',
            'social_network' => 'required|string',
            'bank' => 'required|string',
            'agency' => 'required|string',
            'account_number' => 'required|string',
            'pix_key' => 'required|string',
            'consultant' => 'required|string',
        ]);
        Partner::create([
            'name' => $request->name,
            'type' => $request->type,
            'CPF' => $request->CPF,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'CEP' => $request->CEP,
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
            'social_network' => $request->social_network,
            'bank' => $request->bank,
            'agency' => $request->agency,
            'account_number' => $request->account_number,
            'pix_key' => $request->pix_key,
            'consultant' => $request->consultant,
        ]);
        sleep(1);
        redirect()->route('partner.index')->with('message', 'Solução Criada Com Sucesso');
    }

    public function edit(Request $request)
    {
        $partner_id = $request->especificadores;
    }
}
