<script>
function getAllMerchants(){
    jQuery.ajax({
        url: "https://contact.eg/wp-json/merchants/getMerchantsByProduct?Id=5",
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
