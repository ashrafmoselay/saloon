<div class="box-body no-padding">
    <table class="table table-striped">
        @if(count($logs) > 0)
            <tr>
                <th>#</th>
                <th>المستخدم</th>
                <th>الموديل</th>
                <th>البيان</th>
                <th>التاريخ</th>
            </tr>

        @foreach($logs as $log)
            @php
                $model = $log->subject;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ optional($log->causer)->name }}</td>
                <td>{{ trans("front.".$log->model_name)  }} </td>
                <td>{{ $log->description }}</td>
                <td>
                    {!!  $log->listAttributes('attributes')  !!}
                </td>
                <td>
                    {!!   $log->listAttributes('old')  !!}
                </td>
                <td>{{$log->created_at->diffForHumans()}}</td>

            </tr>

        @endforeach
        @else
            <tr>
                <th>لا توجد سجلات حتى الان</th>
            </tr>
        @endif
    </table>
</div>
<div class="row text-center">
    <div class="col-sm-4"></div>
    <div class="col-sm-8">{{$logs->appends(request()->except('page'))->links()}}</div>
</div>

@push('js')
    <script>
        $(document).on('click','.showAttributesData',function () {
            $(this).next('.attributesData').fadeIn('fast');
            $(this).replaceWith('<button class="btn btn-success hideAttributesData">Hide Details</button>');
        });
        $(document).on('click','.hideAttributesData',function () {
            $(this).next('.attributesData').fadeOut('fast');
            $(this).replaceWith('<button class="btn btn-success showAttributesData">Show Details</button>');
        });
    </script>
@endpush
