<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShipmentDetailes extends Model
{
    protected $fillable = [
        'client_name','client_mobile','shipment_id',
        'client_address','product_id','store_id',
        'returned_qty','qty','cost','price','shipping_cost',
        'status','note','color','sender_id','sender','combination_id',
        'fee','region_id'
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function region(){
        return $this->belongsTo(Region::class);
    }
    public function shipment(){
        return $this->belongsTo(Shipment::class);
    }
    public function getTotalAttribute()
    {
        $total = (($this->qty - $this->returned_qty) * $this->price) + $this->shipping_cost;
        return round($total, 2);
    }

    public function getTotalWithoutShippingAttribute()
    {
        $total = (($this->qty - $this->returned_qty) * $this->price);
        return round($total, 2);
    }

    public function scopeFilter($query)
    {
        $from = request('fromdate');
        $to = request('todate');
        $status = request('shipping_status');
        $sender = request('sender');
        $term = request('id');
        $region_id = request('region_id');

        $product_status = request('product_status');
        $query->join('shipments','shipments.id','=','shipment_id');
        $query->select("shipment_detailes.*");

        $perPage = \request('per_page')??10000;
        if($product_status){
            $query->where('status',$product_status);
        }
        if ($from) {
            $query->whereDate('shipments.created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('shipments.created_at', '<=', $to);
        }
        if($status){
            $query->where('shipments.shipping_status',$status);
        }

        if($sender){
            $query->where('sender_id',$sender);
        }
        if($region_id){
            $query->where('region_id',$region_id);
        }
        if($term){
            $query->where(function($q)use($term){
                $q->where('client_name','like','%'.$term.'%')
                    ->orwhere('client_mobile','like','%'.$term.'%')
                    ->orwhere('shipment_id','like','%'.$term.'%');
            });
        }
        $query = $query->latest()->paginate($perPage);
        return $query;
    }
}
