<style>
    .row-custom{
        display:flex;
        justify-content: space-between;
    }
    .col-md-3-custom{
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    .row-custom label{
        display:block;
        margin: 0;
        padding: 5px 0px 10px;
        font-size: 20px !important;
        text-align: left;
        font-family: 'Nexa-Regular',Helvetica,Arial,Lucida,sans-serif !important;
    }
    .row-custom select{
        width: 100%;
        font-size: 16px !important
    }
    .select2-selection.select2-selection--single{
        height: 40px !important;
        padding: 5px 4px;
    }
    @media (min-width: 768px){
        .col-md-3-custom{
            width:23.33%
        }
    }
    .select2-container{
        width: 100% !important;
    }
    #merchants{
        padding: 30px 15px;
        overflow: hidden;
        text-align: center;
    }
    .paginationNav {
        text-align: center;
        font-size: 1.2em;
    a {
        display:inline-block;
        color: #ffffff;
        margin: 0 auto;
        height: 46px;
        width: 46px;
        text-align: center;
        line-height: 46px;
        margin-right: 1px;
    }
    }
    .et_pb_portfolio_item{
        border-radius: 20px !important;
        background: #fff !important;
        box-shadow: 0px 2px 21px rgb(0 0 0 / 20%);
        padding: 20px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        height: 175px;
        text-align: center;
    }
    .et_pb_portfolio_item img{
        max-height: 170px;
        height: initial;
    }
</style>



<div class="row-custom">



    <div class="col-md-3-custom">
        <label style="text-align: right;" for="filter-category">الفئة</label>
        <select id="filter-category" class="select2Item" style="text-align: right;">

            <option value="">كل الفئات</option>

        </select>
    </div>


    <div class="col-md-3-custom">
        <label style="text-align: right;" for="filter-subcategory">الفئات</label>
        <select id="filter-subcategory" class="select2Item" style="text-align: right;">

            <option value="">كافة الفئات</option>

        </select>
    </div>


    <div class="col-md-3-custom">
        <label style="text-align: right;" for="filter-city">المدينة</label>
        <select id="filter-city" class="select2Item" style="text-align: right;">

            <option value="">اختر مدينة</option>

        </select>
    </div>


    <div class="col-md-3-custom">
        <label style="text-align: right;" for="filter-district">المنطقة</label>
        <select id="filter-district" class="select2Item" style="text-align: right;">

            <option value="">اختر منطقة</option>

        </select>
    </div>



</div>


<div id="merchants" class="row">

</div>
<div class="row" id="paginationContainer">

