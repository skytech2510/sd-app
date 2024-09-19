<?php
namespace App\Http\Controllers;


use Inertia\Inertia;
class OptionalController extends Controller{
    public function index(){
        return Inertia::render("Optional/index");
    }
}
