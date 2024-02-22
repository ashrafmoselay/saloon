

@extends('layouts.app')
@section('content')

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.restore')
			<small>
				@lang('front.database')
			</small>
		</h1>
	</section>
	<section class="content">
		<div class="box box-primary">
			<form enctype="multipart/form-data" action="{{ route('restore') }}" method="post">
				<div class="box-body">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
						<label for="">@lang('front.database')</label>
						<input id="FileUploade" required="" name="file" type="file" class="form-control" accept="sqlite" >
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">@lang('front.restore')</button>
				</div>
			</form>
		</div>
	</section>
@stop()
@push('js')
	<script type="text/javascript">
		$(document).on('change','#FileUploade',function(e){
            var file = document.getElementById("FileUploade").files[0];
            var filename = file.name;
            var extSplit = filename.split('.');
            var extReverse = extSplit.reverse();
            var ext = extReverse[0];
			if(ext!='sqlite' || file.size/1000 < 50){
                swal({
                    title:'خطأ', text:"هذا الملف ليس بقاعدة بيانات صحيحة",type:"error",confirmButtonText: "تمام",
                });
                $(this).val('');
                return false;
			}
		});
	</script>
@endpush