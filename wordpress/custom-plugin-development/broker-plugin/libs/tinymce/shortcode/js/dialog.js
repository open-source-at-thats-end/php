jQuery(document).ready(function(){

    jQuery('.nav-tabs li').click(function(){
        jQuery('.nav-tabs li').removeClass('active');

        jQuery(this).addClass('active');

        jQuery('.tab-content .tab-pane').hide().removeClass('active');

        jQuery('.tab-content ' + jQuery(this).find('a').attr('href')).show().addClass('active');

    });
});

tinyMCEPopup.requireLangPack();

var OREDialog = {
	init : function() {
	},

	insertShortCode_Search : function() {
		var theForm=document.forms[0] ;

		// Insert the contents from the input into the document
		var listingShortCode = "[listing-search-result";
        if(jQuery("#ptype").val() !== "")
        {
            listingShortCode += " ptype="+ jQuery("#ptype").val().replace(' ','-');
        }


		if(jQuery("#pstyle").val() !== "")
		{
		    listingShortCode += " pstyle="+ jQuery("#pstyle").val();

		}

		if(jQuery("#city").val() !== "")
		{
		    listingShortCode += " city="+ jQuery("#city").val().replace(' ','-');

		}
		if(jQuery("#sdivlist").val() !== "")
		{
		    listingShortCode += " sdivlist="+ jQuery("#sdivlist").val();

		}
		if(jQuery("#maxprice").val() !== "")
		{
		    listingShortCode += " maxprice="+ jQuery("#maxprice").val();

		}
        if(jQuery("#minprice").val() !== "")
        {
            listingShortCode += " minprice="+ jQuery("#minprice").val();

        }
		if(jQuery("#minlotsize").val() !== "")
		{
		    listingShortCode += " minlotsize="+ jQuery("#minlotsize").val();

		}
		if(jQuery("#maxlotsize").val() !== "")
		{
		    listingShortCode += " maxlotsize="+ jQuery("#maxlotsize").val();

		}
		if(jQuery("#minyear").val() !== "")
		{
		    listingShortCode += " minyear="+ jQuery("#minyear").val();

		}
		if(jQuery("#maxyear").val() !== "")
		{
		    listingShortCode += " maxyear="+ jQuery("#maxyear").val();

		}
		if(jQuery("#dom").val() !== "")
		{
		    listingShortCode += " dom="+ jQuery("#dom").val();

		}
		if(jQuery("#minsqft").val() !== "")
		{
		    listingShortCode += " minsqft="+ jQuery("#minsqft").val();

		}
		if(jQuery("#maxsqft").val() !== "")
		{
		    listingShortCode += " maxsqft="+ jQuery("#maxsqft").val();

		}
		if(jQuery("#waterfront").val() !== "")
		{
		    listingShortCode += " waterfront="+ jQuery("#waterfront").val();

		}
		if(jQuery("#pool").val() !== "")
		{
		    listingShortCode += " pool="+ jQuery("#pool").val();

		}
		if(jQuery("#petsallowed").val() !== "")
		{
		    listingShortCode += " petsallowed="+ jQuery("#petsallowed").val();

		}
		if(jQuery("#minbed").val() !== "")
		{
		    listingShortCode += " minbed="+ jQuery("#minbed").val();

		}
		if(jQuery("#minbath").val() !== "")
		{
		    listingShortCode += " minbath="+ jQuery("#minbath").val();

		}
        if(jQuery("#zipcode").val() !== "")
        {
            listingShortCode += " zipcode="+ jQuery("#zipcode").val();

        }
        if(jQuery("#agent").val() !== "")
        {
            listingShortCode += " agent="+ jQuery("#agent").val();

        }
        if(jQuery("#office").val() !== "")
        {
            listingShortCode += " office="+ jQuery("#office").val();

        }
        if(jQuery("#kword").val() !== "")
        {
            listingShortCode += " kword="+ jQuery("#kword").val();

        }
        if(jQuery("#sort_by").val() !== "")
        {
            listingShortCode += " sortby="+ jQuery("#sort_by").val();

        }
        if(jQuery("#limit").val() !== "")
        {
            listingShortCode += " limit="+ jQuery("#limit").val();

        }



		listingShortCode += "]";

		tinyMCEPopup.editor.execCommand('mceInsertContent', false, listingShortCode);
		tinyMCEPopup.close();
	},

    insertShortCode_HousePlans : function() {
        var theForm=document.forms[0];

        var listingShortCode = "[ore-house-plan";

        if(jQuery("#hlimit").val() != "")
		{
			listingShortCode += " hlimit="
					+ jQuery("#hlimit").val();
		}

        listingShortCode += "]";

        tinyMCEPopup.editor.execCommand('mceInsertContent', false, listingShortCode);
		tinyMCEPopup.close();
    },

    insertShortCode_CommunityMap : function() {
		var theForm=document.forms[0] ;

		// Insert the contents from the input into the document
		var listingShortCode = "[ore-community-map";

		listingShortCode += " cmapid="
				+ jQuery("#cmapid").val();

		if(jQuery("#cmap_show_sort").val() == "yes")
		{
			if(jQuery("#cmap_sort_by").val() != "")
			{
				listingShortCode += " sort_by="
						+ jQuery("#cmap_sort_by").val();
			}
		}
		else
		{
			listingShortCode += " show_sort="
				+ jQuery("#cmap_show_sort").val();
		}

		if(jQuery("#cmap_view_type").val() != "")
		{
			listingShortCode += " view_type="
					+ jQuery("#cmap_view_type").val();
		}

		if(jQuery("#cmap_pagination").val() != "")
		{
			listingShortCode += " pagination="
					+ jQuery("#cmap_pagination").val();
		}

        if(jQuery("#cmap_show_results").val() != "")
		{
			listingShortCode += " show_results="
					+ jQuery("#cmap_show_results").val();
		}

		/*if(jQuery("#limit").val() != "")
		{
			listingShortCode += " limit="
					+ jQuery("#limit").val();
		}*/

		listingShortCode += "]";

		tinyMCEPopup.editor.execCommand('mceInsertContent', false, listingShortCode);
		tinyMCEPopup.close();
	}
}

tinyMCEPopup.onInit.add(OREDialog.init, OREDialog);