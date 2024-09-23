<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Solution;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['Manufacturer', 'Solution'])->when($request->term, function ($query) use ($request) {
            $query->where('name', 'LIKE', '%'.$request->term.'%')->paginate();

        }, function ($query) {
            $query->orderBy('id')->paginate()->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
            ]);
        })->get();

        return Inertia::render(
            'Product/Index',
            [
                'products' => $products,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $manufacturers = Manufacturer::where('status_id', '=', 1)->get();
        $suppliers = Supplier::where('status_id', '=', 1)->get();
        $solutions = Solution::where('status_id', '=', 1)->get();

        return Inertia::render(
            'Product/Create',
            [
                'manufacturers' => $manufacturers,
                'suppliers' => $suppliers,
                'solutions' => $solutions,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'supplier_code' => 'required|string|max:255',
            'solution_id' => 'required|exists:solutions,id', // Assuming 'solutions' table exists
            'manufacturer_id' => 'required|exists:manufacturers,id', // Assuming 'manufacturers' table exists
            'supplier_id' => 'required|exists:suppliers,id', // Assuming 'suppliers' table exists
            'item' => 'required|string',
            'color' => 'required|string',
            'cost' => 'required|numeric|gt:0',
            'size' => 'required|string',
            'NCM' => 'required|string',
            'CFOP' => 'required|string',
            'discount' => 'required|numeric|between:0,100', // Assuming discount is a percentage
            'ST' => 'required|numeric|between:0,100', // Assuming discount is a percentage
            'IPI' => 'required|numeric|between:0,100', // Assuming discount is a percentage
            'freight' => 'required|numeric|between:0,100', // Assuming discount is a percentage
            'markup' => 'required|numeric', // Assuming discount is a percentage
            'price' => 'required|numeric', // Assuming discount is a percentage
            'observation' => 'required|string', // Assuming discount is a percentage
        ]);
        $product = new Product;
        $product->name = $request->name;
        $product->supplier_code = $request->supplier_code;
        $product->solution_id = $request->solution_id;
        $product->manufacturer_id = $request->manufacturer_id;
        $product->supplier_id = $request->supplier_id;
        $product->item = $request->item;
        $product->color = $request->color;
        $product->cost = $request->cost;
        $product->size = $request->size;
        $product->NCM = $request->NCM;
        $product->CFOP = $request->CFOP;
        $product->discount = $request->discount;
        $product->ST = $request->ST;
        $product->IPI = $request->IPI;
        $product->freight = $request->freight;
        $product->markup = $request->markup;
        $product->price = $request->price;
        $product->observation = $request->observation;
        $product->status_id = 1;
        $product->save();
        sleep(1);

        return redirect()->route('product.index')->with('message', 'Produto Criado Com Sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $product_id = $request->product;
        $product = Product::find(['id' => $product_id])[0];
        $manufacturers = Manufacturer::where('status_id', '=', 1)->get();
        $suppliers = Supplier::where('status_id', '=', 1)->get();
        $solutions = Solution::where('status_id', '=', 1)->get();

        return Inertia::render(
            'Product/Edit',
            [
                'product' => $product,
                'manufacturers' => $manufacturers,
                'suppliers' => $suppliers,
                'solutions' => $solutions,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $product = Product::find(['id' => $request->id])[0];
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $product->name = $request->name;
        $product->supplier_code = $request->supplier_code;
        $product->solution_id = $request->solution_id;
        $product->manufacturer_id = $request->manufacturer_id;
        $product->supplier_id = $request->supplier_id;
        $product->item = $request->item;
        $product->color = $request->color;
        $product->cost = $request->cost;
        $product->size = $request->size;
        $product->NCM = $request->NCM;
        $product->CFOP = $request->CFOP;
        $product->discount = $request->discount;
        $product->ST = $request->ST;
        $product->IPI = $request->IPI;
        $product->freight = $request->freight;
        $product->markup = $request->markup;
        $product->price = $request->price;
        $product->observation = $request->observation;
        $product->status_id = 1;
        $product->save();

        sleep(1);

        return redirect()->route('product.index')->with('message', 'Produto atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        sleep(1);

        return redirect()->route('product.index')->with('message', 'Produto deletado com sucesso');
    }
}
