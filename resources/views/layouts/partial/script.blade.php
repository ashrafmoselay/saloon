<div rel="flipInX" id="myModal" class="modal" style="overflow-x:hidden;overflow-y: scroll;z-index: 100000;"
    role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center">
                <div class="fa-3x text-center">
                    <i class="fa fa-cog fa-spin"></i>
                    @lang('front.Loading ....')
                </div>
                </p>
            </div>
        </div>
    </div>
</div>
<div rel="flipInY" id="myModalDeveloper" class="modal" style="overflow-x:hidden;overflow-y: scroll;" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center">
                <div class="fa-3x text-center">
                    <i class="fa fa-cog fa-spin"></i>
                    @lang('front.Loading ....')
                </div>
                </p>
            </div>
        </div>
    </div>
</div>
<div rel="fadeInDown" id="addPersonModal" class="modal" style="overflow:auto;" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center">
                <div class="fa-3x text-center">
                    <i class="fa fa-cog fa-spin"></i>
                    @lang('front.Loading ....')
                </div>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- jQuery 2.2.3 -->
<script src="{{ asset('front/plugins') }}/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('front/bootstrap') }}/js/bootstrap.min.js"></script>

<script src="{{ asset('front/plugins/typeahead') }}/bloodhound.min.js"></script>
<script src="{{ asset('front/plugins/typeahead') }}/typeahead.jquery.js"></script>
<!-- FastClick -->
<script src="{{ asset('front/plugins') }}/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('front/dist') }}/js/app.min.js"></script>
<!-- Sparkline -->
{{-- <script src="{{asset('front/plugins')}}/sparkline/jquery.sparkline.min.js"></script> --}}
<!-- jvectormap -->
{{-- <script src="{{ asset('front/plugins') }}/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> --}}
{{-- <script src="{{ asset('front/plugins') }}/jvectormap/jquery-jvectormap-world-mill-en.js"></script> --}}
<!-- SlimScroll 1.3.0 -->
<script src="{{ asset('front/plugins') }}/slimScroll/jquery.slimscroll.min.js"></script>


<script src="{{ asset('front/plugins') }}/select2/select2.full.min.js"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('front/plugins') }}/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('front/plugins') }}/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('front/plugins') }}/iCheck/icheck.min.js"></script>
<script src="{{ asset('front/datepicker-ar.js') }}"></script>

<!-- DataTables -->

{{-- <script src="{{asset('front/plugins')}}/datatables2/jquery.dataTables.min.js"></script> --}}
<script type="text/javascript" language="javascript"
    src="{{ asset('front/plugins') }}/datatables2/jquery.dataTables1.10.19.min.js"></script>
<script src="{{ asset('front/plugins') }}/datatables2/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('front/plugins') }}/datatables2/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="{{ asset('front/plugins') }}/datatables2/buttons.flash.min.js"></script>
<script src="{{ asset('front/plugins') }}/datatables2/jszip.min.js" type="text/javascript"></script>
<script src="{{ asset('front/plugins') }}/datatables2/buttons.html5.min.js" type="text/javascript"></script>
<script src="{{ asset('front/plugins') }}/datatables2/buttons.print.js" type="text/javascript"></script>
{{-- <script src="{{asset('front/plugins')}}/datatables2/sum().js" type="text/javascript"></script> --}}
<script src="{{ asset('front/plugins') }}/datatables2/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="{{ asset('front/plugins') }}/datatables2/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="{{ asset('front/plugins') }}/datatables2/responsive.bootstrap.min.js" type="text/javascript"></script>

{{-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script> --}}

<script src="{{ asset('front/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('front/bootstrap') }}/js/validator.js" type="text/javascript"></script>
<script src="{{ asset('front') }}/sweetalert.min.js" type="text/javascript"></script>

