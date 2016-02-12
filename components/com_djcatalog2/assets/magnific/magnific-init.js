jQuery(document).ready(function(){
	jQuery('.djc_images').each(function() {
		jQuery(this).magnificPopup({
	        delegate: 'a.djimagebox', // the selector for gallery item
	        type: 'image',
	        mainClass: 'mfp-img-mobile',
	        gallery: {
	          enabled: true
	        },
			image: {
				verticalFit: true
			}
	    });
	});
	jQuery('.djc_items').each(function() {
		jQuery(this).magnificPopup({
	        delegate: 'a.djimagebox', // the selector for gallery item
	        type: 'image',
	        mainClass: 'mfp-img-mobile',
	        gallery: {
	          enabled: true
	        },
			image: {
				verticalFit: true
			}
	    });
	});
	jQuery('.djc_subcategories').each(function() {
		jQuery(this).magnificPopup({
	        delegate: 'a.djimagebox', // the selector for gallery item
	        type: 'image',
	        mainClass: 'mfp-img-mobile',
	        gallery: {
	          enabled: true
	        },
			image: {
				verticalFit: true
			}
	    });
	});
});