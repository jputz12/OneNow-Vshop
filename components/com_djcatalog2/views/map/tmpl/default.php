<?php
/**
 * @version $Id: default.php 375 2015-02-21 16:30:36Z michal $
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
$user = JFactory::getUser();

$document= JFactory::getDocument();
$config = JFactory::getConfig();

if($config->get('force_ssl',0)==2){
    $document->addScript("https://maps.google.com/maps/api/js?sensor=false");
}else{
    $document->addScript("http://maps.google.com/maps/api/js?sensor=false");
}
$document->addScript(JURI::base(true).'/components/com_djcatalog2/assets/mapclustering/src/markerclusterer.js');

?>

<?php //if ($this->params->get( 'show_page_heading', 1)) { ?>
<h1
    class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ) ?>">
    <?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php //} ?>

<div id="djcatalog"
    class="djc_mapview<?php echo $this->params->get( 'pageclass_sfx' ).' djc_theme_'.$this->params->get('theme','default') ?>">
    
    <?php if (($this->params->get('show_category_filter_map', 1) > 0 || $this->params->get('show_producer_filter_map', 1) > 0  || $this->params->get('show_search_map', 1) > 0)) { ?>
        <div class="djc_filters djc_clearfix" id="tlb">
            <?php echo $this->loadTemplate('filters'); ?>
        </div>
    <?php } ?>

    <div id="djc2_map_box" style="display: none;"  class="djc_map_wrapper">
        <div id="djc2_map" class="djc2_map" style="width: <?php echo $this->params->get('gm_map_width', '100%');?>; height: <?php echo $this->params->get('gm_map_height', '400px');?>">
        </div>
    </div>


    <?php 
    if ($this->params->get('show_footer')) echo DJCATFOOTER;
    ?>
</div>

<script type="text/javascript">

window.addEvent('load', function(){
        DJCatalog2GMClusterStart();
});

         var djc2_map;
         var djc2_map_marker = new google.maps.InfoWindow();
         var djc2_geocoder = new google.maps.Geocoder();
         var djc2_map_markers = new Array();        
                
        function DJCatalog2GMClusterMarker(position,txt,icon)
        {           
            var MarkerOptions =  
            { 
                position: position, 
                icon: icon
            }; 
            var marker = new google.maps.Marker(MarkerOptions);
            marker.txt=txt;
             
            google.maps.event.addListener(marker, "click", function()
            {
                djc2_map_marker.setContent(marker.txt);
                djc2_map_marker.open(djc2_map, marker);
            });
            return marker;
        }       
                
         function DJCatalog2GMClusterStart()    
         {           

            djc2_geocoder.geocode({address: '<?php echo ($this->lists['search']) ? $this->escape($this->lists['search']) : $this->params->get('gm_start_location', 'World'); ?>'}, function (results, status)
            {
                if(status == google.maps.GeocoderStatus.OK)
                {               
                 document.getElementById("djc2_map_box").style.display='block';
                    var mapOpts = {
                        zoom: <?php echo $this->params->get('gm_zoom', (($this->lists['search']) ? '10' : '1'));?>,
                        center: results[0].geometry.location,
                        mapTypeId: google.maps.MapTypeId.<?php echo $this->params->get('gm_type','ROADMAP');?>,
                        navigationControl: true,
                        scrollwheel: true,
                        styles:[{
                            featureType:"poi",
                            elementType:"labels",
                            stylers:[{
                                visibility:"off"
                            }]
                        }]
                    };
                    djc2_map = new google.maps.Map(document.getElementById("djc2_map"), mapOpts);                                       
                     var size = new google.maps.Size(32,32);
                     var start_point = new google.maps.Point(0,0);
                     var anchor_point = new google.maps.Point(0,16);                             
                    <?php 
                    foreach($this->items as $item){ ?>                      
                            var icon = '';
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
                                
                                $marker_txt = str_replace(PHP_EOL, '', $marker_txt);
                                
                                if($item->latitude != 0.0 && $item->longitude != 0.0){ ?>
                                        var adLatlng = new google.maps.LatLng(<?php echo $item->latitude.','.$item->longitude; ?>);
                                        djc2_map_markers.push(DJCatalog2GMClusterMarker(adLatlng, "<?php echo $marker_txt; ?>", icon));
                                <?php } ?>                          
                        <?php } ?>
                        var mcOptions = {gridSize: 50, maxZoom: 14,styles: [{
                            height: 53, url: "<?php echo JURI::base()?>components/com_djcatalog2/assets/mapclustering/images/m1.png",width: 53},
                            {height: 56, url: "<?php echo JURI::base()?>components/com_djcatalog2/assets/mapclustering/images/m2.png",width: 56},
                            {height: 66, url: "<?php echo JURI::base()?>components/com_djcatalog2/assets/mapclustering/images/m3.png",width: 66},
                            {height: 78, url: "<?php echo JURI::base()?>components/com_djcatalog2/assets/mapclustering/images/m4.png",width: 78},
                            {height: 90, url: "<?php echo JURI::base()?>components/com_djcatalog2/assets/mapclustering/images/m5.png",width: 90}]};
                        var markerCluster = new MarkerClusterer(djc2_map, djc2_map_markers, mcOptions);                                                                                                                                                                     
                    }
                });                     
            }  
</script>
