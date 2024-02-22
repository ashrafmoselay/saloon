@extends('layouts.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('front.edit')
            <small>
                عرض سعر #
                {{ $order->id }}
            </small>
        </h1>
    </section>
    <!-- Main content -->
    <form enctype="multipart/form-data" action="{{ route('offers.update', $order) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        @include('offers._form')
    </form>
@stop
