<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @lang('front.summary')
        <small>
            {{ $person->name }}
        </small>
        <a onclick="window.print();" href="javascript:void(0)" class=" btn btn-lg print pull-right"><i class="fa fa-print"
                aria-hidden="true"></i></a>
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h4>كشف الحساب</h4>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered textceneter">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>المسئول</th>
                                                <th>البيان</th>
                                                <th>التاريخ</th>
                                                <th>دائن</th>
                                                <th>مدين</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $perTrans)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ optional($perTrans->creator)->name }}</td>
                                                    <td>{{ $perTrans->note }}</td>
                                                    <td>{{ $perTrans->getOriginal('created_at') ? $perTrans->created_at->format('Y-m-d h:i A') : $perTrans->updated_at }}
                                                    </td>
                                                    <td>{{ $perTrans->value < 0 ? number_format(abs($perTrans->value), 2) : '------' }}
                                                    </td>
                                                    <td>{{ $perTrans->value > 0 ? number_format($perTrans->value, 2) : '------' }}
                                                    </td>
                                                    <td>
                                                        <a target="_blank" title="طباعه"
                                                            href="{{ route('transrecordprint', $perTrans->id) }}"
                                                            class="btn btn-info btn-xs">
                                                            <i class="fa fa-print" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
