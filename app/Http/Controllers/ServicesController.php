<?php
namespace App\Http\Controllers;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ServicesController extends Controller
{

    public function index()
    {
        $services = Product::where('is_service',true)->latest()->get();
        return view('services.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $service = new Product;
        $categories = Category::get();
        return view('services.create',compact('service','categories'));
    }

    /**
     * Product a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        Product::create($inputs);
        return back()->with('alert-success', 'تمت الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($clientId,$id)
    {
        $service = Product::findOrFail($id);
        return view('services.show',compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Product::findOrFail($id);
        $categories = Category::get();
        return view('services.edit',compact('service','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $service = Product::findOrFail($id);
        $inputs = $request->except('_token');
        $service->update($inputs);
        return back()->with('alert-success', 'تم التعديل بنجاح');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Product::findOrFail($id);
        if($service->delete()){
            return "done";
        }
        return "failed";
    }


}
