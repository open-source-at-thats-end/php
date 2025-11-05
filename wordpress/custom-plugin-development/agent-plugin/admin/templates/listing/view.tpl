<div class="pro-details">
    <h1>{$objUtility->formatListingAddress($arrListingConfig.AddressFull, $Record)}</h1>
    {if $Record.TotalPhotos > 1 || $Record.mls_is_pic_url_supported == 'Yes'}
        <!-- horizontal thumbnail slider start -->
        <div class="fg-outer">
            <div class="fg">
                <div class="content">
                    <div id="rg-gallery" class="rg-gallery">
                        <div class="rg-thumbs">
                            <div class="es-carousel-wrapper">
                                <div id="slider" class="flexslider">
                                    <ul class="slides">
                                        {if $Record.mls_is_pic_url_supported == 'Yes'}
                                            {if $Record.PictureArr.large|count > 0}
                                                {*}<p class="acenter"><a href="javascript:void(0);" class="startSlide">click here to start slide show</a></p>{*}
                                                {section name=pic loop=$Record.PictureArr.thumb|count}
                                                    <li><img src="{$Record.PictureArr.large[pic].url}" data-large="{$Record.PictureArr.large[pic].url}" width="65" height="" alt="{$arrMetaKeywords[$tmpIndex]|trim}" /></li>
                                                    {assign var=tmpIndex value=$tmpIndex+1}
                                                    {if $tmpIndex >= $cntKeyword}{assign var=tmpIndex value=0}{/if}
                                                {/section}
                                            {else}
                                                <li><img src="{$Record.PhotoBaseUrl}/no-photo/0/780/455/g/" height="60%" alt="MLS# {$Record.MLS_NUM}"/></li>
                                            {/if}
                                        {elseif $Record.TotalPhotos > 0}
                                            {*}<p class="acenter"><a href="javascript:void(0);" class="startSlide">click here to start slide show</a></p>{*}
                                            {section name=pic loop=$Record.TotalPhotos}
                                                <li><img src="{$Record.PictureArr[pic]}/70/50/2/" data-large="{$Record.PictureArr[pic]}/"{*}alt="{$arrMetaKeywords[pic]}"{*} /></li>
                                                {assign var=tmpIndex value=$tmpIndex+1}
                                                {if $tmpIndex >= $cntKeyword}{assign var=tmpIndex value=0}{/if}
                                            {/section}
                                        {/if}
                                    </ul>
                                </div>

                                <div id="carousel" class="flexslider">
                                    <ul class="slides">
                                    {if $Record.mls_is_pic_url_supported == 'Yes'}
                                        {if $Record.PictureArr.large|count > 0}
                                            {*}<p class="acenter"><a href="javascript:void(0);" class="startSlide">click here to start slide show</a></p>{*}
                                            {section name=pic loop=$Record.PictureArr.large|count}
                                                <li><img src="{$Record.PictureArr.large[pic].url}" data-large="{$Record.PictureArr.large[pic].url}" width="65" height="" alt="{$arrMetaKeywords[$tmpIndex]|trim}" /></li>
                                                {assign var=tmpIndex value=$tmpIndex+1}
                                                {if $tmpIndex >= $cntKeyword}{assign var=tmpIndex value=0}{/if}
                                            {/section}
                                        {else}
                                            <li><img src="{$Record.PhotoBaseUrl}no-photo/0/0/0/g/" height="60%" alt="MLS# {$Record.MLS_NUM}"/></li>
                                        {/if}
                                    {elseif $Record.TotalPhotos > 0}
                                        {*}<p class="acenter"><a href="javascript:void(0);" class="startSlide">click here to start slide show</a></p>{*}
                                        {section name=pic loop=$Record.TotalPhotos}
                                            <li><img src="{$Record.PictureArr[pic]}/70/50/2/" data-large="{$Record.PictureArr[pic]}/"{*}alt="{$arrMetaKeywords[pic]}"{*} /></li>
                                            {assign var=tmpIndex value=$tmpIndex+1}
                                            {if $tmpIndex >= $cntKeyword}{assign var=tmpIndex value=0}{/if}
                                        {/section}
                                    {/if}

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- horizontal thumbnail slider end -->
    {else}
        <div class="acenter"><img src="{$Record.PhotoBaseUrl}no-photo/0/600/" alt=""/></div>
    {/if}
    <h2>Property Details</h2>
    <div class="pro-details-box">
        <label>MLS Number: </label><span> {$Record.MLS_NUM} </span>
        <label>Price:</label><span> {$Config.site_currency}{$Record.ListPrice|number_format:0}</span>
        <label>Address: </label><span> {$objUtility->formatListingAddress($arrListingConfig.AddressShort, $Record)}</span>
        <label>City:</label><span> {$Record.CityName|lower|ucwords}</span>
        <label>State:</label><span> {$Record.State}</span>
        {if $Record.Zipcode}
            <label>Zip Code:</label><span> {$Record.Zipcode}</span>
        {/if}
        {if $Record.Area}
            <label>Area:</label><span> {$Record.Area|lower|ucwords}</span>
        {/if}
        {if $Record.Subdivision}
            <label>Subdivision:</label><span> {$Record.Subdivision|lower|ucwords}</span>
        {/if}
        {if $Record.SubType}
            <label>Type: </label><span> {$Record.SubType}</span>
        {/if}

        {if $Record.PropertyStyle}
            <label>Property Style:</label><span> {$Record.PropertyStyle}</span>
        {/if}
        {if $Record.SQFT > 0}
            <label>Sqft: </label><span> {$Record.SQFT|number_format:0} sqft</span>
        {/if}
        {if $Record.Beds > 0}
            <label>Bedrooms: </label><span> {$Record.Beds}</span>
        {/if}
        {if $Record.Baths > 0}
            <label>Bathrooms: </label><span> {$Record.Baths|number_format:0}</span>
        {/if}
        {if $Record.Parking > 0}
            <label>Parking: </label><span> {$Record.Parking}</span>
        {/if}
        {if $Record.Garage > 0}
            <label>Garage Space: </label><span> {$Record.Garage}</span>
        {/if}
        {if $Record.YearBuilt}
            <label>Year Built:</label><span> {$Record.YearBuilt}</span>
        {/if}
        {if $Record.TotalAcreage > 0}
            <label>Lot Size:</label><span> {if $Record.TotalAcreage > 0}{$Record.TotalAcreage} ac{/if}</span>
        {/if}
        {if $Record.LotDimensions}
            <label>Lot Dimensions:</label><span> {$Record.LotDimensions}</span>
        {/if}
        {if $Record.Buildings}
            <label># of Buildings:</label><span> {$Record.Buildings}</span>
        {/if}
        {if $Record.Construction}
            <label>Construction:</label><span> {$Record.Construction}</span>
        {/if}
        {if $Record.Zoning}
            <label>Zoning:</label><span> {$Record.Zoning}</span>
        {/if}
        {if $Record.Levels}
            <label>Levels:</label><span> {$Record.Levels}</span>
        {/if}
        {if $Record.Elementary_School}
            <label>Elementary School: </label><span> {$Record.Elementary_School|lower|ucwords}</span>
        {/if}
        {if $Record.Middle_School}
            <label>Middle School:</label><span> {$Record.Middle_School|lower|ucwords}</span>
        {/if}
        {if $Record.High_School}
            <label>High School: </label><span> {$Record.High_School|lower|ucwords}</span>
        {/if}
        {if $Record.View}
            <label>View:</label><span> {$Record.View}</span>
        {/if}
        {if $Record.School_District}
            <label>School District:</label><span> {$Record.School_District}</span>
        {/if}

        {if $Record.Begin_Date}
            <label>Begin Date: </label><span> {$Record.Begin_Date}</span>
        {/if}

        {if $Record.End_Date > 0000-00-00}
            <label>End Date: </label><span> {$Record.End_Date}</span>
        {/if}
    </div>
    {if $Record.Description}
        <h2>Description</h2>
        <p class="pro-description">{$Record.Description}</p>
    {/if}
    {if $Record.Legal}
        <h2>Legal Description</h2>
        <p class="pro-description">{$Record.Legal}</p>
    {/if}
    {if $Record.Heating || $Record.Cooling || $Record.Water || $Record.Sewer || $Record.WaterHeaterFeatures || $Record.PropaneTank || $Record.WaterSoftner || $Record.TVEquipt || $Record.Fireplace || $Record.Gas || $Record.Electricity}
        <h2>Utilities</h2>
        <div class="pro-details-box">
            {if $Record.Heating}
                <label>Heating:</label>		<span> {$Record.Heating}</span>
            {/if}
            {if $Record.Cooling}
                <label>Cooling:</label>		<span> {$Record.Cooling}</span>
            {/if}
            {if $Record.Water}
                <label>Water:</label>		<span> {$Record.Water}</span>
            {/if}
            {if $Record.Sewer}
                <label>Sewer:</label>		<span> {$Record.Sewer}</span>
            {/if}
            {if $Record.WaterHeaterFeatures}
                <label>Water Heater Features:</label>		<span> {$Record.WaterHeaterFeatures}</span><br class="fclear">
            {/if}
            {if $Record.PropaneTank}
                <label>Propane Tank:</label>		<span> {$Record.PropaneTank}</span>
            {/if}
            {if $Record.WaterSoftner}
                <label>Water Softner:</label>		<span> {$Record.GarageFeatures}</span>
            {/if}
            {if $Record.TVEquipt}
                <label>TV Reception Equipt:</label>		<span> {$Record.TVEquipt}</span>
            {/if}
            {if $Record.Fireplace}
                <label>Fireplace:</label>		<span> {$Record.Fireplace}</span>
            {/if}
            {if $Record.Gas}
                <label>Gas:</label>		<span> {$Record.Gas}</span>
            {/if}
            {if $Record.Electricity}
                <label>Electricity:</label>		<span> {$Record.Electricity}</span>
            {/if}
        </div>
    {/if}
    {if $Record.Dishwasher || $Record.Range_Oven || $Record.Disposal || $Record.Refrigerator}
        <h2>Appliances</h2>
        <div class="pro-details-box">
            {if $Record.Dishwasher}
                <label>Dishwasher:</label>		<span> {$Record.Dishwasher}</span>
            {/if}
            {if $Record.Range_Oven}
                <label>Range/Oven:</label>		<span> {$Record.Range_Oven}</span>
            {/if}
            {if $Record.Disposal}
                <label>Disposal:</label>		<span> {$Record.Disposal}</span>
            {/if}
            {if $Record.Refrigerator}
                <label>Refrigerator:</label>		<span> {$Record.Refrigerator}</span>
            {/if}
        </div>
    {/if}
    {if $Record.Drapes || $Record.HouseColor || $Record.Roofing || $Record.Siding || $Record.Basement || $Record.FireplaceFeatures || $Record.Curb_Gutter || $Record.Paving || $Record.BuildingSize || $Record.OtherBuildings || $Record.Construction || $Record.Specials || $Record.Survey}
        <h2>Miscellaneous</h2>
        <div class="pro-details-box">
            {if $Record.Drapes}
                <label>Drapes:</label>		<span> {$Record.Drapes}</span>
            {/if}
            {if $Record.HouseColor}
                <label>House Color:</label>		<span> {$Record.HouseColor}</span>
            {/if}
            {if $Record.Roofing}
                <label>Roof:</label>		<span> {$Record.Roofing}</span>
            {/if}
            {if $Record.Siding}
                <label>Siding:</label>		<span> {$Record.Siding}</span>
            {/if}
            {if $Record.Basement}
                <label>Basement:</label>		<span> {$Record.Basement}</span>
            {/if}
            {if $Record.FireplaceFeatures}
                <label>Fireplace:</label>		<span> {$Record.FireplaceFeatures}</span>
            {/if}
            {if $Record.Curb_Gutter}
                <label>Curb & Gutter:</label>		<span> {$Record.Curb_Gutter}</span>
            {/if}
            {if $Record.Paving}
                <label>Paving:</label>		<span> {$Record.Paving}</span>
            {/if}
            {if $Record.BuildingSize}
                <label>Building Size:</label>		<span> {$Record.BuildingSize}</span>
            {/if}
            {if $Record.OtherBuildings}
                <label>Other Buildings:</label>		<span> {$Record.OtherBuildings}</span>
            {/if}
            {if $Record.Construction}
                <label>Construction:</label>		<span> {$Record.Construction}</span>
            {/if}
            {if $Record.Specials}
                <label>Specials:</label>		<span> {$Record.Specials}</span>
            {/if}
            {if $Record.Survey}
                <label>Survey:</label>		<span> {$Record.Survey}</span>
            {/if}
        </div>
    {/if}
    {if $Record.Latitude != 0 && $Record.Longitude != 0}
        <h2>Location</h2>
        <div class="pro-location">
{*            <div id="map-container" class="map-holder"><div style="text-align:center"><br /><b>Loading...</b></div></div>*}
           {* <script type="text/javascript">
                //<![CDATA[
                setTimeout('loadGoogleMap("map-container", "{$Record.Latitude}", "{$Record.Longitude}", "MLS# {$Record.MLS_NUM}, {$Record.address_full}", "{$Templates_Image}/map_icon_home.png")', 5000);
                //]]>
            </script>*}
            <iframe width="100%" height="400" id="gmap_canvas" src="https://maps.google.com/maps?key={$google_api_key}&q={$Record.StreetNumber} {$Record.StreetName},{$Record.CityName},{$Record.State},{$Record.ZipCode}&output=embed" frameborder="0" scrolling="no"></iframe>

        </div>
    {/if}
    <h2>This listing courtesy of:</h2>
    <div>
        <p>{$Record.Office_Name|lower|ucwords|escape} {if $Record.Office_Phone}: {$Record.Office_Phone}{/if}</p>
        <p>{$Record.Agent_FullName|lower|ucwords|escape}</p>
    </div>

</div>