<?php
/**
 * @version $Id: default_map.php 375 2015-02-21 16:30:36Z michal $
 * @package DJ-Catalog2
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Michal Olczyk - michal.olczyk@design-joomla.eu
 *
 * DJ-Catalog2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Catalog2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Catalog2. If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined ('_JEXEC') or die('Restricted access');


$app = JFactory::getApplication();

$document= JFactory::getDocument();
$config = JFactory::getConfig();

if($this->params->get('show_location_map_item', true )){
	if($config->get('force_ssl',0)==2){
		$document->addScript("https://maps.google.com/maps/api/js?sensor=false");
	}else{
		$document->addScript("http://maps.google.com/maps/api/js?sensor=false");
	}
}

$item = $this->item;

?>
<div class="djc_location">
	<h3>
		<?php echo JText::_('COM_DJCATALOG2_LOCATION'); ?>
	</h3>
	<div class="row-fluid">

		<?php if( (int)$this->params->get('show_location_details_item', true) > 0) { ?>
			<?php
			$address = array();
			 
			if (($this->params->get('location_address_item', 1) == '1') && $item->address) {
				$address[] = $item->address;
			}
			if (($this->params->get('location_postcode_item', 1) == '1') && $item->postcode) {
				$address[] = $item->postcode;
			}
			if (($this->params->get('location_city_item', 1) == '1') && $item->city) {
				$address[] = $item->city;
			}
			if (($this->params->get('location_country_item', 1) == '1') && $item->country_name) {
				$address[] = $item->country_name;
			}
			
			if (count($address)) { ?>
			<p class="djc_address"><?php echo implode(', ', $address); ?></p>
			<?php }
				
				$contact = array();
				
				if (($this->params->get('location_phone_item', 1) == '1') && $item->phone) {
					$contact[] = JText::_('COM_DJCATALOG2_UP_PHONE').': <span>'.$item->phone.'</span>';
				}
				if (($this->params->get('location_mobile_item', 1) == '1') && $item->mobile) {
					$contact[] = JText::_('COM_DJCATALOG2_UP_MOBILE').': <span>'.$item->mobile.'</span>';
				}
				if (($this->params->get('location_fax_item', 1) == '1') && $item->fax) {
					$contact[] = JText::_('COM_DJCATALOG2_UP_FAX').': <span>'.$item->fax.'</span>';
				}
				if (($this->params->get('location_website_item', 1) == '1') && $item->website) {
					$website = (strpos($item->website, 'http') === 0) ? $item->website : 'http://'.$item->website;
            		$website = preg_replace('#([\w]+://)([^\s()<>]+)#iS', '<a target="_blank" href="$1$2">$2</a>', htmlspecialchars($item->website));
            		$contact[] = JText::_('COM_DJCATALOG2_UP_WEBSITE').': <span>'.$website.'</span>';
				}
				if (($this->params->get('location_email_item', 1) == '1') && $item->email) {
					$email = preg_replace('#([\w.-]+(\+[\w.-]+)*@[\w.-]+)#i', '<a target="_blank" href="mailto:$1">$1</a>', htmlspecialchars($item->email));
					$contact[] = JText::_('COM_DJCATALOG2_UP_EMAIL').': <span>'.$email.'</span>';
				}
				
				if (count($contact)) { ?>
			<p class="djc_contact"><?php echo implode('<br />', $contact);?></p>
			<?php } ?>
		<?php } ?>

		<?php if($this->params->get('show_location_map_item', 1) && $this->item->latitude != 0.0 && $this->item->longitude != 0.0 ) {?>
		<div id="google_map_box" style="display: none;" class="djc_map_wrapper">
			<div id="map" style="width: <?php echo $this->params->get('gm_map_width_item', '100%');?>; height: <?php echo $this->params->get('gm_map_height_item', '300px');?>"></div>
		</div>
		<?php }	?>

	</div>
</div>

<?php if($this->params->get('show_location_map_item', true) && $this->item->latitude != 0.0 && $this->item->longitude != 0.0 ) {?>
<script type="text/javascript">
		
		window.addEvent('load', function(){ 
			DJCatalog2GMStart();
		});
	<?php 
		$marker_link = JRoute::_(DJCatalogHelperRoute::getItemRoute($item->slug, $item->catslug));
        $marker_title = addslashes(htmlspecialchars($item->name));
        
        $address = array();
        $marker_address = '';
        
        if ($item->address) {
            $address[] = addslashes($item->address);
        }
        if ($item->postcode) {
            $address[] = addslashes($item->postcode);
        }
        if ($item->city) {
            $address[] = addslashes($item->city);
        }
        if ($item->country_name) {
            $address[] = addslashes($item->country_name);
        }
        
        if (count($address)) {
            $marker_address = implode(', ', $address);
            $marker_address = htmlspecialchars($marker_address);
        }
        
        $contact = array();
        $marker_contact = '';
        
        if ($item->phone) {
            $contact[] = JText::_('COM_DJCATALOG2_UP_PHONE').': <span>'.addslashes(htmlspecialchars($item->phone)).'</span>';
        }
        if ($item->mobile) {
            $contact[] = JText::_('COM_DJCATALOG2_UP_MOBILE').': <span>'.addslashes(htmlspecialchars($item->mobile)).'</span>';
        }
        if ($item->fax) {
            $contact[] = JText::_('COM_DJCATALOG2_UP_FAX').': <span>'.addslashes(htmlspecialchars($item->fax)).'</span>';
        }
        if ($item->website) {
            $item->website = (strpos($item->website, 'http') === 0) ? $item->website : 'http://'.$item->website;
            $item->website = preg_replace('#([\w]+://)([^\s()<>]+)#iS', '<a target=\"_blank\" href=\"$1$2\">$2</a>', addslashes(htmlspecialchars($item->website)));
            $contact[] = JText::_('COM_DJCATALOG2_UP_WEBSITE').': <span>'.$item->website.'</span>';
        }
        if ($item->email) {
            $item->email = preg_replace('#([\w.-]+(\+[\w.-]+)*@[\w.-]+)#i', '<a target=\"_blank\" href=\"mailto:$1\">$1</a>', addslashes(htmlspecialchars($item->email)));
            $contact[] = JText::_('COM_DJCATALOG2_UP_EMAIL').': <span>'.$item->email.'</span>';
        }
        
        if (count($contact)) {
            $marker_contact = implode('<br />', $contact);
            $marker_contact = $marker_contact;
        }
        
        
        $marker_txt = '<div style=\"min-width: 250px;\">';
        $marker_txt .= '<p><a href=\"'.$marker_link.'\">'.$marker_title.'</a></p>';
        $marker_txt .= '<p>'.$marker_address.'</p>';
        $marker_txt .= '<p>'.$marker_contact.'</p>';
        $marker_txt .= '</div>';

		?>
	        var djc2_map;
	        var djc2_map_marker = new google.maps.InfoWindow();
	        var djc2_geocoder = new google.maps.Geocoder();
	        
			function DJCatalog2GMAddMarker(position,txt,icon)
			{
			    var MarkerOpt =  
			    { 
			        position: position, 
			        icon: icon,	
			        map: djc2_map
			    } 
			    var marker = new google.maps.Marker(MarkerOpt);
			    marker.txt=txt;
			     
			    google.maps.event.addListener(marker,"click",function()
			    {
			        djc2_map_marker.setContent(marker.txt);
			        djc2_map_marker.open(djc2_map,marker);
			    });
			    return marker;
			}
			    	
			 function DJCatalog2GMStart()    
			 {   		 	 
	             <?php /*
	             	 $icon_img = ''; 
					 $icon_size='';
	             	 if($this->params->get('gm_icon',1)==1 && file_exists(JPATH_BASE.'/images/djcf_gmicon_'.$this->item->cat_id.'.png')){ 
	             		$icon_size = getimagesize(JPATH_BASE.'/images/djcf_gmicon_'.$this->item->cat_id.'.png');
	             		$icon_img = JURI::base().'images/djcf_gmicon_'.$this->item->cat_id.'.png';             		
	        		 }else if($this->params->get('gm_icon',1)==1 && file_exists(JPATH_BASE.'/images/djcf_gmicon.png')){
	        			 $icon_size = getimagesize(JPATH_BASE.'/images/djcf_gmicon.png');
	                	 $icon_img = JURI::base()."images/djcf_gmicon.png";
	                 }elseif($this->params->get('gm_icon',1)==1){ 
	                	 $icon_size = getimagesize(JPATH_BASE.'/components/com_djclassifieds/assets/images/djcf_gmicon.png');
	                	 $icon_img = JURI::base()."components/com_djclassifieds/assets/images/djcf_gmicon.png";
	                 }
	                 //$icon_img = ''; 
	                 if($icon_img && is_array($icon_size)){ 
	                 	 $anchor_w = $icon_size[0]/2;?>
			             var size = new google.maps.Size(<?php echo $icon_size[0].','.$icon_size[1];?>);
			             var start_point = new google.maps.Point(0,0);
			             var anchor_point = new google.maps.Point(<?php echo $anchor_w.','.$icon_size[1];?>);   
			             var icon = new google.maps.MarkerImage("<?php echo $icon_img;?>", size, start_point, anchor_point);                
	                <?php }else{ ?>
	              		 var icon = '';  	
	                <?php }*/?>

	            var icon = '';
	                
	             	
				<?php if($this->item->latitude != '0.000000000000000' && $this->item->longitude != '0.000000000000000'){ ?>
					document.getElementById("google_map_box").style.display='block';
					var adLatlng = new google.maps.LatLng(<?php echo $this->item->latitude.','.$this->item->longitude; ?>);
					    var MapOptions = {
					       zoom: <?php echo $this->params->get('gm_zoom_item','10'); ?>,
					  		center: adLatlng,
					  		mapTypeId: google.maps.MapTypeId.<?php echo $this->params->get('gm_type_item','ROADMAP'); ?>,
					  		navigationControl: true
					    };
					    djc2_map = new google.maps.Map(document.getElementById("map"), MapOptions); 				   
				    	var marker = DJCatalog2GMAddMarker(adLatlng,'<?php echo $marker_txt; ?>',icon);
				<?php } else { ?>
					var adres = '<?php echo $this->item->country_name; if($this->item->city != '' ){echo ", ".str_ireplace("'", "&apos;",$this->item->city);} if($this->item->address!='' ){echo ", ".str_ireplace("'", "&apos;",$this->item->address);}?>';
					djc2_geocoder.geocode({address: adres}, function (results, status)
					{
					    if(status == google.maps.GeocoderStatus.OK)
					    {
					    	document.getElementById("google_map_box").style.display='block';
						    var MapOptions = {
						       zoom: <?php echo $this->params->get('gm_zoom_item','10'); ?>,
						  		center: results[0].geometry.location,
						  		mapTypeId: google.maps.MapTypeId.<?php echo $this->params->get('gm_type_item','ROADMAP'); ?>,
						  		navigationControl: true
						    };
						    djc2_map = new google.maps.Map(document.getElementById("map"), MapOptions); 
					    	var marker = DJCatalog2GMAddMarker(results[0].geometry.location,"<?php echo $marker_txt; ?>",icon);
					    }
					});		
				<?php } ?>      
			 }
</script>
<?php } ?>