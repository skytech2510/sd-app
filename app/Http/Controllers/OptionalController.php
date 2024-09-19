<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Optional;
use Inertia\Inertia;
class OptionalController extends Controller{
    public function index(){
        $optionals = Optional::with(['status', 'manufacturer'])->get();
        return Inertia::render("Optional/Index", ["optionals" => $optionals]);
    }
    public function create()
    {
        return Inertia::render(
            'Optional/Create'
        );
    }
}
