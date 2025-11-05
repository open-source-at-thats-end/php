<?php
	require ('../../../../../../wp-load.php');
	require ('../../../../../../wp-includes/pluggable.php');

	require_once ('../../../index.php');
	/*require_once ($arrOREPhysicalPath['DBAccess']. 'OREDAOPredefinedSearch.php');
    //require_once ($arrOREPhysicalPath['DBAccess']. 'OREDAOCommunityMap.php');

    $objPSearch = OREDAOPredefinedSearch::getInstance();
    //$objCmap = OREDAOCommunityMap::getInstance();

	# Get All searhces
	$arrSearch = $objPSearch->getKeyValueArray();

    # Get All Communities
	//$arrCommunity = $objCmap->getKeyValueArray();

	# Get Options
	$arrYesNo = OREStaticArray::arrYesNo();
	$arrSortingOption = OREStaticArray::arrSortingOption();
	$arrViewType = OREStaticArray::arrViewType();
	$arrPagination = OREStaticArray::arrPagination();*/
$objAPI = IDXAPI::getInstance();
# Get Options
$meta = $objAPI->getMeta(array('PropertyType','PropertyStyle','City','Area','Subdivision','SubType'));
                $arrPriceRange	  =	StaticArray::arrPriceRange('');
                $arrSqftRange	  =	StaticArray::arrSQFTRange('');
                $arrBedRange	  =	StaticArray::arrBedRange('');
                $arrBathRange	  =	StaticArray::arrBedRange('');
                $arrGarageRange   =	StaticArray::arrBedRange('');
                $arrShowOnly	  =	StaticArray::arrShowOnly();
                $arrLotSize	      =	StaticArray::arrLotSize();
                $arrminYearBuild  =	StaticArray::arrYearBuild('from');
                $arrmaxYearBuild  =	StaticArray::arrYearBuild('to');
                $arrYesNo	      =	StaticArray::arrYesNo();
                $arrStatus	      =	StaticArray::arrStatus();
                $arrSortingOption =	StaticArray::arrSortingOption();
                $arrDayMarket	  =	StaticArray::arrDayMarket();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Add Shortcode For Generating Search Results</title>
        <style>
            .nav-tabs {margin:0; padding:0;}
            .nav-tabs li { display:inline-block; background:#ccc; margin:0; padding:5px 8px;}
            .nav-tabs li.active { border:1px solid #000; border-bottom:none;}
            .nav-tabs li a { color:#fff; text-decoration: none;}
            .nav-tabs li.active a { color:#000;}

            .tab-content {border:1px solid #000; padding:2px 4px;}
            .tab-content .tab-pane {display:none;}
            .tab-content .tab-pane.active {display:block;}
            .widefat{
                padding: 3px 50px;
            }
            th{
                float: left;
                padding: 20px 10px 20px 0;
            }
            #frmShortcodeParams{
                margin-bottom: 20px;
            }
            .text-center{
                text-align: center;
            }
        </style>
		<script type="text/javascript"
			src="../../../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
		<script type="text/javascript"
			src="../../../../../../../wp-includes/js/jquery/jquery.js"></script>
		<script type="text/javascript" src="./js/dialog.js"></script>
	</head>
	<body>

       <div class="tab-content">
            <div id="tab-sc-pre-search" class="active tab-pane well wellmedpadd">
        		<form id="frmShortcodeParams">
            		<table class="mceActionPanel">
            			<tr>
            				<th>Property Type</th>

                            <td>
                                <select id="ptype" name="ptype" class="widefat">
                                    <option value="">Any</option>
						            <?php
						            foreach($meta['PropertyType'] as $key => $val) {
							            echo '<option value="'.$key.'">'.$val.'</option>';
						            }
						            ?>
                                </select>
                            </td>
            			</tr>

            			<tr>
            				<th>Property Style</th>
                            <td>
                                <select id="pstyle" name="pstyle" class="widefat">
                                    <option value="">Any</option>
                                    <?php
                                        foreach($meta['PropertyStyle'] as $key => $val) {
                                            echo '<option value="'.$key.'">'.$val.'</option>';
                                        }
                                    ?>
                                </select>
                            </td>
            			</tr>
                        <tr>
                            <th>Price Range </th>
                            <td>
                                <select id="minprice" name="minprice" class="widefat">
                                    <option value="">Min</option>
			                        <?php
			                        foreach($arrPriceRange as $key => $val) {
				                        echo '<option value="'.$key.'">'.$val.'</option>';
			                        }
			                        ?>
                                </select>
                                <select id="maxprice" name="maxprice" class="widefat">
                                    <option value="">Max</option>
			                        <?php
			                        foreach($arrPriceRange as $key => $val) {
				                        echo '<option value="'.$key.'">'.$val.'</option>';
			                        }
			                        ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>City </th>
                            <td>
                                <select id="city" name="city" class="widefat">
                                    <option value="">Any</option>
                                    <?php
                                    foreach($meta['City'] as $key => $val) {
                                        echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Subdivision </th>
                            <td>
                                <select id="sdivlist" name="sdivlist" class="widefat">
                                    <option value="">Any</option>
                                    <?php
                                    foreach($meta['Subdivision'] as $key => $val) {
	                                    echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Lot Size</th>
                            <td>
                                <select id="minlotsize" name="minlotsize" class="widefat">
                                    <option value="">Min</option>
                                    <?php
                                    foreach($arrLotSize as $key => $val) {
                                        echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                                <select id="maxlotsize" name="maxlotsize" class="widefat">
                                    <option value="">Max</option>
                                    <?php
                                    foreach($arrLotSize as $key => $val) {
                                        echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Year Built </th>
                            <td>
                                <select id="minyear" name="minyear" class="widefat">
                                    <option value="">Min</option>
                                    <?php

                                    foreach($arrminYearBuild['YearFrom'] as $key => $val) {
                                        echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                                <select id="maxyear" name="maxyear" class="widefat">
                                    <option value="">Max</option>
                                    <?php

                                    foreach($arrmaxYearBuild['YearTo'] as $key => $val) {
                                        echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Days on Market </th>
                            <td>
                                <select id="dom" name="dom" class="widefat">
                                    <option value="">Any</option>
                                    <?php
                                    foreach($arrDayMarket as $key => $val) {
                                        echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <th>Sqft Range </th>
                            <td>
                                <select id="minsqft" name="minsqft" class="widefat">
                                    <option value="">Min</option>
                                    <?php
                                    foreach($arrSqftRange as $key => $val) {
                                        echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                                <select id="maxsqft" name="maxsqft" class="widefat">
                                    <option value="">Max</option>
                                    <?php
                                    foreach($arrSqftRange as $key => $val) {
                                        echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Waterfront </th>
                            <td>

                                <select id="waterfront" name="waterfront" class="widefat">
                                    <option value="">Any</option>
                                    <?php
                                    foreach($arrYesNo as $key => $val) {
                                        echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Pool </th>
                            <td>

                                <select id="pool" name="pool" class="widefat">
                                    <option value="">Any</option>
			                        <?php
			                        foreach($arrYesNo as $key => $val) {
				                        echo '<option value="'.$key.'">'.$val.'</option>';
			                        }
			                        ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Pets Allowed </th>
                            <td>

                                <select id="petsallowed" name="petsallowed" class="widefat">
                                    <option value="">Any</option>
						            <?php
						            foreach($arrYesNo as $key => $val) {
							            echo '<option value="'.$key.'">'.$val.'</option>';
						            }
						            ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th># of Bedrooms </th>
                            <td>
                                <select id="minbed" name="minbed" class="widefat">
                                    <?php
                                    foreach($arrBedRange as $key => $val) {
                                        echo '<option value="'.$key.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th># of Bathrooms </th>
                            <td>
                                <select id="minbath" name="minbath" class="widefat">
						            <?php
						            foreach($arrBathRange as $key => $val) {
							            echo '<option value="'.$key.'">'.$val.'</option>';
						            }
						            ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Zipcode </th>
                            <td>
                                <input type="text" id="zipcode" name="zipcode" value="" class="widefat"/>
                            </td>
                        </tr>
                        <tr>
                            <th>Agent Id </th>
                            <td>
                                <input type="text" id="agent" name="agent" value="" class="widefat"/>
                            </td>
                        </tr>
                        <tr>
                            <th>Office Id </th>
                            <td>
                                <input type="text" id="office" name="office" value="" class="widefat"/>
                            </td>
                        </tr>
                        <tr>
                            <th>Keyword </th>
                            <td>
                                <input type="text" id="kword" name="kword" value="" class="widefat"/>
                            </td>
                        </tr>
                        <tr>
                            <th>Sort By </th>
                            <td>
                                <select id="sort_by" name="sort_by" class="widefat">
						            <?php
						            foreach($arrSortingOption as $key => $val) {
							            echo '<option value="'.$key.'">'.$val.'</option>';
						            }
						            ?>
                                </select>
                            </td>
                        </tr>
            			<tr>
            				<th>Limit</th>
                            <td>
            				    <input type="text" id="limit" name="limit" value="" class="widefat"/>
                            </td>
            			</tr>
            		</table>
            		<div class="mceActionPanel text-center">
            			<input type="button" class="button text-center" name="insertSearchResults" value="Insert" onclick="OREDialog.insertShortCode_Search();" />
            		</div>
        		</form>
            </div>
            <div id="tab-sc-house-plan" class="tab-pane well wellmedpadd">
                <form id="frmHousePlanShortcodeParams">
                    <div class="mceActionPanel">
                        <p>
                            <label for="sort_by">Max Results </label>
                            <input type="text" name="hlimit" id="hlimit" value="" />
                        </p>
                    </div>
                    <div class="mceActionPanel">
            			<input type="button" class="button" name="insertHousePlan" value="Insert" onclick="OREDialog.insertShortCode_HousePlans();" />
            		</div>
                </form>
            </div>
       </div>
	</body>
</html>