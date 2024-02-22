<?php
namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::get();
        $pageDisplayStart = request()->pageDisplayStart?:0;
        return view('categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category;
        return view('categories.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        Category::firstOrCreate(['name'=>$inputs['name']],$inputs);
        if($request->ajax()){
            $categories = Category::where('type',1)->latest()->get();
            return view('categories.dropdown',compact('categories'));
        }

        return redirect(route('category.index'))->with('alert-success', trans('front.Successfully added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $inputs = $request->except('_token');
        $category->update($inputs);
        if(!is_null($category->percentage)){
            $products = $category->products()
                ->where('is_price_percent',1)
                ->where('product_percent_only',0)
                ->get();

            foreach ($products as $prod){
                $units = $prod->productUnit;
                $prod->price_percent = $category->percentage;
                $prod->save();
                foreach ($units as $u){
                    $cost = $u->cost_price;
                    $price = $cost + ($cost*($category->percentage/100));
                    $gomla_price = $cost + ($cost*($category->percentage2/100));
                    $gomla_gomla_price = $cost + ($cost*($category->percentage3/100));
                    $half_percentage = $cost + ($cost*($category->half_percentage/100));

                    $u->pivot->sale_price = round($price,2);
                    $u->pivot->gomla_price = round($gomla_price,2);
                    $u->pivot->gomla_gomla_price = round($gomla_gomla_price,2);
                    $u->pivot->half_gomla_price = round($half_percentage,2);
                    $u->pivot->save();
                }
            }
        }

        return redirect(route('category.index'))->with('alert-success', trans('front.Modified successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->delete()){
            return "done";
        }
        return "failed";

    }


}
