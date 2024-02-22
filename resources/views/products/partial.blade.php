
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
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    </h1>
</section>
<!-- Main content -->
<form id="productForm" enctype="multipart/form-data"  action="{{route('products.store')}}" method="post">
    {{ csrf_field() }}
    <input value="{{request()->req}}" name="reqType" type="hidden">
    @include('products._form')
</form>

@if(request()->req=='ajax')
    <script>
        $(function () {

            $(document).on('change','.productUnitSelector',function(){
                var selectedunit = '';
                $(".productUnitSelector").each(function(){
                    option = $(this).find('option:selected');
                    if(option.val()){
                        selectedunit += '<option value="'+option.val()+'">'+option.text()+'</option>';
                    }
                });
                $(".storeUnites").each(function(){
                    $(this).html(selectedunit);
                });

            });
            $("#productForm").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(name)
                    {
                        $typeaheadSearch.typeahead('val',name);
                        setTimeout(function(){
                            if($('.tt-selectable').length==1)
                            {
                                $('.tt-selectable').first().click();
                            }
                        },1000);
                       $('#addPersonModal').modal('toggle');
                    }
                });
            });
        });
    </script>
@endif
