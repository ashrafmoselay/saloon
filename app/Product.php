<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Product extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, LogsActivity;
    protected $table = 'products';
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $fillable = [
        'name','description','code',
        'model','main_category_id','observe',
        'sub_category_id','avg_cost','last_cost','is_raw_material',
        'note','first_qty','is_price_percent','price_percent','is_service',
        'gomla_price_percent','product_percent_only','price_includes_tax'
    ];

    protected static $logAttributes = [
        'name','description','code',
        'model','main_category_id','observe',
        'sub_category_id', 'note'
    ];
    protected $appends = array('full_name','cost_price','sale_price','half_gomla_price','gomla_price','gomla_gomla_price','img','customer_price');

    public function tapActivity(\Spatie\Activitylog\Contracts\Activity $activity)
    {
        $activity->properties = $activity->properties->merge([
            'custom_prop' => 'value of custom property',
        ]);
    }
    public function getCostPriceAttribute()
    {
        $price =  $this->pivot->cost_price??0;
        return currency($price,currency()->config('default'), currency()->getUserCurrency(), $format = false);
    }
    public function getImgAttribute()
    {
       return optional($this->getFirstMedia('images'))->getUrl();
    }
    public function getSalePriceAttribute()
    {
        $price =  $this->pivot->sale_price??0;
        return currency($price,currency()->config('default'), currency()->getUserCurrency(), $format = false);
    }

    public function getHalfGomlaPriceAttribute()
    {
        $price =  $this->pivot->half_gomla_price??0;
        return currency($price,currency()->config('default'), currency()->getUserCurrency(), $format = false);
    }
    public function getGomlaPriceAttribute()
    {
        $price =  $this->pivot->gomla_price??0;
        return currency($price,currency()->config('default'), currency()->getUserCurrency(), $format = false);
    }
    public function getGomlaGomlaPriceAttribute()
    {
        $price =  $this->pivot->gomla_gomla_price??0;
        return currency($price,currency()->config('default'), currency()->getUserCurrency(), $format = false);
    }

    public function getCustomerPriceAttribute()
    {
        return $this->pivot->customer_price??0;
    }

    public function getFullNameAttribute()
    {
        return $this->name;
        $fullname = optional($this->pivot)->unit_name." ".$this->name." ".optional($this->category)->name;
        return $fullname;
    }


    public function rawMatrial(){
        return $this->belongsToMany(Product::class,'product_raw_materials','product_id','raw_material_id')
            ->withPivot(['qty','color_number','raw_unit_id','raw_unit_text'])
            ->withTimestamps();

    }
    public function category(){
        return $this->belongsTo(Category::class,'main_category_id','id');
    }
    public function subcategory(){
        return $this->belongsTo(Category::class,'sub_category_id','id');
    }

    public function orders(){
        return $this->hasManyThrough(OrderDetail::class,Product::class,'id','product_id')
            ->join('orders',function($qry){
                $qry->on('orders.id','=','order_id');
                $qry->whereNull('orders.deleted_at');
                $qry->where('invoice_type','sales');
            });

    }
    public function workorder(){
        return $this->hasMany(WorkOrder::class,'product_id','id');

    }
    public function shipments(){
        return $this->hasMany(ShipmentDetailes::class,'product_id','id');
    }
    public function getproductProfitAttribute(){
        $totalReturn = $this->ordersreturn()->sum(DB::raw("qty * (price-cost)"));
        $totalOrder = $this->orders()->sum(DB::raw("qty * (price-cost)"));
        return $totalOrder-$totalReturn;
    }
    public function purchases(){
        return $this->hasManyThrough(OrderDetail::class,Product::class,'id','product_id')
            ->join('orders',function($qry){
                $qry->on('orders.id','=','order_id');
                $qry->whereNull('orders.deleted_at');
                $qry->where('invoice_type','purchase');
            });

    }
    public function ordersreturn(){
        return $this->hasManyThrough(ReturnDetail::class,Product::class,'id','product_id')
            ->join('returns',function($qry){
                $qry->on('returns.id','=','return_id');
                $qry->whereNull('returns.deleted_at');
                $qry->where('return_type','sales');
            });

    }
    public function purchasesreturn(){
        return $this->hasManyThrough(ReturnDetail::class,Product::class,'id','product_id')
            ->join('returns',function($qry){
                $qry->on('returns.id','=','return_id');
                $qry->whereNull('returns.deleted_at');
                $qry->where('return_type','purchase');
            });

    }

    public function productStore(){
        return $this->belongsToMany(Store::class,'product_store','product_id','store_id')
            ->withPivot(['unit_id','qty','sale_count'])
            ->whereIn('store_id',auth()->user()->stores_ids)
            ->withTimestamps();
    }
    public function productStoreAll(){
        return $this->belongsToMany(Store::class,'product_store','product_id','store_id')
            ->withPivot(['unit_id','qty','sale_count'])
            ->withTimestamps();
    }
    public function productUnit(){
        return $this->belongsToMany(Unit::class,'product_unit','product_id','unit_id')
            ->withPivot(['pieces_num','cost_price','sale_price','half_gomla_price',
                'gomla_price','gomla_gomla_price','customer_price'])
            ->withTimestamps()
            ->using(ProductUnit::class);
    }
    public function productCombination(){
        return $this->belongsToMany(Combination::class,'product_combinations','product_id','combination_id')
            ->withPivot(['qty','sale_counter','store_id'])
            ->withTimestamps();
    }

    public function totalQuantities(){
        return $this->hasMany(ProductStore::class)
            ->whereIn('product_store.store_id',auth()->user()->stores_ids)
            ->selectRaw('product_id, unit_id, SUM(qty-sale_count) as total')
            ->groupBy('product_id', 'unit_id');
    }
    public function getAvilableQtyAttribute(){
        return $this->productStore()->sum(DB::raw('qty-sale_count'));
    }


    public function getQuantityByunit(){
        $qty = "";
        $allqty = [];
        foreach ($this->productStore()->get() as $key => $store) {
            $unit = Unit::find($store->pivot->unit_id);
            $unitName = $unit->name??'تم حذفها' . $store->pivot->unit_id;
            if(isset($allqty[$unitName])){
                $allqty[$unitName] += ($store->pivot->qty-$store->pivot->sale_count);
            }else{
                $itemqty = $store->pivot->qty?:0;
                $salcount = $store->pivot->sale_count?:0;
                $allqty[$unitName] = ($itemqty-$salcount);
            }
        }
        foreach ($allqty as $key=>$value){
            $qty = round($value,2);
        }

        if(is_null($qty)){
            $qty = 0;
        }
        return $qty;
    }
    public function getItemCostAttribute(){
        $cost = 0;
        foreach ($this->productUnit as $unit){
            if((double)$unit->pivot->cost_price)
                $cost = $unit->pivot->cost_price;
        }
        return $cost;
    }
    public function getAllQtyAttribute(){
        $qty = 0;
        foreach ($this->productStore()->get() as $key => $store) {
            $unit = Unit::find($store->pivot->unit_id);
            $unitName = $unit->name??'تم حذفها' . $store->pivot->unit_id;
            if(isset($allqty[$unitName])){
                $allqty[$unitName] += ($store->pivot->qty-$store->pivot->sale_count);
            }else{
                $itemqty = $store->pivot->qty?:0;
                $salcount = $store->pivot->sale_count?:0;
                $allqty[$unitName] = ($itemqty-$salcount);
            }
        }
        foreach ($allqty as $key=>$value){
            $qty += $value;
        }
        return $qty;
    }
    public function getTotalQuantity(){
        $qty = "";
        $allqty = [];

        $settings = Setting::get()->pluck('value','key')->toArray();
        if(isset($settings['use_color_size_qty']) && $settings['use_color_size_qty']==1){
            $comQty = 0;
            foreach ($this->productCombination as $com){
                $comQty += $com->pivot->qty;
            }
            return $comQty;
        }

        foreach ($this->productStore()->get() as $key => $store) {
            $unit = Unit::find($store->pivot->unit_id);
            $unitName = $unit->name??'تم حذفها' . $store->pivot->unit_id;
            if(isset($allqty[$unitName])){
                $allqty[$unitName] += ($store->pivot->qty-$store->pivot->sale_count);
            }else{
                $itemqty = $store->pivot->qty?:0;
                $salcount = $store->pivot->sale_count?:0;
                $allqty[$unitName] = ($itemqty-$salcount);
            }
        }
        foreach ($allqty as $key=>$value){
            $qty.= round($value,2)." $key <br/>";
        }

        if(is_null($qty)){
            $qty = '<div style="padding: 5px;text-align: center;" class="bg-red color-palette"><span>'.trans('front.notavilable').'</span></div>';
        }
        return $qty;
        /*foreach ($this->totalQuantities as $totalQuantity) {
            if($totalQuantity->total) {
                $qty .= "<span style='direction: ltr'>".round($totalQuantity->total,2)
                    . '</span> '
                    . $totalQuantity->unit->name
                    . " <br/>";
            }
        }

        if(is_null($qty)){
            $qty = '<div style="padding: 5px;text-align: center;" class="bg-red color-palette"><span>'.trans('front.notavilable').'</span></div>';
        }

        return $qty;*/
//
//        $result = DB::table('product_store')
//            ->join('units','product_store.unit_id','=','units.id')
//            ->where('product_store.product_id',$this->id)
//            ->groupBy('product_store.unit_id')
//            ->select(DB::raw('units.name,sum(qty-sale_count)  as totalQty'))
//            ->get();
//
//        $qty = "";
//        foreach ($result as $res){
//            if($res->totalQty) {
//                $qty .= "<span style='direction: ltr'>".round($res->totalQty,2) . '</span> ' . $res->name . " <br/>";
//            }
//        }
//        if(empty($qty)){
//            return '<div style="padding: 5px;text-align: center;" class="bg-red color-palette"><span>غير متاح</span></div>';
//        }
//
//        return $qty;
    }

    public function getSalePrice(){
        $result = '';
        foreach ($this->productUnit as $unit){
            if((int) $unit->pivot->sale_price)
                $result .= $unit->name .' : '.round($unit->pivot->sale_price,2).' <br/>';
        }
        return $result;
    }

    public function getPosSalePrice(){
        $possale_price = 0;
        foreach ($this->productUnit as $unit){
            if((int) $unit->pivot->sale_price)
                $possale_price = round($unit->pivot->sale_price,2);

        }
        return $possale_price;
    }

    public function getPosCostPrice(){
        $poscost_price = 0;
        foreach ($this->productUnit as $unit){
            if((int) $unit->pivot->cost_price)
                $poscost_price = round($unit->pivot->cost_price,2);

        }
        return $poscost_price;
    }
    public function getCost(){
        $result = '';
        foreach ($this->productUnit as $unit){
            if((double)$unit->pivot->cost_price)
                $result .= $unit->name .' : '.round($unit->pivot->cost_price,2).' <br/>';
        }
        return $result;
    }
    public function getTotalSales(){

        $result = DB::table('product_store')
            ->join('units','product_store.unit_id','=','units.id')
            ->where('product_store.product_id',$this->id)
            ->groupBy('product_store.unit_id')
            ->select(DB::raw('units.name,sum(sale_count)  as totalSales'))
            ->get();
        $qty = "";
        foreach ($result as $res){
            if($res->totalSales){
                $qty .=  $this->decToFraction($res->totalSales).' '.$res->name."<br/>";
            }
        }
        return $qty;
    }

    function decToFraction($float) {
        // 1/2, 1/4, 1/8, 1/16, 1/3 ,2/3, 3/4, 3/8, 5/8, 7/8, 3/16, 5/16, 7/16,
        // 9/16, 11/16, 13/16, 15/16
        $whole = floor ( $float );
        $decimal = $float - $whole;
        $leastCommonDenom = 48; // 16 * 3;
        $denominators = array (2, 3, 4, 8, 16, 24, 48 );
        $roundedDecimal = round ( $decimal * $leastCommonDenom ) / $leastCommonDenom;
        if ($roundedDecimal == 0)
            return $whole;
        if ($roundedDecimal == 1)
            return $whole + 1;
        foreach ( $denominators as $d ) {
            if ($roundedDecimal * $d == floor ( $roundedDecimal * $d )) {
                $denom = $d;
                break;
            }
        }
        return ($whole == 0 ? '' : $whole) . " " . ($roundedDecimal * $denom) . "/" . $denom;
    }

    public function getTotalWithoutTax($total,$tax){
        $tax =  $tax/100;
        $taxplusone = 1+ $tax;
        $orignalValue = $total / $taxplusone;
        $taxvalue =$orignalValue * $tax;
        $value =  $total - $taxvalue;
        return round($value,2);
    }


}
