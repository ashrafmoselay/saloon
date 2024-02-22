@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('front.Add')
            <small>
                @lang('front.offers')
            </small>
        </h1>
    </section>
    <!-- Main content -->
    <form action="{{ route('offers.store') }}" method="post">
        {{ csrf_field() }}
        @include('offers._form')
    </form>
@stop
