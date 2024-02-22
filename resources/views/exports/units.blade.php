<table>
    <thead>
    <tr>
        <th>@lang('front.name')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($units as $unit)
        <tr>
            <td>{{$unit->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
