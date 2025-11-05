/* JS
 * scripts.js
 * NOTE : Functions copied from 15CRM Plugin, to matchup module functionlity
 */


jQuery(document).ready(function(){

    jQuery('#toplevel_page_lpt .wp-submenu li:nth-child(4) a').attr('href','javascript:void(0)');
    jQuery('#toplevel_page_lpt .wp-submenu li:nth-child(4) a').addClass('contact-menu');
    jQuery('#toplevel_page_lpt .wp-submenu li:nth-child(4)').append('<ul style="display: none"><li ><a href="' +HostUrl+ '?page=lpt-user">All Contacts</a></li><li><a href="' +HostUrl+ '?page=lpt-hot-leads">Hot Leads</a></li><li><a href="' +HostUrl+ '?page=lpt-opportunity">Opportunities</a></li></ul>');

    jQuery('.contact-menu').on('click',function () {
        if(jQuery('#toplevel_page_lpt .wp-submenu li:nth-child(4) ul').is(':visible'))
        {
            jQuery(jQuery('#toplevel_page_lpt .wp-submenu li:nth-child(4) ul').hide());
        }
        else{
            jQuery(jQuery('#toplevel_page_lpt .wp-submenu li:nth-child(4) ul').show());
        }
    });

    flg_apm.version='1.4.1';  
    flg_apm.initMainRollover();    
    jQuery('#adminmenuwrap').css('height',jQuery('body').height());
});

var flg_apm=function(){
    return {};
}

if(flg_apm==undefined){
    flg_apm={};
}

flg_apm.initMainRollover=function(){

    jQuery('.hasTooltip').off('mouseover').on('mouseover',function(){
        jQuery(this).tooltip();
        jQuery(this).tooltip('show');
    });
    
}