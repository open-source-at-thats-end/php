jQuery(document).ready(function() {

    /*jQuery(".dropdown-toggle").dropdown();*/
    console.log('slider');
    var onloadUrl = window.location.href.split("#");

    var activeTab = onloadUrl['1'];

    if(activeTab == '!for-sale')
    {
        jQuery('.conTabs a[data-title="!for-sale"]').tab('show');
        jQuery('.cusOptions').val('forsale');
    }

    if(activeTab == '!for-rent')
    {
        jQuery('.conTabs a[data-title="!for-rent"]').tab('show');
        jQuery('.cusOptions').val('forrent');
    }

    if(activeTab == '!pending')
    {
        jQuery('.conTabs a[data-title="!pending"]').tab('show');
        jQuery('.cusOptions').val('forpending');
    }

    if(activeTab == '!sold')
    {
        jQuery('.conTabs a[data-title="!sold"]').tab('show');
        jQuery('.cusOptions').val('forsold');
    }


    if(typeof activeTab != "undefined")
    {
        window.location.hash = activeTab;
    }
    else
    {
        window.location.url = '';
    }

    jQuery('.condo-slider').slick({
        autoplay: false,
        autoplaySpeed: 3000,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        responsive: [
            {
                breakpoint: 1060,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    jQuery('.conTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var tab = jQuery(this).attr('aria-controls');

        /*if(tab == 'forsale')
            jQuery('.conTabs a[href="#forsale"]').tab('show');

        if(tab == 'forrent')
            jQuery('.conTabs a[href="#forrent"]').tab('show');

        if(tab == 'forpending')
            jQuery('.conTabs a[href="#forpending"]').tab('show');

        if(tab == 'forsold')
            jQuery('.conTabs a[href="#forsold"]').tab('show');*/

        if(tab == 'forsale')
        {
            jQuery('.conTabs a[aria-controls="forsale"]').tab('show');
            jQuery('.cusOptions').val('forsale');
        }

        if(tab == 'forrent')
        {
            jQuery('.conTabs a[aria-controls="forrent"]').tab('show');
            jQuery('.cusOptions').val('forrent');
        }

        if(tab == 'forpending')
        {
            jQuery('.conTabs a[aria-controls="forpending"]').tab('show');
            jQuery('.cusOptions').val('forpending');
        }
            /*jQuery('#cusDropDown').addClass('selected');*/

        if(tab == 'forsold')
        {
            jQuery('.conTabs a[aria-controls="forsold"]').tab('show');
            jQuery('.cusOptions').val('forsold');
        }
    });

    /*jQuery("#listgridOptions").unbind('change');*/
    jQuery("#listgridOptions").on('change', function (e) {

        var view = jQuery(this).val();

        if(view == 'condo-list')
        {
            jQuery('#myTabContent #list').tab('show');
            jQuery('#myTabContent #grid').removeClass('active');
        }
        else if(view == 'condo-grid')
        {
            jQuery('#myTabContent #grid').tab('show');
            jQuery('#myTabContent #list').removeClass('active');
        }

        if(view == 'condo-list'){
            jQuery('#myListTab').removeClass('d-none');
            jQuery('#dataListTab').removeClass('d-none');
            jQuery('#myGridTab').addClass('d-none');
            jQuery('#dataGridTab').addClass('d-none');

        }
        else{
            jQuery('#myListTab').addClass('d-none');
            jQuery('#dataListTab').addClass('d-none');
            jQuery('#myGridTab').removeClass('d-none');
            jQuery('#dataGridTab').removeClass('d-none');
        }
    });
    jQuery("#condo-list").on('click', function (e) {

        jQuery('#condo-list').addClass('active');
        jQuery('#condo-list').removeClass('text-primary');
        jQuery('#condo-list').addClass('text-white');

        jQuery('#condo-grid').removeClass('text-white');
        jQuery('#condo-grid').addClass('text-primary');

        jQuery('#condo-grid').removeClass('active');

        jQuery('#listgridOptions').html('LIST ' + '<i class="fas fa-bars"></i>');

        jQuery('#myTabContent #list').tab('show');
        jQuery('#myTabContent #grid').removeClass('active');
        jQuery('#myListTab').removeClass('d-none');
        jQuery('#dataListTab').removeClass('d-none');
        jQuery('#myGridTab').addClass('d-none');
        jQuery('#dataGridTab').addClass('d-none');


    });
    jQuery("#condo-grid").on('click', function (e) {

        var view = jQuery('#condo-grid').text();



        jQuery('#condo-list').removeClass('active');
        jQuery('#condo-grid').addClass('active');

        jQuery('#condo-grid').removeClass('text-primary');
        jQuery('#condo-grid').addClass('text-white');

        jQuery('#condo-list').removeClass('text-white');
        jQuery('#condo-list').addClass('text-primary');

        jQuery('#listgridOptions').html('GRID ' + '<i class="fas fa-th"></i>');

        jQuery('#myTabContent #grid').tab('show');
        jQuery('#myTabContent #list').removeClass('active');

        jQuery('#myListTab').addClass('d-none');
        jQuery('#dataListTab').addClass('d-none');
        jQuery('#myGridTab').removeClass('d-none');
        jQuery('#dataGridTab').removeClass('d-none');

    });

    jQuery(".cusOptions").on('change', function () {

        var selected = jQuery(this).val();

        jQuery('#myTabContent li a').eq(jQuery(this).val()).tab('show');

        if(selected == 'forsale')
        {
            jQuery('.conTabs a[aria-controls="forsale"]').tab('show');
        }

        if(selected == 'forrent')
        {
            jQuery('.conTabs a[aria-controls="forrent"]').tab('show');
        }

        if(selected == 'forpending')
        {
            jQuery('.conTabs a[aria-controls="forpending"]').tab('show');
        }

        if(selected == 'forsold')
        {
            jQuery('.conTabs a[aria-controls="forsold"]').tab('show');
        }

    });

    jQuery('#viewTab [data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var parentTab = jQuery(this).attr('aria-controls');

        if(parentTab == 'list'){
            jQuery('#myListTab').removeClass('d-none');
            jQuery('#dataListTab').removeClass('d-none');
            jQuery('#myGridTab').addClass('d-none');
            jQuery('#dataGridTab').addClass('d-none');

        }
        else{
            jQuery('#myListTab').addClass('d-none');
            jQuery('#dataListTab').addClass('d-none');
            jQuery('#myGridTab').removeClass('d-none');
            jQuery('#dataGridTab').removeClass('d-none');
        }
    });

    jQuery('.conTabs').unbind('click');
    jQuery(".conTabs a").on('click', function (e) {
        e.preventDefault();
        jQuery(this).tab('show');

        // Displayed tab name in end of url
        window.location.hash = jQuery(this).attr('data-title');
    });

    jQuery('#viewTab a').on('click', function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
    });

    jQuery('.listTable').DataTable({
        searching: false,
        paging: false,
        info: false,
    });

    jQuery('#forsold .soldlistTable').DataTable( {
        searching: false,
        paging: false,
        info: false,
        "order": [[ 7, "desc" ]]
    });

    jQuery('#forsold1 .soldlistTable').DataTable( {
        searching: false,
        paging: false,
        info: false,
        "order": [[ 7, "desc" ]]
    });

    jQuery(".clickable-row").click(function() {
        window.location = jQuery(this).data("href");
    });

    jQuery(".te-property-favourite").click(function () {
       jQuery(".clickable-row").unbind("click");
    });
});