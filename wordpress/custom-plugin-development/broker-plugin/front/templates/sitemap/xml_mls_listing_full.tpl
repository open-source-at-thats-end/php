{*<?xml version="1.0" encoding="UTF-8"?>
<urlset	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    {foreach name=recordInfo from=$rsListing item=Record key=Key}
        {assign var="rsAttributes" value=Utility::generateListingAttributes($Record)}
        <url>
            <loc>{$Site_Root}/{$rsAttributes.SFUrl}</loc>
            <address>{str_replace('&',' ',preg_replace('/(?<!\ )[A-Z]/', ' $0', $rsAttributes.AddressFull))}</address>
            <mls>{$Record.MLS_NUM}</mls>
            <price>{$currency}{$Record.ListPrice|number_format:'0'}</price>
            <bedroom>{$Record.Beds}</bedroom>
            <bathroom>{rtrim(rtrim($Record.Baths,'0'),'.')}</bathroom>
            <squarefeet>{$Record.SQFT|number_format:0}</squarefeet>
            <image:image>
                <image:loc>{$Record.MainPicture}</image:loc>
            </image:image>
            <priority>0.5</priority>
            <lastmod>{if $Record.LastUpdateDate}{$Record.LastUpdateDate|date_format:"%Y-%m-%dT%H:%M:%S+00:00"}{else}{$smarty.now|date_format:"%Y-%m-%dT%H:%M:%S+00:00"}{/if}</lastmod>
            <changefreq>weekly</changefreq>
        </url>
    {/foreach}
</urlset>*}

<?xml version="1.0" encoding="UTF-8"?>


{foreach name=recordInfo from=$rsListing item=Record key=Key}
    {assign var="rsAttributes" value=Utility::generateListingAttributes($Record)}
    {capture append=xmlfulllisting}
        <url>
            <loc>{$Site_Root}/{$rsAttributes.SFUrl}</loc>
            <address>{str_replace('&','',preg_replace('/(?<!\ )[A-Z]/', ' $0', $rsAttributes.AddressFull))}</address>
            <mls>{$Record.MLS_NUM}</mls>
            <price>{$currency}{$Record.ListPrice|number_format:'0'}</price>
            <bedroom>{$Record.Beds}</bedroom>
            <bathroom>{rtrim(rtrim($Record.Baths,'0'),'.')}</bathroom>
            <squarefeet>{$Record.SQFT|number_format:0}</squarefeet>
            {*<image:image>
                <image:loc>{$Record.MainPicture}</image:loc>
            </image:image>*}
            <priority>0.5</priority>
            <lastmod>{if $Record.LastUpdateDate}{$Record.LastUpdateDate|date_format:"%Y-%m-%dT%H:%M:%S+00:00"}{else}{$smarty.now|date_format:"%Y-%m-%dT%H:%M:%S+00:00"}{/if}</lastmod>
            <changefreq>weekly</changefreq>
        </url>
    {/capture}
{/foreach}

<urlset	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    {implode('',$xmlfulllisting)}
</urlset>
