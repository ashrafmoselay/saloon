@extends('layouts.app')
@section('title', trans('front.settings'))
@section('content')
    <section class="content">
        <div class="box box-primary">
            <form class="form-inputs" id="setting-form" action="{{ route('setting.edit') }}" method="post"
                enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                @foreach ($setting as $set)
                                    <div class="form-group {{ $set->key == 'InvoiceNotes' ? 'col-md-12' : 'col-md-6' }}">
                                        <label>{{ trans('app.' . $set->key) }} :</label>
                                        @if ($set->key == 'show_cost_price')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'productCost')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 'avg' ? 'selected=""' : '' }} value="avg">
                                                    @lang('app.avg')</option>
                                                <option {{ $set->value == 'lastcost' ? 'selected=""' : '' }}
                                                    value="lastcost">
                                                    @lang('app.lastcost')</option>
                                            </select>
                                        @elseif($set->key == 'default_payment')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 'cash' ? 'selected=""' : '' }} value="cash">
                                                    @lang('front.cash')</option>
                                                <option {{ $set->value == 'delayed' ? 'selected=""' : '' }}
                                                    value="delayed">
                                                    @lang('front.Postpaid')</option>
                                                <option {{ $set->value == 'visa' ? 'selected=""' : '' }} value="visa">
                                                    @lang('front.visa')</option>
                                            </select>
                                        @elseif($set->key == 'canChangePrice')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'ShowCustomerPrice')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'rounding_up')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'subtract_expenses_profit')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'subtract_payment_from_invoice')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option value="2">تم إلغائها من ناحية المبرمج</option>
                                            </select>
                                        @elseif($set->key == 'show_profit_button')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'showImage')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'can_order_unavilable_qty')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'use_two_shipping_cost')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 0 ? 'selected=""' : '' }} value="0">
                                                    @lang('app.no')</option>
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                            </select>
                                        @elseif($set->key == 'sales_marketer')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'industrial')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.Commercial activity')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.Industrial activity')</option>
                                                <option {{ $set->value == 3 ? 'selected=""' : '' }} value="3">نشاط طبي
                                                </option>
                                            </select>
                                        @elseif($set->key == 'show_category_in_invoice')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'show_stores_in_invoices')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'enable_empty_invoice')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 0 ? 'selected=""' : '' }} value="0">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'enable_edit_date')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 0 ? 'selected=""' : '' }} value="0">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'use_sales')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 0 ? 'selected=""' : '' }} value="0">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'use_bounse')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 0 ? 'selected=""' : '' }} value="0">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'logo')
                                            <input type="file" class="form-control" name="logo">
                                            @if ($set->value)
                                                <div class="pull-left">
                                                    <img style="width: 150px;"
                                                        src="{{ \Illuminate\Support\Facades\Storage::url($set->value) }}">
                                                    <a class="btn btn-danger" href="{{ route('deleteLogo') }}"><i
                                                            class="fa fa-trash"></i></a>
                                                </div>
                                            @endif
                                        @elseif($set->key == 'signture')
                                            <input type="file" class="form-control" name="signture">
                                            @if ($set->value)
                                                <div class="pull-left">
                                                    <img style="width: 150px;"
                                                        src="{{ \Illuminate\Support\Facades\Storage::url($set->value) }}">
                                                </div>
                                            @endif
                                        @elseif($set->key == 'size')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 12 ? 'selected=""' : '' }} value="12">12
                                                </option>
                                                <option {{ $set->value == 13 ? 'selected=""' : '' }} value="13">13
                                                </option>
                                                <option {{ $set->value == 14 ? 'selected=""' : '' }} value="14">14
                                                </option>
                                                <option {{ $set->value == 15 ? 'selected=""' : '' }} value="15">15
                                                </option>
                                                <option {{ $set->value == 16 ? 'selected=""' : '' }} value="16">16
                                                </option>
                                                <option {{ $set->value == 18 ? 'selected=""' : '' }} value="18">18
                                                </option>
                                                <option {{ $set->value == 20 ? 'selected=""' : '' }} value="20">20
                                                </option>
                                            </select>
                                        @elseif($set->key == 'PrintSize')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 8 ? 'selected=""' : '' }} value="8">8
                                                </option>
                                                <option {{ $set->value == 10 ? 'selected=""' : '' }} value="10">10
                                                </option>
                                                <option {{ $set->value == 12 ? 'selected=""' : '' }} value="12">12
                                                </option>
                                                <option {{ $set->value == 13 ? 'selected=""' : '' }} value="13">13
                                                </option>
                                                <option {{ $set->value == 14 ? 'selected=""' : '' }} value="14">14
                                                </option>
                                                <option {{ $set->value == 15 ? 'selected=""' : '' }} value="15">15
                                                </option>
                                                <option {{ $set->value == 16 ? 'selected=""' : '' }} value="16">16
                                                </option>
                                                <option {{ $set->value == 18 ? 'selected=""' : '' }} value="18">18
                                                </option>
                                                <option {{ $set->value == 20 ? 'selected=""' : '' }} value="20">20
                                                </option>
                                            </select>
                                        @elseif($set->key == 'use_barcode')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'show_profit')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'can_sell_loss')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 2 ? 'selected=""' : '' }} value="2">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'show_shipment_company')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 0 ? 'selected=""' : '' }} value="0">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'show_all_products_returns')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 0 ? 'selected=""' : '' }} value="0">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'use_color_size_qty')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 1 ? 'selected=""' : '' }} value="1">
                                                    @lang('app.yes')</option>
                                                <option {{ $set->value == 0 ? 'selected=""' : '' }} value="0">
                                                    @lang('app.no')</option>
                                            </select>
                                        @elseif($set->key == 'printerType')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 'A4' ? 'selected=""' : '' }} value="A4">A4
                                                </option>
                                                <option {{ $set->value == 'A5' ? 'selected=""' : '' }} value="A5">A5
                                                </option>
                                                <option {{ $set->value == 'receipt' ? 'selected=""' : '' }}
                                                    value="receipt">
                                                    Small Receipt</option>
                                            </select>
                                        @elseif($set->key == 'PriceIncludesTax')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 'yes' ? 'selected=""' : '' }} value="yes">
                                                    Yes
                                                </option>
                                                <option {{ $set->value == 'no' ? 'selected=""' : '' }} value="no">No
                                                </option>
                                            </select>
                                        @elseif($set->key == 'POSprinterType')
                                            <select class="form-control" name="{{ $set->key }}">
                                                <option {{ $set->value == 'A4' ? 'selected=""' : '' }} value="A4">A4
                                                </option>
                                                <option {{ $set->value == 'A5' ? 'selected=""' : '' }} value="A5">A5
                                                </option>
                                                <option {{ $set->value == 'receipt' ? 'selected=""' : '' }}
                                                    value="receipt">
                                                    Small Receipt</option>
                                            </select>
                                        @elseif($set->key != 'InvoiceNotes')
                                            <input class="form-control" type="text" name="{{ $set->key }}"
                                                value="{{ old($set->key, $set->value) }}">
                                        @else
                                            <textarea id="editor" class="form-control editor" name="{{ $set->key }}">{{ old($set->key, $set->value) }}</textarea>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('front.save')</button>
                </div>
            </form>
        </div>
    </section>
@stop
@push('js')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
@endpush
