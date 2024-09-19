<?php

namespace App\Http\Controllers;

use App\Models\Solution;
use Illuminate\Http\Request;
use Inertia\Inertia;


class SolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $solutions = Solution::where('status_id','=',1)->get();

        return Inertia::render(
            'Solution/Index',
            [
                'solutions' => $solutions
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Solution/Create'
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

        Solution::create([
            'name' => $request->name,
            'status_id' => 1,
        ]);
        sleep(1);

        return redirect()->route('solution.index')->with('message', 'Solução Criada Com Sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Solution $solution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solution $solution)
    {
        return Inertia::render(
            'Solution/Edit',
            [
                'solution' => $solution
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solution $solution)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $solution->name = $request->name;
        $solution->save();
        sleep(1);

        return redirect()->route('solution.index')->with('message', 'Solução atualizada com sucesso');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solution $solution)
    {
        //
    }
}
