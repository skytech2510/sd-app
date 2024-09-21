<?php

namespace App\Http\Controllers;

use App\Models\Trigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TriggerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $triggers = Trigger::where('status_id', '=', 1)->get();

        return Inertia::render(
            'Trigger/Index',
            [
                'triggers' => $triggers
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Trigger/Create',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:128',
        ]);

        Trigger::create([
            'name' => $request->name,
            'status_id' => 1,
            'company_id' => Auth::user()->company_id
        ]);

        sleep(1);
        return redirect()->route('trigger.index')->with('message', 'Acionamento criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trigger $trigger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trigger $trigger)
    {
        return Inertia::render(
            'Trigger/Edit',
            [
                'trigger' => $trigger,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trigger $trigger)
    {
        $request->validate([
            'name' => 'required|string|max:128',
        ]);

        $trigger->name = $request->name;
        $trigger->save();

        sleep(1);
        return redirect()->route('trigger.index')->with('message', 'Acionamento atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trigger $trigger)
    {
        $trigger->status_id = 3;
        $trigger->save();

        sleep(1);
        return redirect()->route('trigger.index')->with('message', 'Acionamento excluído com sucesso');
    }
}
