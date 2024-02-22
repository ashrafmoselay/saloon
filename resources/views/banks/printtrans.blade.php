@extends('layouts.app')
@section('title','تفاصيل العملية')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header hideprint">
            <h1>
                تفاصيل العملية رقم

                <small>
                    {{$transaction->id}}
                </small>
                <a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print();" role="button">
                    <i class="fa fa-print" aria-hidden="true"></i> طباعة
                </a>
                <button id="pdf-button" class="btn btn-success print-window pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> تحميل PDF</button>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body box-success">
                            @include('layouts.partial.printHeader')
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="printInvoice" class="box" style="border: none;">
                                        <table class="table table-bordered table-striped">
                                            <tr style="height: 40px;">
                                                <td colspan="2">
                                                    <h4>
                                                        سند  {{$transaction->type==1?'صرف':'قبض'}}
                                                    </h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>رقم الإيصال:</td>
                                                <td>{{  $transaction->id }}</td>
                                            </tr>
                                            <tr>
                                                <td>التاريخ:</td>
                                                <td>{{  $transaction->date_ar }}</td>
                                            </tr>
                                            <tr>
                                                <td>الوقت:</td>
                                                <td>{{  $transaction->time_ar }}</td>
                                            </tr>
                                            <tr>
                                                <td>البيان:</td>
                                                <td>{{  $transaction->note }}</td>
                                            </tr>
                                            <tr>
                                                <td>المبلغ:</td>
                                                <td>
                                                    {{ $transaction->value }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>المسئول:</td>
                                                <td>{{ optional($transaction->creator)->name }}</td>
                                            </tr>
                                            @if($transaction->model instanceof \App\Models\Invoice)
                                                <tr>
                                                    <td>رقم الفاتورة:</td>
                                                    <td>{{ $transaction->model->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td>اسم العميل:</td>
                                                    <td>{{ optional($transaction->model->client)->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>الإجمالى:</td>
                                                    <td>{{ $transaction->model->total }}</td>
                                                </tr>
                                                <tr>
                                                    <td>إجمالى المدفوعات:</td>
                                                    <td>{{ $transaction->model->total_paid }}</td>
                                                </tr>
                                                <tr>
                                                    <td>إجمالى المتبقى:</td>
                                                    <td>{{ $transaction->model->total_due }}</td>
                                                </tr>
                                            @endif
                                            @if($transaction->model instanceof \App\Models\Purchase)
                                                <tr>
                                                    <td>رقم الفاتورة:</td>
                                                    <td>{{ $transaction->model->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td>اسم المورد:</td>
                                                    <td>{{ optional($transaction->model->supplier)->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>الإجمالى:</td>
                                                    <td>{{ $transaction->model->total }}</td>
                                                </tr>
                                                <tr>
                                                    <td>إجمالى المدفوعات:</td>
                                                    <td>{{ $transaction->model->total_paid }}</td>
                                                </tr>
                                                <tr>
                                                    <td>إجمالى المتبقى:</td>
                                                    <td>{{ $transaction->model->total_due }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                        <div style="border: 1px solid #000;height: 140px;width: 200px;border-radius: 50%;float: left;margin-top:10px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@stop
@push('css')
    <style>

        .printHeader{
            display: none;
        }
        tr td{
            vertical-align: middle!important;
            font-weight: bold;
            font-size: 14px;
        }
        #printInvoice .table tr>td{
            text-align: right;
            border:1px solid #000!important;
        }
        #printInvoice .table thead tr>td,.table thead tr>th{
            font-weight: bold;
        }
        @media print {

            .printHeader{
                display: block!important;
            }
            a[href]:after {
                content: none !important;display: none !important;
            }
            .main-footer,.dt-buttons,.dataTables_filter{
                display: none ;display: none !important;
            }

            #footer{visibility: visible;display: none !important;}
            a{
                visibility:hidden;display: none !important;
            }
            .table {
                border: 1px solid black !important;
                font-weight: bold;
            }
            .table td,.table thead tr th {
                border: 1px solid black !important;
            }
            @media print {
                .printHeader{
                    display: block!important;
                }
                table  {
                    font-size: 13px !important;
                }
                @page
                {
                    size: auto;   /* auto is the initial value */

                    /* this affects the margin in the printer settings */
                    margin: 7mm 3mm 7mm 3mm;
                }

                body
                {
                    margin: 5mm;
                }
                .panel-default{
                    border: none;
                }
                .hideprint{
                    visibility:hidden;
                    margin:0;
                    display: none !important;
                }
            }

        }
        #printInvoice .table tr>td .trhead{
            text-align: right!important;
            border: 1px dashed #000!important;
            font-size: 16px!important;
            font-weight: bold!important;
        }
    </style>
@endpush