<script src="{{ asset('front') }}/pdf/jspdf.min.js"></script>
<script src="{{ asset('front') }}/pdf/html2canvas.min.js"></script>
@stack('dataTableJs')
<script>
    function getPriceWithoutTax(originalPrice) {
        var tax = parseFloat("{{ $settings['taxValue'] ?? 0 }}");
        originalPrice = parseFloat(originalPrice);
        tax = tax / 100;
        var taxplusone = 1 + tax;
        orignalValue = originalPrice / taxplusone;
        var taxvalue = orignalValue * tax;
        var value = originalPrice - taxvalue;
        value = parseFloat(value).toFixed(2);
        return value;
    }

    function getUrlVars() {
        var vars = [],
            hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
    var curday = function(sp) {
        var date = "";
        var from = getUrlVars()['fromdate'];
        var to = getUrlVars()['todate'];

        if (from != undefined && from) {
            date = from + " | " + to;
        } else {
            today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //As January is 0.
            var yyyy = today.getFullYear();

            if (dd < 10) dd = '0' + dd;
            if (mm < 10) mm = '0' + mm;
            date = (dd + sp + mm + sp + yyyy);
        }
        return date;
    };
    if ($('.dataTableList').length) {

        function formatQueryString(d) {
            var info = $('.dataTableList').DataTable().page.info();
            d.fromdate = $("#fromdate").val();
            d.todate = $("#todate").val();
            d.priceType = $("#priceType").val();
            d.client_id = $("#client_id").val();
            d.keyword = $("#keyword").val();
            d.status = $("#status").val();
            d.employee_id = $("#employee_id").val();
            d.product_id = $("#product_id").val();
            
            d.pageDisplayStart = (info.page) * info.length;
            return d;
        }
        var startDisplay = 0;
        @if (session()->has('page_display_start'))
            startDisplay = "{{ session('page_display_start') }}";
        @endif
        var table = $('.dataTableList').DataTable({
            dom: 'Blfrtip', //Blfrtip if need to show lengthMenu Bfrtip
            pageLength: 25,
            displayStart: startDisplay,
            //responsive: true,
            lengthMenu: [
                [25, 50, 100, 200, 500, 800, -1],
                [25, 50, 100, 200, 500, 800, "@lang('front.all')"]
            ],
            //select: true,
            //"order": [[ 0, "DESC" ]],
            "language": {
                "url": "{{ \Session::get('locale') == 'ar' ? asset('front/plugins/datatables2/Arabic.json') : '' }}"
            },
            //"order": [[0, "desc" ]],
            buttons: [
                //{ extend:'copy',text: 'نسخ' },
                {
                    extend: 'excel',
                    text: "@lang('front.excel')",
                    title: "@lang('front.list') " + document.title,
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    },
                },
                {
                    extend: 'print',
                    footer: true,
                    text: "@lang('front.print')",
                    title: '',
                    repeatingHead: {
                        logo: "{{ $settings['logo'] ? \Illuminate\Support\Facades\Storage::url($settings['logo']) : '' }}",
                        //logoPosition: 'left',
                        logoStyle: 'width:180px;margin-right: 10px; margin-top: -5px;position: absolute;top:35px;left:10px;',
                        title: '<div style="font-weight: bold;width:100%"><div style="float:right;"><h4 style="line-height: 30px;">{{ $settings['SiteName'] }}<br/>{{ $settings['Address'] }}<br/>{{ $settings['mobile'] }}<br/>تاريخ الطباعه: ' +
                            curday('-') + '<br/> مسئول الطباعه: {{ auth()->user()->name }}</h4></div>' +
                            '<h4 style="font-weight: bold;width:75%" >@lang('front.list') ' + document.title +
                            '</h4></div>',
                    },
                    exportOptions: {
                        stripHtml: false,
                        columns: 'th:not(:last-child)'
                    },
                    customize: function(win) {
                        var tit = $(win.document.body).find('.boxTiT').html();
                        if (tit != undefined)
                            $(win.document.body).find('h4:last').after('<h4 class="text-center">' +
                                tit + '</h4>');
                        $(win.document.body).find('table').css('direction', 'rtl');

                        /* setTimeout(function () {
                             win.print();
                         }, 300);
                         return true;*/
                    },
                    action: function(e, dt, button, config) {
                        $("head").append(
                            '<style>@media print { html, body {overflow: hidden; } } </style>');
                        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        /*setTimeout(function(){
                            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        }, 1000);*/
                    }
                }
            ],
            /* "columnDefs": [ {
                 "targets": 'no-sort',
                 "orderable": false,
             } ],*/
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
            serverSide: true,
            deferRender: true,
            orderClasses: false,
            displayStart: startDisplay,
            ajax: {
                url: pageUrl,
                data: function(d) {
                    return formatQueryString(d);
                },
                /*data: function (d) {
                    d.order[0].column = d.columns[d.order[0].column].name;

                },*/
                "dataSrc": function(json) {
                    if ($("#sumPriceOne").length && json.sumPriceOne) {
                        var t = parseFloat(json.sumPriceOne).toFixed(2);
                        $("#sumPriceOne").html(t);
                    } else {
                        $("#sumPriceOne").closest('.bg-yellow').hide();
                    }
                    if ($("#sumPriceOneGomla").length && json.sumPriceOneGomla) {
                        var t = parseFloat(json.sumPriceOneGomla).toFixed(2);
                        $("#sumPriceOneGomla").html(t);
                    }
                    if ($("#sumPriceOneGomlaGomla").length && json.sumPriceOneGomlaGomla) {
                        var t = parseFloat(json.sumPriceOneGomlaGomla).toFixed(2);
                        $("#sumPriceOneGomlaGomla").html(t);
                    }
                    if ($("#totalOrder").length && json.totalOrder) {
                        var t = parseFloat(json.totalOrder).toFixed(2);
                        $("#totalOrder").html(t);
                        $(".totalorder").html(t);
                    }
                    if ($(".totalpaid").length && json.totalpaid) {
                        var t = parseFloat(json.totalpaid).toFixed(2);
                        $(".totalpaid").html(t);
                    }
                    if ($(".totaldue").length && json.totaldue) {
                        var t = parseFloat(json.totaldue).toFixed(2);
                        $(".totaldue").html(t);
                    }
                    if ($(".totaldiscount").length && json.dicount_value) {
                        var t = parseFloat(json.dicount_value).toFixed(2);
                        $(".totaldiscount").html(t);
                    }
                    if ($(".cashOrders").length && json.cashOrders) {
                        var t = parseFloat(json.cashOrders).toFixed(2);
                        $(".cashOrders").html(t);
                    }
                    if ($(".postPaidOrders").length && json.postPaidOrders) {
                        var t = parseFloat(json.postPaidOrders).toFixed(2);
                        $(".postPaidOrders").html(t);
                    }
                    if ($(".visaOrders").length && json.visaOrders) {
                        var t = parseFloat(json.visaOrders).toFixed(2);
                        $(".visaOrders").html(t);
                    }
                    if ($(".linkTransferOrders").length && json.linkTransferOrders) {
                        var t = parseFloat(json.linkTransferOrders).toFixed(2);
                        $(".linkTransferOrders").html(t);
                    }
                    if ($("#count").length && json.count) {
                        var t = parseFloat(json.count);
                        $("#count").html(t);
                    }
                    return json.data;
                }
            },
            columns: columns
        });
        new $.fn.dataTable.FixedHeader(table);
    }
    if ($('#dataList').length || $('.dataTableTT').length) {
        var table = $('#dataList,.dataTableTT').DataTable({
            //"ajax": '',
            dom: 'Blfrtip', //Blfrtip if need to show lengthMenu
            pageLength: 25,
            lengthMenu: [
                [25, 50, 100, 500, -1],
                [25, 50, 100, 500, "@lang('front.all')"]
            ],
            responsive: true,
            select: true,
            processing: false,
            "language": {
                "url": "{{ \Session::get('locale') == 'ar' ? asset('front/plugins/datatables2/Arabic.json') : '' }}"
            },
            buttons: [
                //{ extend:'copy',text: 'نسخ' },
                {
                    extend: 'excel',
                    text: "@lang('front.excel')",
                    title: "@lang('front.list') " + document.title,
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    },
                },
                {
                    extend: 'print',
                    footer: true,
                    text: "@lang('front.print')",
                    title: '',
                    repeatingHead: {
                        logo: "{{ $settings['logo'] ? \Illuminate\Support\Facades\Storage::url($settings['logo']) : '' }}",
                        //logoPosition: 'left',
                        logoStyle: 'width:180px;margin-right: 10px; margin-top: -5px;position: absolute;top:35px;left:10px;',
                        title: '<div style="font-weight: bold;width:100%"><div style="float:right;"><h4 style="line-height: 30px;">{{ $settings['SiteName'] }}<br/>{{ $settings['Address'] }}<br/>{{ $settings['mobile'] }}<br/>تاريخ الطباعه: ' +
                            curday('-') + '<br/> مسئول الطباعه: {{ auth()->user()->name }}</h4></div>' +
                            '<h4 style="font-weight: bold;margin-right:400px;" >@lang('front.list') ' +
                            document.title + '</h4></div>',
                    },
                    exportOptions: {
                        stripHtml: false,
                        columns: 'th:not(:last-child)'
                    },
                    customize: function(win) {
                        var tit = $(win.document.body).find('.boxTiT').html();
                        if (tit != undefined)
                            $(win.document.body).find('h4:last').after('<h4 class="text-center">' +
                                tit + '</h4>');
                        $(win.document.body).find('table').css('direction', 'rtl');

                        /* setTimeout(function () {
                             win.print();
                         }, 300);
                         return true;*/
                    },
                    action: function(e, dt, button, config) {
                        $("head").append(
                            '<style>@media print { html, body {overflow: hidden; } } </style>');
                        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        /*setTimeout(function(){
                            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        }, 1000);*/
                    }
                }
            ],
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }],
        });
        new $.fn.dataTable.FixedHeader(table);
        var page = "{{ request('page') }}";
        if (page) {
            setTimeout(function() {
                $('a[data-dt-idx="' + page + '"]').trigger('click');
            }, 500);
        }

    }
    @if (session()->has('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if (session()->has('alert-success'))
        //toastr.success("{{ session('alert-success') }}");
        swal("@lang('front.success!')", "{{ session('alert-success') }}", "success");
    @elseif (session()->has('alert-danger'))
        //toastr.error("{{ session('alert-danger') }}");
        swal("@lang('front.error')!", "{{ session('alert-danger') }}", "error");
    @endif
    var current = window.location.href;
    $("ul.sidebar-menu li.active").removeClass('active');
    var li = $('a[href="' + current + '"]').closest('li');
    var parent = li.parents('.treeview-menu');
    if (parent.length) {
        parent.closest('li').addClass('active');
    }
    if (li.length) {
        li.addClass('active');
    } else {
        $("#homeLi").addClass('active');
    }

    $(document).on('hidden.bs.modal', function(e) {
        $(e.target).removeData('bs.modal');
    });

    $('.modal-fullscreen .modal-content').slimScroll({
        height: ($(window.top).height()) + 'px',
        alwaysVisible: true
    });

    $('.modal').on('show.bs.modal', function(e) {
        var animation = $(this).attr('rel');
        $(this).find('.modal-dialog').attr('class', 'modal-lg modal-dialog animated ' + animation);
    });


    function downloadPdf($btn) {
        $('canvas').remove();
        $(".hideprint").hide();
        if ($btn.hasClass('disabled')) return false;
        $btn.attr('data-loading-text', "<i class='fa fa-circle-o-notch fa-spin'></i> جارى التحميل ....");
        $btn.button('loading');
        var container = document.querySelector('.content');
        html2canvas(container).then(canvas => {
            let doc = new jsPDF({
                orientation: 'p',
                unit: 'px',
                format: 'a4'
            });
            doc.width = doc.internal.pageSize.width;
            doc.height = doc.internal.pageSize.height;
            doc.margin = {
                horiz: 5,
                vert: 20
            };
            doc.work = {
                width: doc.width - (doc.margin.horiz * 2),
                height: doc.height - (doc.margin.vert * 2)
            }
            doc.setFontSize(9);
            doc.setFontType("bold");

            let data = {
                width: container.offsetWidth,
                height: container.offsetHeight,
                ctx: canvas.getContext('2d'),
                page: {}
            };
            data.page.width = data.width;
            data.page.height = (data.width * doc.work.height) / doc.work.width;

            const getData = function(imgData, width, height) {
                let oCanvas = document.createElement('canvas');
                oCanvas.width = width;
                oCanvas.height = height;
                let oCtx = oCanvas.getContext('2d');
                oCtx.putImageData(imgData, 0, 0);
                return oCanvas.toDataURL('image/png');
            };

            /**/
            let oImgData = null;
            let dataURL = null;
            let pages = Math.ceil(data.height / data.page.height);
            for (let i = 0; i < pages; i++) {
                if (i != 0) {
                    doc.addPage();
                }
                oImgData = data.ctx.getImageData(0, data.page.height * i, data.page.width, data.page.height);
                dataURL = getData(oImgData, data.page.width, data.page.height);
                doc.addImage(dataURL, 'PNG', doc.margin.horiz, doc.margin.vert, doc.work.width, doc.work
                    .height);
            }
            var width = doc.internal.pageSize.getWidth();
            var height = doc.internal.pageSize.getHeight();
            const pagesCount = doc.internal.getNumberOfPages();
            for (let j = 1; j < pagesCount + 1; j++) {
                let horizontalPos = width / 2; //Can be fixed number
                let verticalPos = height - 10; //Can be fixed number
                doc.setPage(j);
                doc.text(`${j} of ${pagesCount}`, horizontalPos, verticalPos, {
                    align: 'center'
                });
            }
            /**/
            var pageTitle = document.title || "Untitled";
            doc.save(pageTitle + ".pdf");

            $btn.button('reset');

        });

        $(".hideprint").show();
    }
    $(document).on('click', '#pdf-button', function(e) {
        e.preventDefault();
        var $btn = $(this);
        downloadPdf($btn);
    });
    $(document).on("click", ".showAlertWarning", function(e) {
        e.preventDefault();
        var btn = $(this);
        var url_ = $(this).attr('href');
        swal({
                title: "@lang('front.warning')!",
                text: "@lang('front.deleteconfirm')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD4140",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                cancelButtonText: "@lang('front.cancel')",
                confirmButtonText: "@lang('front.ok')",
            },
            function() {
                $.ajax({
                    url: url_,
                    type: 'GET',
                    success: function(result) {
                        //swal({title:"نجاح العملية!", text:"تمت العملية بنجاح",type:"success",confirmButtonText: "تمام"});
                        if (result == "failed") {
                            swal({
                                title: "@lang('front.error!')",
                                text: "@lang('front.delete')",
                                type: "error",
                                confirmButtonText: "تمام"
                            });
                        } else {
                            swal({
                                title: "@lang('front.success!')",
                                text: "@lang('front.Successfully added')",
                                type: "success",
                                confirmButtonText: "تمام"
                            });
                            var link = document.createElement('a');
                            link.style.display = 'none';
                            link.href = result;
                            // Add the link to the DOM
                            document.body.appendChild(link);
                            // Trigger the download
                            link.click();
                            // Remove the link from the DOM
                            document.body.removeChild(link);
                            //location.reload();
                        }

                        //window.location.href = newLink;
                        //window.location.reload();

                    }
                });
            });
    });

    $(document).on("click", ".remove-record", function(e) {
        e.preventDefault();
        var btn = $(this);
        var url_ = $(this).attr('data-url');
        swal({
                title: "@lang('front.deleteconfirm') ",
                text: "@lang('front.You will lose data and will not be able to undo it')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD4140",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                cancelButtonText: "@lang('front.cancel')",
                confirmButtonText: "@lang('front.ok')",
            },
            function() {
                $.ajax({
                    url: url_,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: 'DELETE'
                    },
                    success: function(result) {
                        //alert(result);
                        if (result == "transaction deleted") {
                            window.location.reload();
                        } else if (result == 'done') {
                            //btn.closest('tr').fadeOut();
                            swal({
                                title: "@lang('front.delete')!",
                                text: "@lang('front.successdelete')",
                                type: "success",
                                confirmButtonText: "@lang('front.ok')"
                            });
                            table.row(btn.closest('tr')).remove().draw();
                        } else {
                            swal({
                                title: "@lang('front.error')!",
                                text: "@lang('front.cannotdelete')",
                                type: "error",
                                confirmButtonText: "@lang('front.ok')"
                            });
                        }
                    }
                });
            });
    });

    function PrintElem(url) {
        window.open(url, 'theFrame');
        window.focus();
    }

    function PrintDiv(elem) {
        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head><title>' + document.title + '</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById(elem).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    }
    @if (request('page_display_start'))
        $("form").append(
            '<input type="hidden" name="page_display_start" value="{{ request('page_display_start') }}">');
    @endif
    $('body').on('submit', 'form', function(e) {
        //e.preventDefault();
        var $btn = $(this).find(':submit');
        if ($btn.hasClass('disabled')) return false;
        $btn.attr('data-loading-text', "<i class='fa fa-circle-o-notch fa-spin'></i> @lang('front.Saving ...')");
        $btn.button('loading');
        setTimeout(function() {
            $btn.button('reset');
        }, 3000);
    });
</script>

@stack('js')
@include('sweet::alert')
