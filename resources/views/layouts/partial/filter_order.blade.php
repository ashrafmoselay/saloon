
<div class="row hideprint" style="margin-top: 10px;">
    <div class="col-md-12">
        <form action="" method="get">
            <div class="col-md-4">
                <div class="form-group ">
                    <label>@lang('front.datefrom')</label>
                    <input autocomplete="off" style="direction: rtl;" name="fromdate" value="{{request()->fromdate}}" type="text" class="form-control datepicker">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>@lang('front.dateto')</label>
                    <input autocomplete="off" style="direction: rtl;" name="todate" value="{{request()->todate}}" type="text" class="form-control datepicker">
                </div>
            </div>
            <div class="col-md-4">
                <label> </label>
                <button  type="submit" class="btn btn-primary form-control">@lang('front.search')</button>
            </div>


        </form>
    </div>
</div>
@push('js')
    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{\Session::get('locale')}}",
        });
        /*  $(document).on('change','.todate,.fromdate',function(e){
              e.preventDefault();
              alert();
              let todate = $('.todate').val();
              let fromdate = $('.fromdate').val();
          });*/
    </script>
@endpush
