	
	
	jQuery(document).ready(function(){
		var main_url;
		var filter;
		var pathname = window.location.href;
		var url = new URL(pathname);
		var lang = url.searchParams.get("lang");
		jQuery(".facetwp-facet.facetwp-facet-search_route.facetwp-type-fselect").click(function() { 
            var $filter = jQuery(".fs-search input");

                $filter.keyup(function(){
                // Retrieve the input field text
                filter = jQuery(this).val();
				});
			
		});

		if ( lang ) {
			main_url = window.location.protocol + "//" + window.location.host + "/" + "route/?lang=en&";
		} else {
			main_url = window.location.protocol + "//" + window.location.host + "/" + "route?";
		}
		jQuery('#vn-menu-search-lente').click(function(){
			location.href = main_url + "wm_route_code=" + filter;
		});

		jQuery('#vn-menu-search-map').click(function(){
			location.href = main_url + "wm_route_code=" + filter + "&fwp_map=1";
		});
		
		
		
		jQuery(".facetwp-facet.facetwp-facet-search_route.facetwp-type-fselect").click(function() 		{ 
			jQuery('input').keydown(function(event){
				var keycode = (event.key ? event.key : event.which);
				if(keycode == 'Enter'){
					FWP.parse_facets();
					FWP.set_hash();
					jQuery( "#vn-menu-search-lente" ).trigger( "click" ); 
				}
			});
		});

		
		
	});


