
<table class="table table-bordered">
    <thead>
    <tr>
        <th colspan="4">{{$title}}</th>
    </tr>
    <tr>
        <th>#</th>
        <th>@lang('front.title')</th>
        <th>@lang('front.value')</th>
        <th>@lang('front.date')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $item)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$item->note}}</td>
            <td>{{$item->value}}</td>
            <td>{{$item->created_at->format('Y-m-d')}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr class="bg-danger">
            <td colspan="2">الإجمالى</td>
            <td>{{$list->sum('value')}}</td>
            <td></td>
        </tr>
    </tfoot>
</table>
