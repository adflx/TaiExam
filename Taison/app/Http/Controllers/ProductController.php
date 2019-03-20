<?php

namespace App\Http\Controllers;

use App\Product as Product;
use Darryldecode\Cart\CartCondition;
use Illuminate\Support\Facades\DB;
use \Validator;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	 
	 
    public function index()
    {
        $products = Product::latest()->paginate(5);
  
        return view('products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
		$validator = Validator::make($request->all() , [
    'name' => 'required',
    'price' => 'required',
    'quantity' => 'required',
    'size' => 'required',
    'code' =>'required|max:4|unique:products',
]);
  
		if ($validator->fails()) {
    return redirect()->route('products.create')
                        ->withErrors($validator)
                        ->withInput();
	}
	
		Product::create($request->all());
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
	
  
     
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'size' => 'required',
            'code' => 'required|unique:code',
        ]);
  
        $product->update($request->all());
  
        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
  
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
	
	public function cartAdd(Request $request){
	//	echo $product;
		$id = $request->id;
		$product = Product::select('*')->where('id','=',$id)->get();
		//var_dump($product);
		$userId = 1;
		$id = $product['id'];
        $name = $product['name'];
        $price = $product['price'];
        $qty = $product['quantity'];
        $customAttributes = [
            'size' => $product['size'],
            'code' => $product['code']
        ];
		
		
       $item = \Cart::session($userId)->add($id, $name, $price, $qty, $customAttributes);
		
		   return response(array(
            'success' => true,
            'data' => $item,
            'message' => "item added."
       ),201,[]);
		
		//\Cart::session($userId)->add($product->id,$product->name,$product->price,$product->quantity,array($product->size,$product->code));
		//\Cart::add($product->id,$product->name,$product->price,$product->quantity,array($product->size,$product->code));
		//redirect()->route('products.index') ->with('success','Product added to cart');
	}
	
}
