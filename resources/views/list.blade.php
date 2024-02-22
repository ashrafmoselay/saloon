@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        قائمة المنتجات
        <a class="btn btn-success pull-right" href="#"><i class="fa fa-plus"></i> @lang('front.Add')</a>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
               {{-- <div class="box-header">
                    <h3 class="box-title">Data Table With Full Features</h3>
                </div>--}}
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="dataList" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>@lang('front.name')</th>
                            <th>رقم التليفون</th>
                            <th>السن</th>
                            <th class="no-sort"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>أشرف حسان</td>
                            <td>
                                01061048481
                            </td>
                            <td>29</td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    @lang('front.edit')
                                </a>
                                <a href="#" data-id="" data-csrf='{{ csrf_token() }}'
                                   data-action=""
                                   class="btn btn-danger btn-xs btn-delete-record" data-toggle="tooltip" title="@lang('front.delete')">
                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                    @lang('front.delete')</a>
                                <a href="#" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil fa-search" aria-hidden="true"></i>
                                    عرض
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr class="success">
                            <th colspan="2">اﻷجمالى</th>
                            <th></th>
                            <th class="no-sort"></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('front/plugins')}}/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="{{asset('front/plugins')}}/datatables/buttons.dataTables.min.css">
    <style>
        div.dataTables_paginate {
            text-align: left;
        }
    </style>
@endpush

@push('js')
    <!-- DataTables -->

    <script src="{{asset('front/plugins')}}/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('front/plugins')}}/datatables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('front/plugins')}}/datatables/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="{{asset('front/plugins')}}/datatables/buttons.flash.min.js"></script>
    <script src="{{asset('front/plugins')}}/datatables/jszip.min.js" type="text/javascript"></script>
    <script src="{{asset('front/plugins')}}/datatables/buttons.html5.min.js" type="text/javascript"></script>
    <script src="{{asset('front/plugins')}}/datatables/buttons.print.js" type="text/javascript"></script>
    <script src="{{asset('front/plugins')}}/datatables/sum().js" type="text/javascript"></script>
    <!-- page script -->
    <script>
        $(function () {
            $('#dataList').DataTable( {
                //"ajax": '',
                dom: 'Bfrtip',
                select: true,
                "language": {
                    "url": "{{asset('front/plugins')}}/datatables/Arabic.json"
                },
                buttons: [
                    //{ extend:'copy',text: 'نسخ' },
                    {
                        extend:'excel',
                        text: 'تحميل اكسيل',
                        title:'',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        },
                    },
                    {
                        extend: 'print',
                        text: 'طباعة',
                        title:'',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        },
                        customize: function ( win ) {
                            /*$(win.document.body)
                                .css( 'font-size', '10pt' )
                                .prepend(
                                    '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                                );*/

                            $(win.document.body).find( 'table' )
                                .css( 'direction', 'rtl' );
                        }
                    }
                ],
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Total over this page
                    pageTotal = api
                        .column( 2, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 2 ).footer() ).html(
                        pageTotal +' ( '+ total +' )'
                    );
                }
            } );
        });
    </script>
@endpush