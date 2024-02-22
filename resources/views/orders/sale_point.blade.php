@extends('layouts.app')

@section('content')
    @php
        $useMarket = false;
        if($settings['sales_marketer']==1 && $type=='sales'){
            $useMarket = true;
        }
    @endphp
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('front.Add')
            <small>
                @if($type=='sales')
                    @lang('front.order')
                @else
                    @lang('front.purchase')
                @endif
            </small>
         </h1>

    </section>
    <!-- Main content -->
    <form action="{{route('orders.store')}}" method="post">
        {{ csrf_field() }}
        @include('orders._form',['notModal'=>true])
    </form>

    @include('orders.calander')
    @include('orders.dicounts_bounse')
@stop
@push('js')
    @include('orders.js')
@endpush
@push('css')
    <style>
        div.dataTables_paginate {
            text-align: left;
        }
        #myModal .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #myModal .modal-content {
            height: auto;
            min-height: 100%;
            border: 0 none;
            border-radius: 0;
        }
        .typeahead {
            z-index: 1051;
            direction: rtl;
        }

        .twitter-typeahead {
            width: 100%;
            height: 28px;
        }
        .tt-query {
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }

        .tt-hint {
            color: #999
        }

        .tt-menu {    /* used to be tt-dropdown-menu in older versions */
            width: 100%;
            margin-top: 2px;
            padding: 4px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
            -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
            box-shadow: 0 5px 10px rgba(0,0,0,.2);
        }

        .tt-suggestion {
            padding: 3px 20px;
            line-height: 24px;
            direction: rtl;
        }

        .tt-suggestion.tt-cursor,.tt-suggestion:hover {
            color: #fff;
            background-color: #0097cf;

        }

        .tt-suggestion p {
            margin: 0;
        }

    </style>
@endpush
