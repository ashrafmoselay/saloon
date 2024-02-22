<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        {{-- <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('front/dist')}}/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>مرحباً بك يا {{auth()->user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i>  لا إله إلا الله</a>
            </div>
        </div> --}}
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input autocomplete="off" type="text" name="q" class="form-control"
                    placeholder="@lang('front.search')">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">@lang('front.menu')</li>
            <li id="homeLi"><a href="{{ route('home') }}"><i class="fa  fa-home"></i><span>@lang('front.home')</span>
                </a></li>
            @if (auth()->user()->can('pos OrdersController'))
                <li><a href="{{ route('pos') }}"><i class="fa fa-desktop"></i><span> @lang('front.Cashier screen')</span> </a></li>
            @endif
            @if (auth()->user()->can('index ReservationController'))
                <li><a href="{{ route('reservations.index') }}"><i class="fa fa-calendar"></i><span> @lang('front.Reservations')</span> </a></li>
            @endif

            
            @if (auth()->user()->can('index ShipmentsController'))
                <li><a href="{{ route('shipments.index') }}"><i class="fa fa-truck"></i><span>الشحنات</span> </a></li>
                <li><a href="{{ route('shipments.prepare') }}"><i class="fa fa-file"></i><span>تجهيز المحافظات</span>
                    </a></li>
                <li><a href="{{ route('shipments.report') }}?per_page=25&fromdate={{ date('Y-m-d') }}"><i
                            class="fa fa-file"></i><span>تقرير الشحنات</span> </a></li>
            @endif
            @if (auth()->user()->can('index CombinationController'))
                <li><a href="{{ route('combinations.index') }}"><i class="fa fa-dribbble"></i><span>مواصفات الصنف</span>
                    </a></li>
            @endif
            @if (auth()->user()->can('index CompanyController'))
                <li><a href="{{ route('companies.index') }}"><i class="fa fa-truck"></i><span>الشركات</span> </a></li>
            @endif
            @if (auth()->user()->can('getSales OrdersController'))
                <li><a target="_blank" href="{{ route('order.create', ['notpopup' => 'yes']) }}"><i
                            class="fa  fa-calculator"></i><span>@lang('front.Separate POS')</span> </a></li>
            @endif
            @if (auth()->user()->can('clientIndex PersonsController'))
                <li><a href="{{ route('client.index') }}"><i class="fa fa-users"></i> @lang('front.clients')</a></li>
                <li><a href="{{ route('supplier.index') }}"><i class="fa fa-truck"></i>@lang('front.suppliers') </a></li>
            @endif
            @if (auth()->user()->can('create OrdersController'))
                <li><a href="{{ route('order.create', ['notpopup' => 'yes']) }}"><i
                            class="fa  fa-calculator"></i><span>@lang('front.pos')</span> </a></li>
            @endif
            @if (auth()->user()->can('getPurchases OrdersController'))
                <li><a href="{{ route('purchase.create', ['notpopup' => 'yes']) }}"><i class="fa  fa-truck"></i><span>
                            نقطة شراء</span> </a></li>
            @endif
            @if ($settings['industrial'] == 2)
                <li><a href="{{ route('orders.workorders') }}"><i
                            class="fa fa-retweet"></i><span>@lang('front.workorders')</span> </a></li>
            @endif
            @if (auth()->user()->can('index ProductsController') || auth()->user()->can('index StoresController'))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-barcode"></i>
                        <span>@lang('front.products')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if ($settings['industrial'] == 2)
                            <li><a href="{{ route('products.index', ['is_raw' => true]) }}"><i
                                        class="fa fa-hourglass-half"></i> @lang('front.raw materials')</a></li>
                            <li><a href="{{ route('getWorkOrders') }}"><i class="fa fa-hourglass-half"></i>
                                    @lang('front.Manufacturing orders') </a></li>
                        @endif
                        <li><a href="{{ route('products.index') }}"><i class="fa fa-th"></i> @lang('front.products')</a>
                        </li>
                        @if (auth()->user()->can('index ServicesController'))
                            <li><a href="{{ route('services.index') }}"><i class="fa fa-fax"></i>
                                    @lang('front.services')</a></li>
                        @endif
                        @if (auth()->user()->can('generateBarCode ProductsController'))
                            <li><a href="{{ route('products.generateBarCode') }}"><i class="fa fa-barcode"></i>
                                    @lang('front.barcode')</a></li>
                        @endif
                        @if (auth()->user()->can('index MovementsController'))
                            <li><a href="{{ route('movements.index') }}"><i class="fa fa-exchange"></i>
                                    @lang('front.movements')</a></li>
                        @endif
                        @if (auth()->user()->can('index DamagesController'))
                            <li><a href="{{ route('damages.index') }}"><i class="fa fa-trash"></i>
                                    @lang('front.damages')</a></li>
                        @endif
                        <li><a href="{{ route('products.priceList') }}"><i class="fa fa-money"></i> @lang('front.pricelist')
                            </a></li>
                        <li><a href="{{ route('products.priceList2') }}"><i class="fa fa-money"></i> @lang('front.advanced price List')
                            </a></li>
                        <li><a href="{{ route('offers.index') }}"><i class="fa fa-money"></i> @lang('front.Price Offer')
                            </a></li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('index PersonsController'))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>@lang('front.persons')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (auth()->user()->can('clientIndex PersonsController'))
                            <li><a href="{{ route('client.index') }}"><i class="fa fa-users"></i>
                                    @lang('front.clients')</a></li>
                        @endif
                        <li><a href="{{ route('client.getCalander') }}"><i class="fa  fa-money"></i>
                                @lang('front.Installments')</a></li>
                        <li><a href="{{ route('client.index', ['isdebt' => true]) }}"><i
                                    class="fa fa-calendar-minus-o"></i> @lang('front.debt')</a></li>
                        <li><a href="{{ route('persons.payments', ['fromdate' => date('Y-m-d')]) }}"><i
                                    class="fa fa-money"></i> @lang('front.clients payments')</a></li>

                        <li><a href="{{ route('supplier.index') }}"><i class="fa fa-truck"></i>@lang('front.suppliers') </a>
                        </li>
                        <li><a href="{{ route('supplier.index', ['isdebt' => true]) }}"><i
                                    class="fa fa-truck"></i>@lang('front.suppliersdebt') </a></li>
                        <li><a href="{{ route('employees.index') }}"><i class="fa fa-user"></i> @lang('front.employees')</a>
                        </li>
                        <li><a href="{{ route('partners.index') }}"><i class="fa fa-paw"></i> @lang('front.partners') </a>
                        </li>

                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('getSales OrdersController'))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-list-alt"></i>
                        <span>@lang('front.invoices')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (auth()->user()->can('getSales OrdersController'))
                            <li><a href="{{ route('orders.index') }}"><i class="fa fa-line-chart"></i>
                                    @lang('front.orders')</a></li>
                            <li><a href="{{ route('orders.details') }}"><i class="fa fa-search-plus"></i>
                                    @lang('front.orderdetails')</a></li>
                            <li><a href="{{ route('ordersReturn.index') }}"><i class="fa fa-share-square-o"></i>
                                    @lang('front.ordersreturns')</a></li>
                        @endif
                        @if (auth()->user()->can('getPurchases OrdersController'))
                            <li><a href="{{ route('purchases.index') }}"><i
                                        class="fa fa-calendar-check-o"></i>@lang('front.purchases')</a></li>
                            <li><a href="{{ route('purchasesReturn.index') }}"><i class="fa fa-share-square"></i>
                                    @lang('front.purchasereturns')</a></li>
                            <li><a href="{{ route('persons.getClientSupplier') }}"><i
                                        class="fa fa-desktop"></i>@lang('front.clientandsupplier')</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('index ExpensesController'))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        <span>@lang('front.finance')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (auth()->user()->can('addPayment PersonsController'))
                            <li><a href="{{ route('persons.addTransaction', 'client') }}"><i class="fa fa-money"></i>
                                    سند قبض</a></li>
                        @endif
                        @if (auth()->user()->can('addPayment PersonsController'))
                            <li><a href="{{ route('persons.addTransaction', 'supplier') }}"><i
                                        class="fa fa-money"></i> سند صرف</a></li>
                        @endif
                        @if (auth()->user()->can('index ExpensesController'))
                            <li><a href="{{ route('expenses.index') }}"><i class="fa fa-money"></i>
                                    @lang('front.expenses')</a></li>
                        @endif
                        @if (auth()->user()->can('index TresuryTranactionsController'))
                            <li><a href="{{ route('tresurycurrency', 2) }}"><i
                                        class="fa fa-money"></i>@lang('front.treasury')</a></li>
                        @endif
                        @if (auth()->user()->can('index BanksController'))
                            <li><a href="{{ route('banks.index') }}"><i
                                        class="fa fa-credit-card"></i>@lang('front.bankaccounts')</a></li>
                        @endif
                        <li><a href="{{ route('currencies.index') }}"><i
                                    class="fa fa-bitcoin"></i>@lang('front.currency')</a></li>
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('dailyreport HomeController'))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-file"></i>
                        <span>@lang('front.reports')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('orders.report') }}"><i class="fa fa-line-chart"></i>
                                @lang('front.sales report')</a></li>
                        <li><a href="{{ route('purchase.report') }}"><i class="fa fa-file"></i>
                                @lang('front.Purchase report')</a></li>
                        <li><a href="{{ route('expenses.report') }}"><i class="fa fa-money"></i>
                                @lang('front.Expense report')</a></li>
                        <li><a href="{{ route('ordersReturn.index') }}"><i class="fa fa-share-square-o"></i>
                                @lang('front.ordersreturns')</a></li>
                        <li><a href="{{ route('generaltaxreturnreport') }}?fromdate={{ date('Y-m-01') }}"><i
                                    class="fa fa-file"></i> @lang('front.General tax return report')</a></li>
                        <li><a href="{{ route('purchasesReturn.index') }}"><i class="fa fa-share-square"></i>
                                @lang('front.purchasereturns')</a></li>
                        <li><a href="{{ route('persons.getClientSupplier') }}"><i
                                    class="fa fa-desktop"></i>@lang('front.clientandsupplier')</a></li>
                        <li><a href="{{ route('dailyreport', ['fromdate' => date('Y-m-d')]) }}"><i
                                    class="fa fa-calendar-check-o"></i>@lang('front.dailyreport')</a></li>
                        <li><a href="{{ route('profit') }}"><i class="fa fa-line-chart"></i>@lang('front.profitreport')</a>
                        </li>
                        <li><a href="{{ route('gprofit') }}"><i class="fa fa-line-chart"></i>تقرير الأرباح الفعلى</a>
                        </li>
                        <li><a href="{{ route('products.report') }}"><i
                                    class="fa fa-barcode"></i>@lang('front.productsreport')</a></li>
                        <li><a href="{{ route('products.report', ['is_service' => 1]) }}"><i
                                    class="fa fa-fax"></i>@lang('front.servicesreport')</a></li>
                        <li><a href="{{ route('products.getCriticalQuantity') }}"><i class="fa fa-battery-1"></i>
                                @lang('front.requiredproducts')</a></li>
                        <li><a href="{{ route('regionsReport') }}"><i class="fa fa-area-chart"></i>
                                @lang('front.regions report')</a></li>
                        <li>
                            <a class="hide" href="{{ route('representativesReport') }}"><i
                                    class="fa fa-truck"></i> @lang('front.debts representatives') </a>
                            <a href="{{ route('employees.getSalesManReport') }}"><i class="fa fa-truck"></i> تقرير
                                المناديب</a>
                        </li>
                        <li>
                            <a href="{{ route('representativesSalesReport') }}"><i class="fa fa-truck"></i>
                                @lang('front.Sales representatives')</a>
                        </li>


                        @if ($settings['industrial'] == 2)
                            <li>
                                <a href="{{ route('allworkorders') }}"><i class="fa fa-truck"></i>
                                    @lang('front.Manufacturing Report')</a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('summery') }}"><i class="fa fa-file"></i> @lang('front.summery report')</a>
                        </li>
                        <li><a href="{{ route('logs') }}"><i class="fa fa-history"></i>@lang('front.Activity Log')</a></li>

                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('index UsersController'))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-lock"></i>
                        <span>@lang('front.Users and Roles')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (auth()->user()->can('index RolesController'))
                            <li><a href="{{ route('roles.index') }}"><i
                                        class="fa fa-user-secret"></i>@lang('front.roles')</a></li>
                        @endif
                        @if (auth()->user()->can('index UsersController'))
                            <li><a href="{{ route('users.index') }}"><i
                                        class="fa fa-users"></i>@lang('front.users')</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('index SettingController'))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-book"></i>
                        <span>@lang('front.System Setup')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('regions.index') }}"><i class="fa fa-map-marker"></i>
                                @lang('front.regions')</a>
                        </li>
                        @if (auth()->user()->can('index UnitsController'))
                            <li><a href="{{ route('units.index') }}"><i class="fa fa-cubes"></i>
                                    @lang('front.units')</a></li>
                        @endif
                        @if (auth()->user()->can('index StoresController'))
                            <li><a href="{{ route('stores.index') }}"><i class="fa fa-bank"></i>
                                    @lang('front.stores')</a></li>
                        @endif
                        @if (auth()->user()->can('index CategoriesController'))
                            <li><a href="{{ route('category.index') }}"><i
                                        class="fa fa-qrcode"></i>@lang('front.categories')</a></li>
                        @endif
                        @if (auth()->user()->can('index ExpensesTypeController'))
                            <li><a href="{{ route('expensesType.index') }}"><i class="fa fa-money"></i>
                                    @lang('front.ExpensesTypeController')</a></li>
                        @endif
                        @if (auth()->user()->can('index DamageOptionController'))
                            <li><a href="{{ route('damageOptions.index') }}"><i class="fa fa-list"></i>
                                    @lang('front.damageOptions')</a></li>
                        @endif
                    </ul>
                </li>
            @endif


            @if (auth()->user()->can('index SettingController'))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                        <span>@lang('front.settings')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('setting.index') }}"><i class="fa fa-cog"></i>@lang('front.settings')</a>
                        </li>
                        <li><a href="{{ route('backup') }}"><i class="fa fa-database"></i>@lang('front.backup')</a></li>
                        <li><a href="{{ route('restore') }}"><i class="fa fa-database"></i>@lang('front.restore')</a>
                        </li>
                        <li><a class="showAlertWarning" href="{{ route('closeYear') }}"><i
                                    class="fa fa-calendar"></i>@lang('front.closeyear')</a></li>
                        <li><a href="{{ route('clearCache') }}"><i class="fa fa-eraser"></i>@lang('front.clearcache')</a>
                        </li>
                        <li><a href="{{ route('migrate') }}"><i class="fa fa-copy"></i>@lang('front.migrate')</a></li>
                        @if (isset($settings['onlineurl']) && $settings['onlineurl'])
                            <li><a href="{{ route('sync') }}"><i class="fa fa-upload"></i>@lang('front.sync') </a>
                            </li>
                        @endif
                        <li><a href="{{ route('updateProductPricePersent') }}"><i class="fa fa-percent"></i>تطبيق
                                نسبة زيادة السعر</a></li>
                        <li><a class="showAlertWarning" href="{{ route('cleanDB') }}"><i
                                    class="fa fa-trash-o"></i>@lang('front.cleandb') </a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
