<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier_id = Auth::user()->id;
        $supplier_products = null;
        if(Product::where('supplier_profile_id', '=', $supplier_id)->exists()){
            $supplier_products= (Product::where('supplier_profile_id', '=', $supplier_id)->get());
        }
        return view('supplier.product.index', compact('supplier_products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        
        return view('supplier.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $supplier_id = Auth::user()->fkSuplierProfile->id;

        $file = $request->file('Photo');
        // dd($file);
        $filename = $supplier_id . time() . '.' . $file->getClientOriginalExtension();
        $path = $request->file('Photo')->storeAs('public/products',$filename);
        $path = str_replace('public/','',$path);

        Product::create([
            'supplier_profile_id' => $supplier_id,
            'status_product_id' => 1,
            'product_type_id' => $request->ProductType,
            'product_name'=> $request->ProductName,
            'stock' => $request->Stock,
            'description' => $request-> Description,
            'price' => $request-> Price,
            'photo'=> $path
        ]);

        return redirect()->route('supplier.product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::find($id);
        return view('supplier.product.view',compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = Product::find($id);
        return view('supplier.product.update',compact('products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}