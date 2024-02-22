<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shipment extends Model
{
    protected $fillable = [
        'shipping_office', 'shipping_status','follow_up_mobile','note','user_id','created_at'
    ];
    protected $hidden = ['note'];
    public function details()
    {
        return $this->hasMany(ShipmentDetailes::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalAttribute()
    {
        if ($this->relationLoaded('details')) {
            $total = $this->details->wherein('status',['مستلم','مرتجع','تفاوض'])->sum(function ($item) {
                $subtotal = 0;
                if($item->status=='مستلم'){
                    $subtotal = ($item->qty - $item->returned_qty) * $item->price;
                }
                //if($item->shipping_cost>0)
                    $subtotal += $item->shipping_cost;
                return  $subtotal;
            });
            /*$totalreturnShipping = $this->details->where('status','مرتجع')->sum(function ($item) {
                return $item->shipping_cost;
            });*/
            return round($total, 2);
        }
    }

    public function getTotalgAttribute()
    {
        if ($this->relationLoaded('details')) {
            $total = $this->details->sum(function ($item) {
                return (($item->qty - $item->returned_qty) * $item->price) + $item->shipping_cost;
            });
            return round($total, 2);
        }
    }

    public function getTotalQtyAttribute()
    {
        if ($this->relationLoaded('details')) {
            $total = $this->details->wherein('status',['مرتجع','مستلم','تفاوض'])->sum(function ($item) {
                return ($item->qty - $item->returned_qty);
            });
            return round($total, 2);
        }
    }
    public function getAllQtyAttribute()
    {
        if ($this->relationLoaded('details')) {
            $total = $this->details->sum(function ($item) {
                return $item->qty;
            });
            return round($total, 2);
        }
    }

    public function getTotalShippingAttribute()
    {
        if ($this->relationLoaded('details')) {
            $total = $this->details->wherein('status',['مرتجع','مستلم','تفاوض'])->sum(function ($item) {
                if($item->shipping_cost>0)
                    return ($item->shipping_cost);
            });
            return round($total, 2);
        }
    }
    public function getTotalFeeAttribute()
    {
        if ($this->relationLoaded('details')) {
            $total = $this->details->wherein('status',['مرتجع'])->sum(function ($item) {
                if($item->fee>0)
                    return ($item->fee);
            });
            return round($total, 2);
        }
    }


    public function getTotalReturnedAttribute()
    {
        if ($this->relationLoaded('details')) {
            $total = $this->details->wherein('status',['مرتجع','مستلم','تفاوض'])->sum(function ($item) {
                return $item->returned_qty;
            });
            return round($total, 2);
        }
    }
    public function getTotalReshippingAttribute()
    {
        if ($this->relationLoaded('details')) {
            $total = $this->details->where('status','تدوير')->sum(function ($item) {
                return $item->qty;
            });
            return round($total, 2);
        }
    }
    public function getTotalPostponedAttribute()
    {
        if ($this->relationLoaded('details')) {
            $total = $this->details->where('status','تأجيل')->sum(function ($item) {
                return $item->qty;
            });
            return round($total, 2);
        }
    }
    public function scopeFilter($query)
    {
        $id = request('id');
        $from = request('fromdate');
        $to = request('todate');
        $status = request('shipping_status');
        $sender = request('sender');
        $product_status = request('product_status');
        if ($from) {
            $query->whereDate('shipments.created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('shipments.created_at', '<=', $to);
        }
        if($status){
            $query->where('shipments.shipping_status',$status);
        }
        if($id){
            $query->where('shipments.id',$id);
            $query->orwhereHas('details',function ($qry)use($id){
               $qry->where('client_name','like','%'.$id.'%')
                   ->orwhere('client_mobile','like','%'.$id.'%');
            });
        }
        if($sender || $product_status){
            $query->whereHas('details',function ($qry)use($sender,$product_status){
                if($sender){
                    $qry->where('sender_id',$sender);
                }
                if($product_status){
                    if($product_status[0]!='الكل')
                        $qry->wherein('status',$product_status);
                }
            });
        }
        return $query;
    }
    public function getDateArAttribute() {
        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
        //$your_date = $this->created_at->addDays(1)->format('Y-m-d');    //date('y-m-d'); // The Current Date
        if(!$this->created_at) return "";
        $your_date = $this->created_at->format('Y-m-d');
        $en_month = date("M", strtotime($your_date));
        foreach ($months as $en => $ar) {
            if ($en == $en_month) { $ar_month = $ar; }
        }
        $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
        $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = date("D", strtotime($your_date)); //date('D'); // The Current Day
        $ar_day = str_replace($find, $replace, $ar_day_format);
        $day_num = date("d", strtotime($your_date));
        $year_num = date("Y", strtotime($your_date));
        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0","1","2","3","4","5","6","7","8","9");
        $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
        $current_date = $ar_day.' '.$day_num.' / '.$ar_month.' / '.$year_num;
        $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);

        return $arabic_date;
    }
}
