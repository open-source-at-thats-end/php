/* JS
 * scripts.js
 * NOTE : Functions copied from 15CRM Plugin, to matchup module functionlity
 */


jQuery(document).ready(function(){
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