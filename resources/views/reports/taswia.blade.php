@extends('layouts.app')
@section('content')
@section('title','تقرير التسويات')
<section class="content-header">
	<h1>
		تقرير
		<small>
			التسويات
		</small>
		<a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print()" role="button">
			<i class="fa fa-print" aria-hidden="true"></i>
		</a>
	</h1>
</section>
<section class="content">
	<div class="box box-primary">
		@include('layouts.partial.filter')
		@include('layouts.partial.printHeader',['showCompanyData'=>true])
        <div class="box-body row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr >
                            <th>#</th>
                            <th>اسم الشريك</th>
                            <th>إجمالى التسويات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($summery as $s)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td class="bg-green">{{$s->name}}</td>
                                <td class="bg-yellow">{{$s->total}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-body row">
                <div class="col-md-12">
                    <table id="dataList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الشريك</th>
                                <th>التسوية</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{optional($item->partner)->name}}</td>
                                    <td>{{$item->value}}</td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

	</div>
</section>
@stop
@push('css')
    <style>
        .rowTd{
            vertical-align: middle !important;
            text-align: center !important;
            font-size: 15px !important;
        }
        .progress-bar,.badge{
            width: 100%;
        }
        .badge {
            width: 100%;
            padding: 5px;
        }
        table,.badge,td {
            font-size: 14px !important;
            font-weight: bold !important;
        }
        @media print {
            table,.badge,td,.bg-green,.bg-yellow,.bg-aqua,.bg-red,.bg-green {
                font-size: 18px !important;
                color: #0c0c0c!important;
            }

        }
    </style>
@endpush
@push('js')
	<script>
        $('.datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{\Session::get('locale')}}",
        });
	</script>
@endpush
