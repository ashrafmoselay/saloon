<section class="content-header">
	<h1>
		<a class="btn print-window pull-right" href="javascript:void(0)" onclick="PrintDiv('BarcodeDiv')" role="button">
			<i class="fa fa-print" aria-hidden="true"></i>
		</a>
	</h1>
</section>
<section id="BarcodeDiv" class="content">
	<style>
		@media print {
			.col-md-12{
				text-align: center;
				vertical-align: middle;
			}
			#footer{visibility: hidden;}
		}
	</style>
	<div class="row">
			<div class="col-md-12">
				<h6>{{$product->name}}</h6>
				<div>{!!'<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($product->code, $generator::TYPE_CODE_128)) . '">'!!}</div>
				<h6>{{'السعر:'.$product->productUnit()->first()->pivot->sale_price}}</h6>
			</div>
	</div>
</section>