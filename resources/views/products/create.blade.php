@extends('layouts.app')

@section('title',trans('front.Add Product'))
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.Add')
			<small>
				@if($is_raw)
					مادة خام
				@else
				@lang('front.product')
				@endif
			</small>
		</h1>
	</section>
	<!-- Main content -->
	<form enctype="multipart/form-data"  action="{{route('products.store')}}" method="post">
		{{ csrf_field() }}
		@include('products._form')
	</form>
    <div class="com-item hide">
        <div class="row itemComb">
            <div class="col-md-4">
                <div class="form-group">
                    <label>المخزن</label>
                    <select required name="combination[][store_id]" class="form-control">
                        @foreach(\App\Store::get() as $storeObj)
                            <option value="{{$storeObj->id}}">{{$storeObj->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>اللون والمقاس</label>
                    <select required name="combination[][combination_id]" class="form-control colorsize" style="width: 100%;">
                        <option value="">--- إختر ---</option>
                        @foreach(\App\Combination::get() as $combination)
                            <option value="{{$combination->id}}">{{$combination->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>@lang('front.quantity')</label>
                    <input name="combination[][qty]" value="" type="number" step="any"  class="form-control" required="required">
                </div>
                <a style="position: absolute;left: 50px;top: -6px;" class="btn btn-sm bg-green addComb" href="#"><i class="fa fa-plus-square"></i></a>
                <a style="position: absolute;left: 15px;top: -6px;" class="btn btn-sm bg-red removeComb" href="#"><i class="fa fa-minus"></i></a>
            </div>
        </div>
    </div>
    @stop
