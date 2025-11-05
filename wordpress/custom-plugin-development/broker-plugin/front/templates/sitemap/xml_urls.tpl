<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">
    <sitemap>
        <loc>{$Site_Root}/sitemap.xml</loc>
        <lastmod>{$smarty.now|date_format:"%Y-%m-%dT%H:%M:%S+00:00"}</lastmod>
    </sitemap>
    {section loop=$j name=sitemap}
        <sitemap>
            <loc>{$Site_Root}/sitemap-{$smarty.section.sitemap.iteration}.xml</loc>
            <lastmod>{$smarty.now|date_format:"%Y-%m-%dT%H:%M:%S+00:00"}</lastmod>
        </sitemap>
    {/section}
</sitemapindex>