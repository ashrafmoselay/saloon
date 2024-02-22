@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           @lang('front.Not Authorized')
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> @lang('front.home')</a></li>
            <li class="active">@lang('front.error')</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="error-page">
            <h2 class="headline text-red">500</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i>@lang('front.You do not have permission')</h3>

                <p>
                    @lang('front.You should refer to the Admin to give you authority')<br/>
                    @lang('front.Go back to the main page') <a href="/">@lang('front.click here')</a>
                </p>

                <form class="search-form">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.input-group -->
                </form>
            </div>
        </div>
        <!-- /.error-page -->

    </section>
    <!-- /.content -->
@endsection