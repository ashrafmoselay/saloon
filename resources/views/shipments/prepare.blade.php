@extends('layouts.app')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			تجهيز الشغل
			<small>
				للمحافظات
			</small>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('shipments.prepare')}}" method="post">
		{{ csrf_field() }}
        <section class="content">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>إختر المحافظات</label>
                            <select name="region_list[]" required multiple class="form-control select2" style="width: 100%;">
                                <option disabled value="">إختر المحافظة</option>
                                @foreach(\App\Region::get() as $region)
                                    <option value="{{$region->id}}">{{$region->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary "><i class="fa fa-save"></i> @lang('front.save') </button>
                </div>
            </div>
        </section>
	</form>
@stop
@push('js')
    <script>
        $(".select2").select2();
    </script>
@endpush
