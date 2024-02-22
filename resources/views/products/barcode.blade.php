@extends('layouts.app')

@section('content')
	<section class="content-header hideprint">
		<h1>
			@lang('front.barcode')
			<a id="printbarcode" href="javascript:void(0)" class=" btn btn-lg pull-right"><i class="fa fa-print" aria-hidden="true"></i></a>
		</h1>
	</section>
	<section class="content">
		<div class="box box-primary">
			<div class="box-body ">
				<div class="row">
                    <div class="col-md-6">
						<div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('front.product')</label>
                                <input type="hidden" id="productID" value="">
                                <input required="" autocomplete="off" class="typeahead form-control" type="text">
                            </div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>@lang('front.barcode type')</label>
								<select class="form-control" id="barcodetype" name="barcodetype">
									<option value="{{\Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODE_128}}">TYPE_CODE_128</option>
									<option value="{{\Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODE_128_A}}">TYPE_CODE_128_A</option>
									<option value="{{\Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODE_128_B}}">TYPE_CODE_128_B</option>
									<option value="{{\Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODE_128_C}}">TYPE_CODE_128_C</option>
									<option value="{{\Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODE_39}}">TYPE_CODE_39</option>
									<option value="{{\Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODE_93}}">TYPE_CODE_93</option>
									<option value="{{\Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODABAR}}">TYPE_CODABAR</option>
									<option value="{{\Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODE_11}}">TYPE_CODE_11</option>
									<option value="{{\Picqer\Barcode\BarcodeGeneratorPNG::TYPE_STANDARD_2_5}}">TYPE_STANDARD_2_5</option>
									<option value="{{\Picqer\Barcode\BarcodeGeneratorPNG::TYPE_PHARMA_CODE}}">TYPE_PHARMA_CODE</option>
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label>@lang('front.barcode size')</label>
								<select class="form-control" id=barcodesize name="size">
                                    <!-- <option marginLeft="0" marginTop="0" relh="2.5" relw="3.5" value="3.5x2.5">3.5cm * 2.5cm</option> -->
                                    <option marginLeft="0.4" marginTop="0.4" relh="2.5" relw="4" value="4x2.5">4cm * 2.5cm</option>
									<option marginLeft="0" marginTop="0.02" relh="2.5 " relw="3.9" value="4x1">4cm * 1cm double</option>
									<option marginLeft="0.5" marginTop="0.5" relh="2.5" relw="6"  value="6x2.5">6cm * 2.5cm</option>
									<!-- <option value="a4x11">A4 4*11</option> -->
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>@lang('front.margin left')</label>
								<input id="margin_left" step="0.01" value="0.5" name="margin_left" type="number" class="form-control ">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>@lang('front.margin right')</label>
								<input id="margin_top" step="0.01" value="0.4" name="margin_top" type="number" class="form-control ">
							</div>
						</div>
						<!-- <div class="col-md-12">
							<div class="form-group">
								<label>@lang('front.copies')</label>
								<input id="copies" value="1" name="copies" type="number" class="form-control ">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>@lang('front.from')</label>
								<input id="from" value="1" name="from" type="number" class="form-control ">
							</div>
						</div> -->
						<div class="col-md-12">
							<button id="generatBtn" class="btn btn-lg btn-primary">@lang('front.generate barcode')</button>
						</div>
					</div>
					<div class="col-md-6">
						<iframe style="width: 100%;height: 300px;text-align: center;vertical-align: middle;" id="barcodedesign">

						</iframe>
					</div>

				</div>
				</div>
			</div>
		</div>
	</section>
@stop
@push('css')
	<style>
		input.tdinput {
			display: block;
			width: 100%;
			height: 40px;
			padding: 0;
			font-size: 14px;
			line-height: 1.42857143;
			color: #555;
			background-color: #fff;
			border: 0px solid #fff;
			border-radius: 4px;
			border: 0px solid #fff!important;
			text-align: center;
		}

		/*.tbody td {
			border: 2px solid black!important;
		}*/
		.table-bordered th,.textcenter{
			text-align: center;
		}
		/*.table-bordered>tbody>tr>td{
			vertical-align: middle;
			padding: 2px!important;
		}*/
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
			z-index: 10000!important;
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
@push('js')
	<script type="text/javascript">
        var $typeaheadSearch = $('.typeahead');
        $typeaheadSearch.typeahead({highlight: true}, {
            name: 'products',
            limit:10,
            display: function(suggestion){
                return suggestion.name;
            },
            source: new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: "{{route('products.getProductList')}}",
                    prepare: function (query, settings) {
                        settings.url = "{{route('products.getProductList')}}" + '?q=' + query;
                        return settings;
                    }
                }
            }),
            templates: {
                suggestion: function(suggestion) {
                    return '<p>'+ suggestion.name +'<strong style="color:red;"> ' +suggestion.category.name+ '</strong></p>';
                }
            }
        });
        $typeaheadSearch.on('typeahead:select', function (e, suggestion) {
            $("#productID").val(suggestion.id);
        });
        $(document).on("change","#barcodesize",function(e) {
			$("#margin_left").val($( "#barcodesize option:selected" ).attr('marginLeft'));
			$("#margin_top").val($( "#barcodesize option:selected" ).attr('marginTop'));
        });
        $(document).on("click","#generatBtn",function(e) {
    	 	let $btn = $(this);
            $('#barcodedesign').contents().find('body').html("");
	    	if ($("#productID").val()) {
		    	$btn.attr('data-loading-text',"<i class='fa fa-circle-o-notch fa-spin'></i> جارى التحميل ...");
		    	$btn.button('loading');
				$.ajax({
                    type: "GET",
                    url: "{{route('products.generateBarCode')}}",
                    data: {
                        prodId: $("#productID").val(),
                        copies: $("#copies").val(),
                        from: $("#from").val(),
                        size: $("#barcodesize").val(),
                        barcodetype:$("#barcodetype").val(),
                        margin_top:$("#margin_top").val(),
                        margin_left:$("#margin_left").val(),
                        width:$( "#barcodesize option:selected" ).attr('relw'),
                        height:$( "#barcodesize option:selected" ).attr('relh')
                    },
                    success: function (data) {
                        $('#barcodedesign').contents().find('body').html(data);
                        $btn.button('reset');
                    }
                });
	    	}
        });
        $(document).on("click","#printbarcode",function(){
        	$("#barcodedesign").get(0).contentWindow.print();
        });
	</script>
@endpush
