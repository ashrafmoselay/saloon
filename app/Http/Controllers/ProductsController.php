<?php

namespace App\Http\Controllers;

use App\Category;
use App\Combination;
use App\OrderDetail;
use App\Product;
use App\Setting;
use App\Store;
use App\Unit;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        $is_raw = (int)$request->is_raw;
        if (!$request->ajax()) {
            return view('products.indexDataTable', ['is_raw' => $is_raw]);
        } else {
            $list = Product::with(['category', 'subcategory', 'media', 'totalQuantities.unit', 'productUnit'])
                ->where('is_raw_material', $is_raw)
                ->where('is_service', false);
            if ($request->main_category_id) {
                $list = $list->where('main_category_id', $request->main_category_id);
            }
            if ($request->sub_category_id) {
                $list = $list->where('sub_category_id', $request->sub_category_id);
            }
            if ($request->keyword) {
                $list = $list->where('name', 'like', '%' . $request->keyword . '%');
            }

            //dd($request->main_category_id);
            $pageDisplayStart = $request->pageDisplayStart ?: 0;

            $datatable =  DataTables::of($list)
                ->addColumn('image', function ($product) {
                    $img = "<div class='col-md-12 col-sm-12'>";
                    if (optional($product->getFirstMedia('images'))->getUrl()) {
                        $img .= "<img class='thumb' style='width:80px;' src='" . $product->img . "'/>";
                    }
                    $img .= "</div>";
                    return $img;
                })->addColumn('category', function ($product) {
                    return optional($product->category)->name;
                })
                ->addColumn('subcategory', function ($product) {
                    return optional($product->subcategory)->name;
                })
                ->addColumn('cost', function ($product) {
                    return $product->getCost();
                })
                ->addColumn('price', function ($product) {
                    return $product->getSalePrice();
                })
                ->addColumn('quantity', function ($product) {
                    return $product->getTotalQuantity();
                })
                ->addColumn('actions', function ($product) use ($pageDisplayStart) {
                    $btn = '<a title="تعديل" href="' . route('products.edit', $product) . '?page_display_start=' . $pageDisplayStart . '" class="btn btn-primary btn-xs">
                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>

                </a>
                <a title = "حذف" class="btn btn-xs bg-red remove-record" data-url="' . route('products.destroy', $product)  . '" data-id="' . $product->id . '">
                    <i class="fa fa-trash"></i>
                </a>
                <a title="تفاصيل" href="' . route('products.show', $product) . '" class="btn btn-xs btn-warning">
                    <i class="fa fa-eye"></i>
                </a>
                <a data-toggle="modal" data-target="#myModal" title="حركة سعر الصنف" href="' . route('products.getPriceHistory', $product) . '" class="btn btn-xs btn-info">
                    <i class="fa  fa-line-chart"></i>
                </a>
                ';
                    return $btn;
                })
                ->rawColumns(['actions', 'image', 'cost', 'price', 'quantity', 'category', 'subcategory']);

            // $sumTotalCost = $list->get()->sum(function($item) {
            //     return $item->all_qty * $item->item_cost;
            // });
            $sumTotalCost = 0;
            $datatable = $datatable->with('sumPriceOne', $sumTotalCost);

            return $datatable->make(true);
        }
    }

    public function getProductsByCategory()
    {
        $category = Category::find(request('category_id'));
        $products = Product::where('main_category_id', request('category_id'))->get();
        $is_raw = 0;
        return view('products.index', compact('products', 'category', 'is_raw'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product = new Product;
        $categories = Category::get();
        $stores = auth()->user()->stores;
        $units = Unit::get();
        $is_raw = $request->is_raw;
        if ($request->ajax()) {
            return view('products.partial', compact('product', 'categories', 'stores', 'units', 'is_raw'));
        }
        return view('products.create', compact('product', 'categories', 'stores', 'units', 'is_raw'));
    }

    /**
     * Product a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->except('_token');
            $inputs['product']['price_includes_tax'] = 0; //$request->has('price_includes_tax');
            $inputs['product']['product_percent_only'] = $request->has('product_percent_only');
            $inputs['product']['first_qty'] = 0;
            $inputs['product']['is_raw_material'] = $inputs['product']['is_raw_material'] ?? 0;

            $inputs['product']['is_price_percent'] = isset($inputs['product']['is_price_percent']) ? 1 : 0;
            if ($inputs['product']['code']) {
                $search = Product::where('code', $inputs['product']['code'])->first();
                if ($search) {
                    throw new \Exception('خطأ الباركود مسجل مع صنف أخر وهو ' . $search->name);
                }
            }
            $product = Product::create($inputs['product']);
            foreach ($inputs['unit'] as $i => $v) {
                if (!$v['unit_id']) {
                    unset($inputs['unit'][$i]);
                }
            }
            if (count($inputs['unit']) == 3) {
                $inputs['unit'][3]['pieces_num'] = $inputs['unit'][2]['pieces_num'] * $inputs['unit'][3]['pieces_num'];
            }
            $product->productUnit()->attach($inputs['unit']);
            $product->productStore()->attach($inputs['store']);
            if (isset($inputs['combination'])) {
                $product->productCombination()->attach($inputs['combination']);
            }
            $product->first_qty = $product->avilable_qty;
            $product->save();
            if (isset($inputs['raw']))
                $product->rawMatrial()->attach($inputs['raw']);

            if ($request->has('image')) {
                $product->addMedia($request->file('image'))->toMediaCollection('images');
            }
            DB::commit();

            if (request()->reqType == 'ajax') {
                return $product->name;
            }
            //return redirect(route('products.index', ['is_raw' => $product->is_raw_material]));
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('alert-danger', $e->getMessage());
            dd($e->getMessage());
        }
        return back()->with('alert-success', 'تم اضافة الصنف بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //$product = $product->load('media');
        //dd($product->getFirstMedia('images'));
        //dd($product->rawMatrial);
        $categories = Category::get();
        $pcat = request('pcat');
        $display_start = request('page_display_start');
        $stores = $product->productStoreAll;
        if (!count($stores)) {
            $stores = auth()->user()->stores;
        }
        $sIds = $stores->pluck('id')->toArray();
        $additinaluserstores = [];
        if ($sIds)
            $additinaluserstores = auth()->user()->stores()->whereNotIn('store_id', $sIds)->get();
        //array_merge($stores,auth()->user()->stores);
        //$stores = Store::get();
        //dd($stores);
        //$units = $product->productUnit;
        $units = Unit::get();
        $is_raw = $product->is_raw_material;
        return view('products.edit', compact('product', 'display_start', 'pcat', 'additinaluserstores', 'categories', 'stores', 'units', 'is_raw'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {
            $page_display_start = $request->page_display_start ?: 0;
            $page = $request->page ?: 1;
            $inputs = $request->except('_token');
            $inputs['product']['price_includes_tax'] = 0; //$request->has('price_includes_tax');
            $inputs['product']['is_price_percent'] = isset($inputs['product']['is_price_percent']) ? 1 : 0;
            $inputs['product']['product_percent_only'] = $request->has('product_percent_only');
            if ($inputs['product']['code']) {
                $search = Product::where('id', '<>', $product->id)->where('code', $inputs['product']['code'])->first();
                if ($search) {
                    throw new \Exception('خطأ الباركود مسجل مع صنف أخر وهو ' . $search->name);
                }
            }
            //dd($inputs['product']);
            $product->update($inputs['product']);
            foreach ($inputs['unit'] as $i => $v) {
                if (!$v['unit_id']) {
                    unset($inputs['unit'][$i]);
                }
            }
            if (count($inputs['unit']) == 3) {
                $inputs['unit'][3]['pieces_num'] = $inputs['unit'][2]['pieces_num'] * $inputs['unit'][3]['pieces_num'];
            }
            //dd(count($inputs['unit']));
            $product->productUnit()->detach();
            //dd($inputs['unit']);
            $product->productUnit()->attach($inputs['unit']);
            //$r = $product->productUnit()->sync($inputs['unit']);
            $product->productCombination()->detach();
            if (isset($inputs['combination'])) {
                $product->productCombination()->attach($inputs['combination']);
            }
            $product->productStore()->detach();
            if (isset($inputs['raw'])) {
                //dd($inputs['raw']);
                $product->rawMatrial()->detach();
                $product->rawMatrial()->attach($inputs['raw']);
            }

            foreach ($inputs['store'] as $k => $store) {
                $inputs['store'][$k]['qty'] += $inputs['store'][$k]['sale_count'];
            }
            $product->productStore()->attach($inputs['store']);

            if ($request->has('image')) {
                $product->clearMediaCollection('images');
                $product->addMedia($request->file('image'))->toMediaCollection('images');
            }
            if (request('pcat') && $page) {
                return redirect(route('products.category', ['category_id' => request('pcat')]) . "?page=" . $page);
            }
            return redirect()->route('products.index', ['is_raw' => $product->is_raw_material])->with("page_display_start", $page_display_start);
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }
        return back()->with("page_display_start", $page_display_start);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // dd($product);
        if ($product->delete()) {
            return "done";
        }
        return "failed";
    }

    public function getProductList(Request $request)
    {
        $term = $request->get('q');
        $is_raw = (int)$request->is_raw;
        $products = Product::query();
        $products->with('media');
        $allitems = (int)$request->allitems;
        if (!$allitems) {
            $products->where('is_raw_material', $is_raw);
        }
        //dd($is_raw);

        $products = $products->where(function ($qry) use ($term) {
            $qry->orwhere('name', 'like', "%$term%")
                ->orwhere('id', 'like', "$term%")
                ->orwhere('code', 'like', "$term%")
                ->orwhere('model', 'like', "$term%");
        })
            ->with(['productStore' => function ($qry) {
                return $qry->whereIn('product_store.store_id', auth()->user()->stores_ids);
            }, 'productUnit', 'category', 'rawMatrial', 'rawMatrial.productStore', 'productCombination']);
        if ($request->category_id) {
            $products->where('main_category_id', $request->category_id);
        }
        //dd($products->first());
        $products = $products->take(100)->get();
        //dd($products);
        return $products->toArray();

        return $products;
    }

    public function getReturnsList(Request $rquest)
    {
        $term = $rquest->get('q');
        $client = $rquest->get('client_id');
        $category = $rquest->category_id;
        $settings = Setting::get()->pluck('value', 'key')->toArray();

        $products = Product::query();
        $products->select('products.*', 'order_detailes.return_qty', 'order_detailes.cost', 'order_detailes.price', DB::raw('sum(qty) as totalQty'))
            //->where('product_name','like',"%$term%")
            /*->orWhere('product_id','like',"%$term%")*/
            ->with(['category', 'productStore', 'productUnit'])
            ->take(100)
            ->where(function ($qry) use ($term) {
                $qry->where('products.name', 'like', "%$term%")
                    ->orwhere('products.id', 'like', "$term%")
                    ->orwhere('code', 'like', "$term%")
                    ->orwhere('model', 'like', "$term%");
            });
        if ($settings['show_all_products_returns'] == 1) {
            $products->join('order_detailes', function ($qry) use ($category, $term) {
                    $qry->on('products.id', '=', 'product_id');
                    if ($category) {
                        $qry->where('main_category_id', $category);
                    }
                })
                ->join('orders', function ($qry) use ($client, $settings) {
                    $qry->on('orders.id', '=', 'order_id');
                    if ($client && $settings['show_all_products_returns'] == 1) {
                        $qry->where('client_id', $client);
                    }
                });
        }else{
            $products->leftjoin('order_detailes', function ($qry) use ($category, $term) {
                $qry->on('products.id', '=', 'product_id');
                if ($category) {
                    $qry->where('main_category_id', $category);
                }
            })
            ->leftjoin('orders', function ($qry) use ($client, $settings) {
                $qry->on('orders.id', '=', 'order_id');
                if ($client && $settings['show_all_products_returns'] == 1) {
                    $qry->where('client_id', $client);
                }
            });
        }
        $products = $products->groupBy('products.id')->get();
        return $products;
    }
    public function getCriticalQuantity(Request $rquest)
    {
        $products = Product::query()
            ->select(DB::raw('products.*,(select sum(qty-sale_count) from product_store where product_store.product_id = products.id) as totalQty'))
            ->havingRaw('totalQty <= products.observe')
            ->groupBy('products.id')
            ->get();
        //dd($products);
        return view('products.criticalQty', compact('products'));
    }
    public function priceList()
    {
        return view('products.price_list');
    }
    public function priceList2()
    {
        return view('products.price_list2');
    }

    public function generateBarCode(Request $request)
    {
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        //$product = Product::find(1);
        //return view('products.barcode5x2',compact('generator','product'));
        //$list = Product::whereNotNull('code')->get();
        if ($request->prodId) {
            $copies = $request->copies;
            $product = Product::find($request->prodId);
            $from = $request->from;
            $size = $request->size;
            $barcodetype = $request->barcodetype;
            $margin_left = $request->margin_left;
            $margin_top = $request->margin_top;
            $width = $request->width;
            $height = $request->height;
            $data = compact('generator', 'product', 'copies', 'barcodetype', 'margin_top', 'margin_left', 'width', 'height');
            return view('products.barcode4x2', $data);
            if ($size == 'a4x11') {
                return view('products.copies', $data);
            } else {
                return view('products.barcode4x2', $data);
            }
        } else {
            return view('products.barcode');
        }
    }
    public function getProductBarcode(Product $product)
    {
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        return view('products.product_barcode', compact('generator', 'product'));
    }


    public function getReport(Request $request)
    {
        /*if(!$request->ajax()){
            return view('products.report');
        }*/
        $is_service = (int)request()->is_service;
        $condition = '';
        $condition2 = '';
        if ($request->fromdate && $request->todate) {
            $condition = " and DATE(orders.created_at) >= '{$request->fromdate}' " . " and DATE(orders.created_at) <= '{$request->todate}' ";
            $condition2 = " and DATE(returns.created_at) >= '{$request->fromdate}' " . " and DATE(returns.created_at) <= '{$request->todate}' ";
        } elseif ($request->fromdate) {
            $condition = " and DATE(orders.created_at) >= '{$request->fromdate}' ";
            $condition2 = " and DATE(returns.created_at) >= '{$request->fromdate}' ";
        } elseif ($request->todate) {
            $condition = " and  DATE(orders.created_at) <= '{$request->todate}' ";
            $condition2 = " and  DATE(returns.created_at) <= '{$request->todate}' ";
        }

        $products = Product::query()
            ->select('products.id', 'products.name', 'products.observe')
            ->selectRaw("(SELECT SUM(qty) FROM order_detailes join orders on order_id = orders.id and orders.invoice_type = 'sales' and orders.deleted_at IS NULL    WHERE product_id = products.id {$condition}  GROUP BY product_id) AS salesQty")
            ->selectRaw("(SELECT SUM(qty) FROM order_detailes join orders on order_id = orders.id and orders.invoice_type = 'purchase' and orders.deleted_at IS NULL  WHERE product_id = products.id {$condition}  GROUP BY product_id) AS purchaseQty")
            ->selectRaw("(SELECT SUM(qty) FROM return_detailes join returns on return_id = returns.id and returns.return_type = 'sales' and returns.deleted_at IS NULL WHERE product_id = products.id {$condition2} GROUP BY product_id) AS orderReturnQty")
            ->selectRaw("(SELECT SUM(qty) FROM return_detailes join returns on return_id = returns.id and returns.return_type = 'purchase' and returns.deleted_at IS NULL WHERE product_id = products.id {$condition2} GROUP BY product_id) AS purchasReturnsQty")
            ->where('is_service', $is_service)
            ->havingRaw('(salesQty IS NOT NULL OR purchaseQty IS NOT NULL OR purchasReturnsQty IS NOT NULL OR orderReturnQty IS NOT NULL)')
            ->orderBy('salesQty', 'DESC')
            ->groupBy('products.id')
            ->get();
        /*return DataTables::of($products)
            ->addColumn('name',function($product){
                dd($product->name);
                return $product->name;
            })
            ->addColumn('purchaseQty',function($product){
                return $product->purchaseQty;
            })
            ->addColumn('purchasReturnsQty',function($product){
                return $product->purchasReturnsQty;
            })
            ->addColumn('salesQty',function($product){
                return $product->salesQty;
            })
            ->addColumn('orderReturnQty',function($product){
                return $product->orderReturnQty;
            })
            ->addColumn('observe',function($product){
                return $product->observe;
            })
            ->addColumn('getTotalQuantity',function($product){
                return $product->getTotalQuantity;
            })
            ->rawColumns(['getTotalQuantity'])
            ->make(true);*/

        return view('products.report', compact('products'));
    }
    public function getPriceHistory(Product $product)
    {

        $firstPrice =  $product->purchases()->orderBy('id', 'asc')->first();
        $lastPrice =  $product->purchases()->orderBy('id', 'desc')->first();
        $maxPrice =  $product->purchases()->orderBy('price', 'desc')->first();
        $minPrice =  $product->purchases()->orderBy('price', 'asc')->first();

        return view('products.price_movement', compact('product', 'firstPrice', 'lastPrice', 'maxPrice', 'minPrice'));
    }

    public function regionsReport(Request $request)
    {
        $condition = '';
        $data = OrderDetail::query();
        if ($request->fromdate && $request->todate) {
            $condition = "DATE(orders.created_at) >= '{$request->fromdate}' " . " and DATE(orders.created_at) <= '{$request->todate}' ";
        } elseif ($request->fromdate) {
            $condition = "DATE(orders.created_at) >= '{$request->fromdate}' ";
        } elseif ($request->todate) {
            $condition = "DATE(orders.created_at) <= '{$request->todate}' ";
        }
        if ($condition) {
            $data->whereRaw($condition);
        }
        $data = $data->join('orders', function ($qry) {
            $qry->on('orders.id', '=', 'order_id');
            $qry->where('invoice_type', 'sales');
            $qry->whereNull('orders.deleted_at');
        })->join('persons', function ($qry) {
            $qry->on('persons.id', '=', 'client_id');
            $qry->whereNull('persons.deleted_at');
        })->join('regions', function ($qry) {
            $qry->on('regions.id', '=', 'region_id');
            $qry->whereNull('regions.deleted_at');
        })->groupBy('product_id', 'region_id')
            ->orderBy('totalSales', 'DESC')
            ->select(DB::raw('regions.name,order_detailes.product_name,SUM(qty) as totalSales'))
            ->get();
        //dd($report);
        return view('products.region_report', compact('data'));
    }

    public function addCombination(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $shipment_id = $request->shipment_id;
            Combination::query();
            return back()->with('alert-success', 'تم إضافة اللون بنجاح');
        }
        return view('shipments.transfer', compact('prodid'));
    }
}
