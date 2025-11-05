<div class="wrapper vh-100- mb-0 overflow-hidden- te-search-result-wrapper shadow-sm">
    <section class="te-search-results-sec te-search-result-wrapper p-0">
    <div id="pms-searchfrm" class="container-fluid customize-ldesign">
        {include file="listing/main-device-search-form.tpl"}
    </div>
</section>
</div>

{if cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD' }
    {include file="listing/mobile-device-search-form.tpl"}
{/if}