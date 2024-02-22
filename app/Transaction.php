<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['value','note','record_id','transaction_type','created_at','sale_id','is_effective_invoices','creator_id'];

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function model()
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
    }


    public function sale(){
        return $this->belongsTo(Employee::class,'sale_id','id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'record_id','id');
    }
    public function creator(){
        return $this->belongsTo(User::class,'creator_id','id');
    }

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->creator_id = auth()->user()->id;
        });
    }

    public function getTimeArAttribute() {
        $curDT = $this->created_at;
        //dd($curDT->format('Y-m-d h:i a'));
        $curTime = strtotime($curDT);
        $arrEn = array('am', 'pm');
        $arrAr = array('صباحاً', 'مساءً');
        $newformat =  date("h:i ",$curTime).str_replace($arrEn, $arrAr,date("a", $curTime));
        return $newformat;
    }
    public function getDateArAttribute() {
        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
        if(!$this->created_at) return "";
        $your_date = $this->created_at;
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
        $current_date = $ar_day.', '.$day_num.' '.$ar_month.' '.$year_num;
        $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);

        return $arabic_date;
    }
}
