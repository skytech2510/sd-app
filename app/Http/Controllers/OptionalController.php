<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Optional;
use App\Models\Manufacturer;
use Inertia\Inertia;
class OptionalController extends Controller{
    public function index(){
        $optionals = Optional::with(['status', 'manufacturer'])->get();
        return Inertia::render("Optional/Index", ["optionals" => $optionals]);
    }
    public function create()
    {
        $manufacturers = Manufacturer::where("status_id", "=", 1)->get();
        return Inertia::render(
            'Optional/Create'
            , ["manufacturers"=>$manufacturers]
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'observation' => 'nullable|string'
        ]);
        Optional::create([
            'name' => $request->name,
            'status_id' => 1,
            'observation' => $request->observation,
            'annotation'=>$request->annotation,
            'price'=>$request->price,
            'manufacturer_id' => $request->manufacturer_id,

        ]);
        sleep(1);

        return redirect()->route('optional.index')->with('message', 'Solução Criada Com Sucesso');
    }
}
