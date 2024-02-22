@extends('layouts.app')

@section('content')
<section class="content-header hideprint">
	<h1>
		باركود اﻷصناف
		<a onclick="window.print()" href="javascript:void(0)" class=" btn btn-lg print pull-right"><i class="fa fa-print" aria-hidden="true"></i></a>
	</h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
			<div class="row hideprint">
				<div class="col-md-6">
					<div class="form-group">
						<label>اسم الصنف</label>
						<input type="hidden" id="productID" value="">
						<input autocomplete="off" class="typeahead form-control" type="text">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>عدد اللاصقات</label>
						<input id="copies" value="1" name="copies" type="number" class="form-control ">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>من</label>
						<input id="from" value="1" name="from" type="number" class="form-control ">
					</div>
				</div>
			</div>
			<div id="list" class="row">
			</div>
		</div>
	</div>
</section>
@stop
@push('css')
	<style>
		.genCode img{
			max-width: 160px;
			width: 160px!important;
			height: 22px;
			margin: 5px;
		}
		.stretch {
			-webkit-transform:scale(2,1); /* Safari and Chrome */
			-moz-transform:scale(2,1); /* Firefox */
			-ms-transform:scale(2,1); /* IE 9 */
			-o-transform:scale(2,1); /* Opera */
			transform:scale(2,1); /* W3C */
		}
		.genCode h6 span{
			font-size: 15px;
		}
		.genCode h6{
			font-size: 13px;
			text-align: center;
			white-space:nowrap;
			max-width: 80%;
			overflow: hidden;
			width: 220px;
			font-weight: bold;
			margin: 10px 23px 10px 0px;
		}
		.genCode{
			border: none;
			width: 4.5cm!important;
			height: 2.5cm!important;
			text-align: right;
			vertical-align: top;

		}
		@media print {
			.box {
				border: none;
			}
			/*.table {
				border: none!important;
			}*/
			table>tbody>tr>td {
				/*border: none!important;*/
				vertical-align: top!important;
			}
			@page { margin-left: .6cm;margin-right: .4cm;margin-top: .5cm!important;margin-bottom: .4cm!important; }
			body {margin: 0;}
		}
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

		.tbody td {
			border: 2px solid black!important;
		}
		.table-bordered th,.textcenter{
			text-align: center;
		}
		.table-bordered>tbody>tr>td{
			vertical-align: middle;
			padding: 2px!important;
		}
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
    $(document).on("keydown","#copies,#from",function(e) {
        if ($("#copies").val() && e.which == 13) {
            $.ajax({
                type: "GET",
                url: "{{route('products.generateBarCode')}}",
                data: {
                    prodId: $("#productID").val(),
                    copies: $("#copies").val(),
                    from: $("#from").val(),

                },
                success: function (data) {
                    $("#list").html(data);
                }
            });
        }
    });
</script>
@endpush
