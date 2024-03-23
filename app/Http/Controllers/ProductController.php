<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\MajorCategory;
// use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        if ($request->category !== null) {
            $products = Product::where('category_id', $request->category)->sortable()->paginate(15);
            $total_count = Product::where('category_id', $request->category)->count();
            $category = Category::find($request->category);
            $major_category = MajorCategory::find($category->major_category_id);
        } elseif ($keyword !== null) {
            $products = Product::where('name', 'like', "%{$keyword}%")->sortable()->paginate(15);
            $total_count = $products->total();
            $category = null;
            $major_category = null;
        } else {
            $products = Product::sortable()->paginate(15);
            $total_count = "";
            $category = null;
            $major_category = null;
        }
        $categories = Category::all();
        $major_categories = MajorCategory::all();

        // $reviews = Review::all();
        // foreach ($products as $product) {
        //     $reviews = $product->reviews()->get();
        //     $score = $reviews->pluck("score")->toArray();
        //     $score_average = 0;
        //     if (count($score) > 0) {
        //         $score_average = array_sum($score) / count($score) ;
        //     }
        // }
 
        return view('products.index', compact('products', 'category', 'major_category', 'categories', 'major_categories', 'total_count', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
  
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->save();

        return to_route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $reviews = $product->reviews()->get();
  
        $score = $reviews->pluck("score")->toArray();
        $score_average = 0;
        if (count($score) > 0) {
            $score_average = array_sum($score) / count($score) ;
        }

        return view('products.show', compact('product', 'reviews', 'score_average', 'score'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
  
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->update();

        return to_route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
  
        return to_route('products.index');
    }
}
