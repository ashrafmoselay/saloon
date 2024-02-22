<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <link rel="stylesheet" href="{{ asset('front/bootstrap') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('front/dist') }}/css/AdminLTE.min.css">
    <link rel="stylesheet" href="{{ asset('front/bootstrap') }}/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{ asset('front/dist') }}/css/AdminLTE-rtl.min.css">
    <style>
        ul li b {
            float: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
        }

        @media print {

            .printHeader {
                display: block !important;
            }

            a[href]:after {
                content: none !important;
                display: none !important;
            }

            .main-footer,
            .dt-buttons,
            .dataTables_filter {
                display: none;
                display: none !important;
            }

            #footer {
                visibility: visible;
                display: none !important;
            }

            a {
                visibility: hidden;
                display: none !important;
            }

            .table {
                border: 1px solid black !important;
                font-weight: bold;
            }

            .table td,
            .table thead tr th {
                border: 1px solid black !important;
            }

            @media print {
                .printHeader {
                    display: block !important;
                }

                table {
                    font-size: {{ $settings['PrintSize'] }}px !important;
                }

                @page {
                    margin: .1cm;
                }

                body {
                    margin: .1cm;
                }

                .panel-default {
                    border: none;
                }

                .hideprint {
                    visibility: hidden;
                    margin: 0;
                    display: none !important;
                }
            }

            html,
            body {
                height: 100vh;
                width: 100vh;
                margin: 0px !important;
                padding-right: 5px !important;
                /*overflow: hidden;*/
            }

            @page {
                size: auto;
                height: auto;
                margin-left: 0cm;
                margin-right: 0px;
                margin-top: 0cm;
                margin-bottom: 0px;
                padding: 0cm !important;
            }
        }

        @media print {

            .col-md-1,
            .col-md-2,
            .col-md-3,
            .col-md-4,
            .col-md-5,
            .col-md-6,
            .col-md-7,
            .col-md-8,
            .col-md-9,
            .col-md-10,
            .col-md-11,
            .col-md-12 {
                float: right;
            }

            .printable {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }

            .col-md-1 {
                width: 8%;
            }

            .col-md-2 {
                width: 16%;
            }

            .col-md-3 {
                width: 25%;
            }

            .col-md-4 {
                width: 33%;
            }

            .col-md-5 {
                width: 42%;
            }

            .col-md-6 {
                width: 50%;
            }

            .col-md-7 {
                width: 58%;
            }

            .col-md-8 {
                width: 66%;
            }

            .col-md-9 {
                width: 75%;
            }

            .col-md-10 {
                width: 83%;
            }

            .col-md-11 {
                width: 92%;
            }

            .col-md-12 {
                width: 100%;
            }
        }

        .ticket.A5,
        table {
            max-width: 21cm;
            width: 21cm;
        }

        .ticket.A4,
        table {
            max-width: 29.7cm;
            width: 29.7cm;
        }
    </style>
</head>

<body class="ticket {{ $settings['printerType'] }}">
    <!-- <div class="row">
            <div class="col-md-12">
                <a class="btn btn-danger pull-right" href="{{ route('orders.index') }}">رجوع</a>
            </div>
        </div> -->
    @php
        $printerType = $settings['printerType'];
        $redirectRoute = route('order.create', ['notpopup' => 'yes']);
        if (request()->has('ispos')) {
            $printerType = $settings['POSprinterType'];
            $redirectRoute = route('pos');
        }
    @endphp
    @if ($printerType == 'receipt')
        @include('orders.receipt')
    @else
        @if ($settings['SiteName_en'] && $settings['Address_en'])
            @include('orders.show2')
        @else
            @include('orders.show')
        @endif
    @endif
    <script>
        window.print();
        window.onafterprint = function() {
            if (!window.close()) {
                window.open('{{ $redirectRoute }}', '_self', '');
            }
        }
    </script>
</body>

</html>
