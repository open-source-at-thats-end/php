{*<pre>{$arrListing|print_r}</pre>*}
{foreach $arrListing as $Record}
   <tr>
       <td>{$Record.search_title}</td>
       <td>
           {assign var=arrSearchResult value=$Record.search_criteria|unserialize}

           {if isset($arrSearchResult.Address_MLS_NUM)}
               <span class="font-weight-bold">Address or MLS# :</span>{if is_array($arrSearchResult.Address_MLS_NUM)}{','|implode:$arrSearchResult.Address_MLS_NUM}{else}{$arrSearchResult.Address_MLS_NUM}{/if}<<br />
           {/if}
           {if isset($arrSearchResult.add) && !empty($arrSearchResult.add)}
               <span class="font-weight-bold"> Address: </span>{if is_array($arrSearchResult.add)}{','|implode:$arrSearchResult.add}{else}{$arrSearchResult.add}{/if}<br />
           {/if}
           {if isset($arrSearchResult.mlslist) && !empty($arrSearchResult.mlslist)}
               <span class="font-weight-bold">MLS# :</span> {if is_array($arrSearchResult.mlslist)}{','|implode:$arrSearchResult.mlslist}{else}{$arrSearchResult.mlslist}{/if}<<br />
           {/if}
           {if isset($arrSearchResult.minprice) && !empty($arrSearchResult.minprice)}
               <span class="font-weight-bold">Min Price :</span> {$arrSearchResult.minprice}<br />
           {/if}
           {if isset($arrSearchResult.maxprice) && !empty($arrSearchResult.maxprice)}
               <span class="font-weight-bold">Max Price :</span> {$arrSearchResult.maxprice}<br />
           {/if}
           {if isset($arrSearchResult.city)}
               <span class="font-weight-bold">City :</span> {if is_array($arrSearchResult.city)}{','|implode:$arrSearchResult.city}{else}{$arrSearchResult.city}{/if}<br />
           {/if}
           {if isset($arrSearchResult.sdivlist)}
               <span class="font-weight-bold"> Sdiv List :</span> {if is_array($arrSearchResult.sdivlist)}{','|implode:$arrSearchResult.sdivlist}{else}{$arrSearchResult.sdivlist}{/if}<br />
           {/if}
           {if isset($arrSearchResult.minlotsizesqft) && !empty($arrSearchResult.minlotsizesqft)}
               <span class="font-weight-bold"> Min Lot Size Sqft :</span> {$arrSearchResult.minlotsizesqft}<br />
           {/if}
           {if isset($arrSearchResult.maxlotsizesqft) && !empty($arrSearchResult.maxlotsizesqft)}
               <span class="font-weight-bold">Max Lot Size Sqft : </span>{$arrSearchResult.maxlotsizesqft}<br />
           {/if}
           {if isset($arrSearchResult.minyear) && !empty($arrSearchResult.minyear)}
               <span class="font-weight-bold">Min Year : </span>{$arrSearchResult.minyear}<br />
           {/if}
           {if isset($arrSearchResult.maxyear) && !empty($arrSearchResult.maxyear)}
               <span class="font-weight-bold"> Max Year :</span> {$arrSearchResult.maxyear}<br />
           {/if}
           {if isset($arrSearchResult.ptype)}
               <span class="font-weight-bold">Property Type :</span> {if is_array($arrSearchResult.ptype)}{', '|implode:$arrSearchResult.ptype|implode:', '}{else}{$arrSearchResult.ptype}{/if}<br />
           {/if}
           {if isset($arrSearchResult.pstyle)}
               <span class="font-weight-bold">Property Style : </span>{if is_array($arrSearchResult.pstyle)}{', '|implode:$arrSearchResult.pstyle}{else}{$arrSearchResult.pstyle}{/if}<br />
           {/if}
           {if isset($arrSearchResult.dom) && !empty($arrSearchResult.dom)}
               <span class="font-weight-bold"> DOM :</span> {$arrSearchResult.dom}<br />
           {/if}
           {if isset($arrSearchResult.waterfront) && !empty($arrSearchResult.waterfront)}
               <span class="font-weight-bold"> Waterfront : </span>{$arrSearchResult.waterfront}<br />
           {/if}
           {if isset($arrSearchResult.pool) && !empty($arrSearchResult.pool)}
               <span class="font-weight-bold"> Pool : </span>{$arrSearchResult.pool}<br />
           {/if}
           {if isset($arrSearchResult.status)}
               <span class="font-weight-bold"> Status : </span>{if is_array($arrSearchResult.status)}{', '|implode:$arrSearchResult.status}{else}{$arrSearchResult.status}{/if}<br />
           {/if}
           {if isset($arrSearchResult.petsallowed) && !empty($arrSearchResult.petsallowed)}
               <span class="font-weight-bold">Pets Allowed : </span>{$arrSearchResult.petsallowed}<br />
           {/if}
           {if isset($arrSearchResult.minsqft) && !empty($arrSearchResult.minsqft)}
               <span class="font-weight-bold"> Min Sqft : </span> {$arrSearchResult.minsqft}<br />
           {/if}
           {if isset($arrSearchResult.maxsqft) && !empty($arrSearchResult.maxsqft)}
               <span class="font-weight-bold">Max Sqft :</span> {$arrSearchResult.maxsqft}<br />
           {/if}
           {if isset($arrSearchResult.minbed) && !empty($arrSearchResult.minbed)}
               <span class="font-weight-bold"> Min Bed :</span> {$arrSearchResult.minbed}<br />
           {/if}
           {if isset($arrSearchResult.minbath) && !empty($arrSearchResult.minbath)}
               <span class="font-weight-bold"> Min Bath :</span> {$arrSearchResult.minbath}<br />
           {/if}
           {if isset($arrSearchResult.zipcode) && !empty($arrSearchResult.zipcode)}
               <span class="font-weight-bold"> Zipcode :</span> {$arrSearchResult.zipcode}<br />
           {/if}
           {if isset($arrSearchResult.office)}
               <span class="font-weight-bold"> Office : </span>{if is_array($arrSearchResult.office)}{', '|implode:$arrSearchResult.office}{else}{$arrSearchResult.office}{/if}<br />
           {/if}
           {if isset($arrSearchResult.agent) && !empty($arrSearchResult.agent)}
               <span class="font-weight-bold"> Agent : </span>{$arrSearchResult.agent}<br />
           {/if}
           {if isset($arrSearchResult.kword) && !empty($arrSearchResult.kword)}
               <span class="font-weight-bold">  Kword :</span> {$arrSearchResult.kword}<br />
           {/if}
           {if isset($arrSearchResult.sys_name) && !empty($arrSearchResult.sys_name)}
               <span class="font-weight-bold">  System Name :</span> {$arrSearchResult.sys_name}<br />
           {/if}
           {*{if isset($arrSearchResult.horse_amenities) && !empty($arrSearchResult.horse_amenities)}
               <span class="font-weight-bold">  Horse Emenities :</span> {$arrSearchResult.horse_amenities}<br />
           {/if}*}
           {if isset($arrSearchResult.horse_yn) && !empty($arrSearchResult.horse_yn)}
               <span class="font-weight-bold">  Horse Emenities :</span> {$arrSearchResult.horse_yn}<br />
           {/if}
           {if isset($arrSearchResult.waterfrontdesc) && !empty($arrSearchResult.waterfrontdesc)}
               <span class="font-weight-bold">  Waterfront Description :</span> {$arrSearchResult.waterfrontdesc}<br />
           {/if}
           {if isset($arrSearchResult.security_safety) && !empty($arrSearchResult.security_safety)}
               <span class="font-weight-bold">  Security :</span> {$arrSearchResult.security_safety}<br />
           {/if}
       </td>
        <td width="">
                <a href="{$MainUrl}&action=edit_save_search{if $user_ref_Id != ''}&user_ref_id={$user_ref_Id}{else}&user_id={$user_Id }{/if}&search_id={$Record['search_id']}" class="text-primary"  data-placement="top" title="Edit"><b><i class="mdi mdi-table-edit " style="font-size: 20px;"></i></b></a>&nbsp;&nbsp;
                <a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDelete_Click('{$scriptname}','{$Record['search_id']}','');"><b><i class="mdi mdi-delete text-primary" style="font-size: 20px;"></i></b></a>

        </td>

   </tr>
    {/foreach}
