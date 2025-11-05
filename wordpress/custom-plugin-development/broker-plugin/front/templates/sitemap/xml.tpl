<?xml version="1.0" encoding="UTF-8"?>
<urlset	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    {foreach name='SiteMap' from=$pagesForSitemap item=Record}
        {assign var=postdate value=" "|explode:$Record->post_modified}
        {*{assign var=someVar value="|"|explode:"1|dollar"}*}
        <url>
            <loc>{get_permalink($Record->ID)}</loc>
            <priority>1</priority>
            <lastmod>{$postdate[0]}</lastmod>
            <changefreq>daily</changefreq>
        </url>
    {/foreach}
</urlset>