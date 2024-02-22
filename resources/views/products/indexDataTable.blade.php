@extends('layouts.app')

@section('title',trans('front.products'))
@section('content')
	<!-- Content Header (Page header) -->
	<input type="hidden" id="pageRoute" value="{{route('products.index',['is_raw'=>$is_raw])}}">
	<section class="content-header">
		<h1>
			@if($is_raw)
				قائمة الخامات
			@else
				@lang('front.productsList')
			@endif
			<a class="btn btn-success pull-right" href="{{route('products.create',['is_raw'=>$is_raw])}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>
		</h1>
	</section>
	@php
		$isAdmin = auth()->user()->roles()->first()->id==1;
		if($isAdmin){
			$showcost = true && auth()->user()->show_cost_price;
		}else{
			$showcost = $settings['show_cost_price']==1 && auth()->user()->show_cost_price;
		}

		$showImg = $settings['showImage']==1;
	@endphp
	<!-- Main content -->
	<section class="content">
		<div style="margin-bottom: 5px;" class="row hideprint">
			<form action="{{route('products.index')}}">
				<div class="">
                    <div class="col-md-3">
                        <input class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="كلمة البحث"/>
                    </div>
					<div class="col-md-3">
						<select name="main_category_id" id="category_id" class="form-control select2" style="width: 100% !important;height: 35px !important;">
							<option value="">@lang('front.parent')</option>
							@foreach(\App\Category::where('type',1)->get() as $cat)
								<option {{request('main_category_id')==$cat->id?'selected':''}}  value="{{$cat->id}}">{{$cat->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-3">
						<select id="sub_category_id" name="sub_category_id" class="form-control select2" style="width: 100% !important;height: 35px !important;">
							<option value="">@lang('front.child')</option>
							@foreach(\App\Category::where('type',2)->get() as $cat)
								<option {{request('sub_category_id')==$cat->id?'selected':''}}   value="{{$cat->id}}">{{$cat->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-3">
						<button type="submit" style="width: 200px; " type="button" class="btn btn-info btn-flat">@lang('front.search')</button>
					</div>
				</div>
			</form>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				{{-- <div class="box-header">
                     <h3 class="box-title">Data Table With Full Features</h3>
                 </div>--}}
				<!-- /.box-header -->
					<div class="box-body">
                        <div  class="bg-yellow" style="padding: 5px;margin: 10px;font-size: 20px;">
                            إجمالي الجرد = <p style="display: inline;" id="sumPriceOne"></p> {{currency()->getCurrency()['symbol']??''}}
                        </div>
						<table class="table text-center table-striped table-bordered  dataTableList" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									@if($showImg)
									<th>@lang('front.image')</th>
									@endif
									<th>@lang('front.product')</th>
									<th>@lang('front.parent')</th>
									<th>@lang('front.child')</th>
									@if($showcost)
									<th> @lang('front.cost')</th>
									@endif
                                    @if(auth()->user()->show_sale_price)
									<th> @lang('front.price')</th>
                                    @endif
									<th>@lang('front.quantity')</th>
									<th>@lang('front.action')</th>
								</tr>
							</thead>
                            <tbody></tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->

	<div id="myModal" class="modal fade" style="overflow:hidden;" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<p class="text-center"><div class="fa-3x text-center"><i class="fa fa-cog fa-spin"></i>                    @lang('front.Loading ....')                </div>                </p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">إغلاق</button>
				</div>
			</div>
		</div>
	</div>
	<div id="myModalFullScreen" class="modal fade modal-fullscreen" style="overflow:hidden;" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<p class="text-center"><div class="fa-3x text-center"><i class="fa fa-cog fa-spin"></i>                    @lang('front.Loading ....')                </div>                </p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">إغلاق</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('css')
	<style>
		.typeahead {
			z-index: 1051;
			direction: rtl;
		}

		.twitter-typeahead {
			width: 100%;
			height: 28px;
		}
		.tt-query {
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		}

		.tt-hint {
			color: #999
		}

		.tt-menu {    /* used to be tt-dropdown-menu in older versions */
			width: 100%;
			margin-top: 2px;
			padding: 4px 0;
			background-color: #fff;
			border: 1px solid #ccc;
			border: 1px solid rgba(0, 0, 0, 0.2);
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
			-moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
			box-shadow: 0 5px 10px rgba(0,0,0,.2);
		}

		.tt-suggestion {
			padding: 3px 20px;
			line-height: 24px;
			direction: rtl;
		}

		.tt-suggestion.tt-cursor,.tt-suggestion:hover {
			color: #fff;
			background-color: #0097cf;

		}

		.tt-suggestion p {
			margin: 0;
		}

	</style>
@endpush
@push('dataTableJs')
<script>
    function getData()
    {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
    $(".select2").select2();
    var isAdmin = Boolean("{{$showcost}}");
    var showImg = Boolean("{{$showImg}}");
    var main_category_id = getData()['main_category_id'];
    var sub_category_id = getData()['sub_category_id'];
    var keyword = getData()['keyword'];

    var pageUrl = $("#pageRoute").val();
    if(main_category_id!=undefined){
        pageUrl += "&main_category_id="+main_category_id;
    }
    if(sub_category_id!=undefined){
        pageUrl += "&sub_category_id="+sub_category_id;
    }
    if(keyword!=undefined){
        pageUrl += "&keyword="+keyword;
    }
	var columns =  [
        {data: "id", name: "id"}
    ];
    if(showImg){
        columns.push({data:'image',name:'image', orderable: false, searchable: false});
	}
    columns.push({data: "name", name: "name"});
    columns.push({data: "category", name: "category.name"});
    columns.push({data: "subcategory", name: "subcategory.name"});
    if(isAdmin){
        columns.push({data: "cost", name: "cost"});
    }
    @if(auth()->user()->show_sale_price)
        columns.push({data: "price", name: "price"});
    @endif
    columns.push({data: "quantity", name: "quantity"});
    columns.push({data: "actions", name: "actions"});
</script>
@endpush
