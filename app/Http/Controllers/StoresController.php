<?php
namespace App\Http\Controllers;

use App\ProductStore;
use App\ProductUnit;
use App\Store;
use Illuminate\Http\Request;
use DB;

class StoresController extends Controller
{

    public function index()
    {
        $stores = Store::query()->paginate(20);
        return view('stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $store = new Store;
        return view('stores.create', compact('store'));
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
        $row = Store::create($inputs);
        auth()->user()->stores()->attach([$row->id]);
        if ($request->ajax()) {
            $stores = Store::get();
            return view('stores.dropdown', compact('stores'));
        }
        return redirect(route('stores.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = Store::findOrFail($id);

        $list = $store->products()->join('products', function ($join) {
            $join->on('products.id', '=', 'product_id');
            $join->whereNull('deleted_at');
        })->whereRaw('qty-sale_count>0');
        $count = $list->count();
        if ($count > 500) {
            $list = $list->paginate(100);
        } else {
            $list = $list->paginate($count);
        }
        return view('stores.show', compact('store', 'list'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        return view('stores.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        $inputs = $request->except('_token');
        $store->update($inputs);
        return redirect(route('stores.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        if ($store->delete()) {
            return "done";
        }
        return "failed";
    }


}