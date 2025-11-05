{if isset($arrWaterfrontDesc) && is_array($arrWaterfrontDesc)}
    <option value="">Any</option>
    {html_options options=$arrWaterfrontDesc selected=$arrSearchCriteria.waterfrontdesc}
{/if}