<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Manufacturer;
use App\Models\Optional;
use App\Models\Solution;
use App\Models\Standard;
use App\Models\Trigger;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StandardController extends Controller
{
    public function index(Request $request)
    {
        $manufacturers = Manufacturer::where('status_id', '=', 1)->get();
        $solutions = Solution::where('status_id', '=', 1)->get();
        $standards = Optional::when($request->term, function ($query) use ($request) {
            $query->where('name', 'LIKE', '%'.$request->term.'%')->paginate();

        }, function ($query) {
            $query->orderBy('id')->paginate();
        })->get();

        return Inertia::render('Standard/Index',
            [
                'solutions' => $solutions,
                'manufacturers' => $manufacturers,
                'standards' => $standards,
            ]);
    }

    public function create()
    {
        $manufacturers = Manufacturer::where('status_id', '=', 1)->get();
        $solutions = Solution::where('status_id', '=', 1)->get();
        $collections = [];
        $optionals = Optional::where('status_id', '=', 1)->get();
        $triggers = Trigger::where('status_id', '=', 1)->get();

        return Inertia::render('Standard/Create',
            [
                'manufacturers' => $manufacturers,
                'solutions' => $solutions,
                'collections' => $collections,
                'optionals' => $optionals,
                'triggers' => $triggers,
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'solution_id' => 'required|exists:solutions,id',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'collection_ids' => 'required|array',
            'collection_ids.*' => 'exists:collections,id',
            'NCM' => 'required|string',
            'CFOP' => 'required|string',
        ]);
        $standard = new Standard;
        $standard->name = $request->name;
        $standard->solution_id = $request->solution_id;
        $standard->manufacturer_id = $request->manufacturer_id;
        $standard->collection_ids = json_encode($request->collection_ids);
        $standard->colors = json_encode($request->colors);
        $standard->NCM = $request->NCM;
        $standard->CFOP = $request->CFOP;
        $standard->min_width = $request->min_width;
        $standard->max_width = $request->max_width;
        $standard->min_height = $request->min_height;
        $standard->max_height = $request->max_height;
        $standard->product_feature = $request->product_feature;
        $standard->status_id = 1;
        if ($request->solution_id == 1) {
            $standard->supplies = json_encode($request->supplies);
        } elseif ($request->solution_id == 2) {
            $standard->drives = json_encode($request->drives);
            $standard->optionals = json_encode($request->optionals);
        }
        $standard->save();

        return redirect()->route('standard.index')->with('message', 'Solução Criada Com Sucesso');

    }

    public function edit(Request $request)
    {
        $standard_id = $request->standard;
        $standard = Standard::find($standard_id);
        $manufacturers = Manufacturer::where('status_id', '=', 1)->get();
        $solutions = Solution::where('status_id', '=', 1)->get();
        $collections = Collection::where('status_id', '=', 1)->where('solution_id', '=', $solution_id)->get();
        $optionals = Optional::where('status_id', '=', 1)->get();
        $triggers = Trigger::where('status_id', '=', 1)->get();

        return Inertia::render('Standard/Edit', [
            'standard' => $standard,
            'manufacturers' => $manufacturers,
            'solutions' => $solutions,
            'collections' => $collections,
            'optionals' => $optionals,
            'triggers' => $triggers,
        ]);
    }

    public function getCollections(Request $request)
    {
        $solution_id = $request->solution_id;
        $collections = Collection::where('status_id', '=', 1)->where('solution_id', '=', $solution_id)->get();

        return json_encode($collections);
    }
}
