<?php

namespace App;

use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Carbon\Carbon;

class Activity extends SpatieActivity
{
    public static $logModels = [
        Person::class =>'Persons',
        Product::class => 'Products',
        Order::class => 'Orders',
        ReturnProduct::class=> 'Returns',
        Expense::class=> 'Expenses',
        Bank::class=> 'Bank',
        MovementInvoice::class=> 'MovementInvoice',
        ProductUnit::class=>'ProductUnit'
    ];

    public function getModelNameAttribute()
    {
        return $this->subject_type?self::$logModels[$this->subject_type]:'';
    }

    public function tapActivity(Activity $activity)
    {
        $activity->properties = $activity->properties->merge([
            'custom_prop' => 'value of custom property',
        ]);
    }

    public function listAttributes($status)
    {
        $text = '';
        $attributes = $this->changes()->get($status);
        if (!empty($attributes)){
            $text = '<button class="btn btn-success showAttributesData">Show Details</button>';
            $text .= '<div style="display: none" class="attributesData">';
            foreach($attributes as $attribute => $value){
                $text .= trans('attributes.'.$attribute).' <i class="fa fa-arrow-right"></i> ';
                if (!empty($this->subject) &&
                    property_exists($this->subject,'logRelationships') &&
                    is_array($this->subject->logRelationships) &&
                    in_array($attribute,$this->subject->logRelationships) &&
                    method_exists($this->subject,$attribute.'_log')
                ){
                    $text .= $this->subject->{$attribute.'_log'}($value);
                }elseif (is_array($value)){
                    if (is_numeric(array_keys($value)[0])){
                        $text .= implode(',',$value);
                    }else{
                        foreach ($value as $k => $v){
                            $text .= '<br>'.$k.' : '.strip_tags($v);
                        }
                    }
                }else{
                    $text .= $value;
                }
                $text .= '<hr>';
            }
            $text .= '</div>';
        }
        return $text;
    }

    public function scopeFilter($query, $search)
    {
        if(!empty($search['from'])) {
            $from = $search['from'];
            $query->whereDate('activity_log.created_at','>=',$from);
        }

        if(!empty($search['to'])) {
            $to = $search['to'];
            $query->whereDate('activity_log.created_at','<=',$to);
        }

        if(!empty($search['model'])) {
            $type = $search['model'];
            $query->where('subject_type', $type);
        }
        /*if(!empty($search['subject'])) {
            $subject = $search['subject'];
            $query->where('description', $subject);
        }*/

        if(!empty($search['causer'])) {
            $causer_id = $search['causer'];
            $query->where('causer_id', $causer_id);
        }
        //dd($query->toSql());
        return $query;
    }
}
