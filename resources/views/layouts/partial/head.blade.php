<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @yield('title',config('developer.appname_'.App::getLocale()))
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    {{-- <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'> --}}

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <meta name="mobile-web-app-title" content="SAHAL" />

    <link rel="shortcut icon" sizes="16x16" href="/favicon-16x16.png">
    <link rel="shortcut icon" sizes="196x196" href="/android-chrome-192x192.png">
    <link rel="apple-touch-icon-precomposed" href="/apple-touch-icon.png">

    <link rel="manifest" href="/manifest.json" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-status-bar-style" content="black" />
    <!-- Bootstrap 3.3.6 -->

    {{--<link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/bootstrap-rtl.min.css">--}}
    <link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/animate.css">
    <link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/bootstrapValidator.min.css">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('front/plugins')}}/daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('front/plugins')}}/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('front/plugins')}}/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{asset('front/plugins')}}/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{asset('front/plugins')}}/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('front/plugins')}}/select2/select2.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('front/dist')}}/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('front/dist')}}/css/ionicons.min.css">


    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('front/dist')}}/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{{asset('front/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('front/plugins')}}/datatables2/dataTables.bootstrap.css">
    <link rel="stylesheet" href="{{asset('front/plugins')}}/datatables2/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('front/plugins')}}/datatables2/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('front/plugins')}}/datatables2/responsive.bootstrap.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('front/dist')}}/css/AdminLTE.min.css">
    @if(App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="{{asset('front/dist')}}/css/AdminLTE-rtl.min.css">
    @endif
    {{--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">--}}
    <link rel="stylesheet" href="{{asset('front')}}/sweetalert.css">
    @if(!request()->is('products/generateBarCode'))
        <style>

            @media print {
                table{
                    max-width: 100%!important;
                }
                .printHeader{
                    display: block!important;
                }
                .table-bordered{
                    margin-bottom: 0px!important;
                }
                a[href]:after {
                    content: none !important;
                }
                .main-footer,.dt-buttons,.dataTables_filter{
                    display: none ;
                }

                #footer{visibility: visible;}
                a{
                    visibility:hidden;
                }
                .box{
                    border-top:none!important;
                }
                .table {
                    border: 1px solid #020202 !important;
                }
                .table td,.table th {
                    border: 1px solid #020202 !important;
                }
                @media print {
                    .printHeader{
                        display: block!important;
                    }
                    table  {
                        font-size: {{$settings['PrintSize']}}px !important;
                        page-break-after:auto;
                    }
                    tr    { page-break-inside:avoid; page-break-after:auto }
                    td    { page-break-inside:avoid; page-break-after:auto }
                    thead { display:table-header-group;page-break-inside: avoid; }
                    tfoot { display:table-footer-group }

                    @page { margin: .1cm; }
                    body { margin: .1cm;}
                    .panel-default{
                        border: none;
                    }
                    .hideprint{
                        visibility:hidden;
                        margin:0;
                    }
                }
                .dataTables_length,.box-tools,.dataTables_info,.table.dataTable thead .sorting:after,.table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after
                {
                    display: none!important;
                }
                .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>th, .table>caption+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>td, .table>thead:first-child>tr:first-child>td {
                    text-align: center;
                }
                html, body {
                    height:max-content;
                    width: 100vh;
                    margin: 0 !important;
                    padding: 0 !important;
                }

            }
        </style>

    @endif
    <style>
        .shipmentCompany{
            display: {{isset($settings['show_shipment_company']) && $settings['show_shipment_company']==1?'revert':'none'}}
        }
        .tfawdshow{
            display: {{isset($settings['show_shipment_company']) && $settings['show_shipment_company']==1?'block':'none'}}
        }
        .dataTables_processing {
            font-size: 30px!important;
            font-weight: bold;
            color: #4267b2;
        }
        .table {
            border: 1px solid #020202 !important;

        }
        .table td,.table th {
            border: 1px solid #020202 !important;
        }
        .table thead tr>td {
            text-align: center!important;
            vertical-align: middle!important;
        }
        a:hover {
            text-decoration: none;
        }
        @media print {
            .hideprint {
                visibility: hidden;
                display: none;
                margin: 0;
            }
            #footer,footer{display: none;margin: 0}

            tfoot tr td{
                border: none!important;
            }
        }
        div.dataTables_paginate {
            text-align: left;
        }
        .datepicker.dropdown-menu{
            right:initial;
        }
        .modal-open .select2-dropdown {
            z-index: 10060;
        }

        .modal-open .select2-close-mask {
            z-index: 10055;
        }
        .unitclass{
            width: 100%;
            border: none;
            background: transparent;
            padding: 0 8px;
            outline: 0;
        }
        .unit.input-group-addon:last-child {
            padding: 0;
            min-width: 80px;
        }
        .sidebar-menu .treeview-menu li.active {
            background-color: #3c763c;
        }
        .modal-fullscreen .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .modal-fullscreen .modal-content {
            height: auto;
            min-height: 100%;
            border: 0 none;
            border-radius: 0;
        }
        .slimScrollBar{
            width: 8px!important;
            background:#3c8dbc!important;


        }
        /*div#dataList_wrapper div#dataList_filter{
            position: absolute;
            top: 0.6%;
            right: 20%;
        }
        .dataTables_wrapper .dataTables_filter {
            position: absolute;
            top: 1%;
            right: 23%;
        }*/


        .tt-dataset.tt-dataset-products {
            z-index: 10000;
            overflow: scroll;
            width: 750px;
            background: #eee;
            font-weight: bold;
        }
        aside.main-sidebar {
            overflow: hidden !important;
            overflow-y: auto !important;
            height: 100vh;
        }
        .s-header{
            background: #337ab7;
            color: #fefefe;
            font-weight: bold;
        }
        .s-row {
            display: table-row;
        }
        .s-cell {
            display: table-cell;
            padding: 5px;
            border: 1px solid black;
        }
        .tt-menu {
            width: auto;
        }

        .tt-dataset {
            display: table;
            width: 700px!important;
            z-index: 100000;
        }
        .loader{
            position: relative;
            float: left;
            z-index: 1000;
            color: #3c8dbc;
            font-size: 30px!important;
            left: 60px;
        }
        .table td.fit,
        .table th.fit {
            white-space: nowrap;
            width: 1%;
        }
    </style>
    @stack('css')
    <style>
        .tt-menu {
            max-height: 500px!important;
            overflow-x: hidden!important;
            overflow-y: auto!important;
            width: 720px!important;
            background-color: #ffffff!important;
            right: -50px!important;
        }
    </style>
    @include('layouts.partial.custom_style')
    <style>
        button#pdf-button {
            margin-left: 10px;
        }
        @media print {
            @page {
                size: auto;
                height:auto;
                margin-left: 0.2cm;
                margin-right: 0.2cm;
                margin-top: 0.2cm;
                margin-bottom: 1cm;
                padding: 0cm!important;
                counter-increment: page;
                counter-reset: page 1;
            }
            #page-footer::before {
                content: "Page " counter(page);
                display: block;
                text-align: center;
            }
            #page-footer a {
                display: none;
            }
        }
    </style>
</head>