</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var language = 'ar';
    getAllMerchants();
    getMainCategory();
    getCity();
    function getMainCategory(){
        jQuery.ajax({
            url: "https://contact.eg/wp-json/merchants/categories?language=" + language,
            data: {},
            beforeSend: function () {
                jQuery("#merchants").html('<img src="https://i.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.webp">');
            },
            success: function (data) {
                let mainCategoryOptions = jQuery.map(data, function (item) {
                    return {
                        id: item.categoryID,
                        text: item.title
                    };
                });
                jQuery("#filter-category").select2({
                    placeholder: "كل الفئات",
                    allowClear: true,
                    cache: true,
                    data: mainCategoryOptions,
                });
            }
        });
    }
    function getCity(){
        jQuery.ajax({
            url: "https://contact.eg/wp-json/merchants/cities?language=" + language,
            data: {},
            success: function (data) {
                let cityOptions = jQuery.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name
                    };
                });
                jQuery("#filter-city").select2({
                    placeholder: "إختر مدينة",
                    allowClear: true,
                    cache: true,
                    data: cityOptions,
                });
            }
        });
    }
    jQuery("#filter-district").select2({
        placeholder: "إختر منطقة",
        allowClear: true,
        cache: true,
    });
    jQuery("#filter-subcategory").select2({
        placeholder: "إختر فئة فرعية",
        allowClear: true,
        cache: true,
    });
    function getSubCategory(){
        jQuery.ajax({
            url: "https://contact.eg/wp-json/merchants/sub-categories?category_id=" + jQuery('#filter-category').val() + "&language=" + language,
            data: {},
            beforeSend: function () {
                jQuery('#filter-subcategory').empty();
            },
            success: function (data) {
                let subCategoryOptions = jQuery.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name
                    };
                });
                jQuery('#filter-subcategory').select2('destroy');
                jQuery('#filter-subcategory').append("<option value=''>All</option>");
                jQuery("#filter-subcategory").select2({
                    placeholder: "إختر فئة فرعية",
                    allowClear: true,
                    cache: true,
                    data: subCategoryOptions,
                });
            }
        });
    }
    function getArea(){
        jQuery.ajax({
            url: "https://contact.eg/wp-json/merchants/areas?city=" + jQuery('#filter-city').val() + "&language=" + language,
            beforeSend: function () {
                jQuery('#filter-district').empty();
            },
            success: function (data) {
                let districtOptions = jQuery.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name
                    };
                });
                jQuery('#filter-district').select2('destroy');
                jQuery('#filter-district').append("<option value=''>All</option>");
                jQuery("#filter-district").select2({
                    placeholder: {
                        id: '', // the value of the option
                        text: 'إختر منطقة'
                    },
                    allowClear: true,
                    data: districtOptions,
                });
            }
        });
    }

    jQuery(document).on('change','.select2Item',function(e) {
        if(jQuery(this).attr('id')=='filter-category'){
            getSubCategory();
        }
        if(jQuery(this).attr('id')=='filter-city'){
            getArea();
        }
        if(jQuery("#filter-category").val()){
            getMerchants();
        }else{
            getAllMerchants();
        }
    });

    function getMerchants(){
        jQuery.ajax({
            url: "https://contact.eg/wp-json/merchants/merchants-filter",
            data: {
                city:jQuery("#filter-city").val(),
                area:jQuery("#filter-district").val(),
                categoryId:jQuery("#filter-category").val(),
                subCategoryID:jQuery("#filter-subcategory").val(),
                language: language
            },
            beforeSend: function () {
                jQuery("#merchants").html('<img src="https://i.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.webp">');
            },
            success: function (data) {
                console.log(data);
                let filtemerchants = "";
                jQuery.map(data, function (item) {
                    filtemerchants += '<div class="et_pb_column et_pb_grid_item et_pb_portfolio_item"> ' +
                        '<a href="https://contact.eg/merchant-show?Id='+item.id+'" title="'+item.title+'"> ' +
                        '<span class="et_portfolio_image"> ' +
                        '<img src="'+item.imageUrl+'" alt="" width="400" height="284"> ' +
                        '</span> </a> </div>';
                });

                jQuery("#merchants").html(filtemerchants);
            }
        });
    }
    function getAllMerchants(){
        jQuery.ajax({
            url: "https://contact.eg/wp-json/merchants/getMerchantsByProduct?Id=6&language=" + language,
            beforeSend: function () {
                jQuery("#merchants").html('<img src="https://i.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.webp">');
            },
            success: function (data) {
                let merchants = "";
                jQuery.map(data, function (item) {
                    merchants += '<div class="et_pb_column et_pb_grid_item et_pb_portfolio_item"> ' +
                        '<a href="https://contact.eg/merchant-show?Id='+item.id+'" title="'+item.title+'"> ' +
                        '<span class="et_portfolio_image"> ' +
                        '<img src="'+item.imageUrl+'" alt="" width="400" height="284"> ' +
                        '</span> </a> </div>';
                });

                jQuery("#merchants").html(merchants);
                paginateChildren(jQuery('#merchants'));
            }
        });
    }
    function paginateChildren(parentElement) {
        var page = 1;
        var currentElements;
        var offsetStart;
        var offsetEnd;
        var currentPage = 1;
        var elementsPerPage = 8;
        var elements = parentElement.find(jQuery('.et_pb_portfolio_item'));
        var nmbrOfPages = Math.ceil(elements.length / elementsPerPage);
        var displayNav = function () {
            htmlNav = '<div class="paginationNav pull-right">';
            //htmlNav += '<span>' + currentPage + ' of ' + nmbrOfPages + '</span><br />';
            //htmlNav += '<a href="#" title="Previous" rel="" class="prev">Prev</a>';
            htmlNav += '<a href="#" title="Next" rel="" class="et_pb_button et_pb_button_0 et_pb_bg_layout_dark next active">Load More</a>';
            htmlNav += '</div>';
            if (!jQuery(parentElement).find('.paginationNav').length) {
                //jQuery(parentElement).append(htmlNav);
                jQuery("#paginationContainer").html(htmlNav);

            }
        };
        jQuery(document).on('click', 'a.prev', function (e) {
            e.preventDefault();
            page = currentPage > 1 ? parseInt(currentPage) - 1 : 1;
            displayPage(page);
        });
        jQuery(document).on('click', 'a.next', function (e) {
            e.preventDefault();
            page = currentPage < nmbrOfPages ? parseInt(currentPage) + 1 : nmbrOfPages;
            displayPage(page);
        });
        var displayPage = function (page) {
            if (currentPage != page || page == 1) {
                currentPage = parseInt(page);
                jQuery('.paginationNav span', parentElement).html(currentPage + ' of ' + nmbrOfPages);
                var $prevButton = jQuery('.paginationNav a.prev');
                var $nextButton = jQuery('.paginationNav a.next');
                if (currentPage == 1 && nmbrOfPages > 1) {
                    if ($prevButton.hasClass('active')) {
                        $prevButton.removeClass('active');
                    }
                    $nextButton.addClass('active');
                } else if (currentPage > 1 && currentPage < nmbrOfPages) {
                    $prevButton.addClass('active');
                    $nextButton.addClass('active');
                } else if (nmbrOfPages > 1 && currentPage == nmbrOfPages) {
                    $prevButton.addClass('active');
                    if ($nextButton.hasClass('active')) {
                        $nextButton.removeClass('active');
                    }
                }
                offsetStart = (page - 1) * elementsPerPage;
                offsetEnd = page * elementsPerPage;
                if (currentElements) {
                    //currentElements.hide();
                } else {
                    elements.hide();
                }
                currentElements = elements.slice(offsetStart, offsetEnd);
                currentElements.fadeIn();
            }
        };
        if (page.length <= 0 || page < 1 || page > nmbrOfPages) {
            page = 1;
        }
        displayPage(page);
        if (nmbrOfPages > 1) {
            displayNav();
        }
    }
</script>
