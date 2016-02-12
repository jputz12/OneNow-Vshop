<?php
/**
 * @package    Joomla.Administrator
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Define the application's minimum supported PHP version as a constant so it can be referenced within the application.
 */
define('JOOMLA_MINIMUM_PHP', '5.3.10');

if (version_compare(PHP_VERSION, JOOMLA_MINIMUM_PHP, '<'))
{
	die('Your host needs to use PHP ' . JOOMLA_MINIMUM_PHP . ' or higher to run this version of Joomla!');
}

/**
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */
define('_JEXEC', 1);

if (file_exists(__DIR__ . '/defines.php'))
{
	include_once __DIR__ . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', __DIR__);
	require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_BASE . '/includes/framework.php';
require_once JPATH_BASE . '/includes/helper.php';

function insert_item(&$product, $cat_id, $producer_id,$published, $approval_status, $cat_id, $subcat_id, $subsubcat_id)
{
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
    //insert product
                $alias = substr(str_replace(' ','-',str_replace("'", '', $product->name)), 0, 30);
                $db->setQuery("INSERT INTO #__djc2_items(cat_id, producer_id, name, description, intro_desc, price, available, published, access, created, created_by, approval_status, alias) VALUES('".$cat_id."', '".$producer_id."', '".addslashes($product->name)."', '".addslashes($product->longdesc)."', '".addslashes($product->shortdesc)."', '".$product->price."', '1', '".$published."', '1', NOW(), '224', '".$approval_status."', '".$alias."')");
                $db->execute();
                $item_id = $db->insertid();
                
                //update j2store
                $db->setQuery("INSERT INTO #__j2store_products(visibility, product_source, product_source_id, product_type, enabled, created_on, created_by, modified_on, modified_by) VALUES('1','com_djcatalog2', '".$item_id."', 'simple', '1', NOW(), '224', NOW(), '224')");
                $db->execute();
                
                //update j2store variants
                $db->setQuery("INSERT INTO #__j2store_variants(product_id, is_master, sku, price, created_on, created_by, modified_on, modified_by) VALUES('".$item_id."', '1', '".$product->sku."', '".$product->price."', NOW(), '224', NOW(), '224')");
                $db->execute();
                
                //update attributes
                if($product->color!='')
                {
                    $db->setQuery("INSERT INTO #__djc2_items_extra_fields_values_text(item_id, field_id, value) VALUES('".$item_id."', '2', '".$product->color."')");
                    $db->execute();
                }
                
                if($product->size!='')
                {
                    $db->setQuery("INSERT INTO #__djc2_items_extra_fields_values_text(item_id, field_id, value) VALUES('".$item_id."', '7', '".$product->size."')");
                    $db->execute();
                }
                
                if($product->notes!='')
                {
                    $db->setQuery("INSERT INTO #__djc2_items_extra_fields_values_text(item_id, field_id, value) VALUES('".$item_id."', '8', '".htmlspecialchars($product->notes)."')");
                    $db->execute();
                }
                
                if($product->tags!='')
                {
                    $db->setQuery("INSERT INTO #__djc2_items_extra_fields_values_text(item_id, field_id, value) VALUES('".$item_id."', '9', '".$product->tags."')");
                    $db->execute();
                }
                
                if($product->resourceurl!='')
                {
                    $db->setQuery("INSERT INTO #__djc2_items_extra_fields_values_text(item_id, field_id, value) VALUES('".$item_id."', '10', '".$product->resourceurl."')");
                    $db->execute();
                }
                
                if($product->merchant!='')
                {
                    $db->setQuery("INSERT INTO #__djc2_items_extra_fields_values_text(item_id, field_id, value) VALUES('".$item_id."', '11', '".$product->merchant."')");
                    $db->execute();
                }
                
                if($product->category_weight!='')
                {
                    $db->setQuery("INSERT INTO #__djc2_items_extra_fields_values_text(item_id, field_id, value) VALUES('".$item_id."', '12', '".$product->category_weight."')");
                    $db->execute();
                }
                
                $fullname = "";
                $fullname  = $product->imagename;
                $fullnamearr = explode('.', $fullname);
                $name = $fullnamearr[0];
                $ext = $fullnamearr[1];
                
                 for($i=0;$i<count($product->photos);$i++)
                {
                if(!empty($product->photos[$i]))
                {
                    $photo = $product->photos[$i];
                    
                    $db->setQuery("INSERT INTO #__djc2_images(item_id, type, fullname, name, ext, path, fullpath) VALUES('".$item_id."', 'item','".$fullname."','".$name."','".$ext."','item/0','item/0/".$photo->photo."')");
                    $db->execute();
                }
                }
                //insert addtl categories
                if($subsubcat_id > 0)
                {
                    
                    $db->setQuery("INSERT INTO #__djc2_items_categories(item_id, category_id) VALUES('".$item_id."', '".$subsubcat_id."')");
                    $db->execute();
                    
                }
                
                if($subcat_id > 0)
                {
                    
                    $db->setQuery("INSERT INTO #__djc2_items_categories(item_id, category_id) VALUES('".$item_id."', '".$subcat_id."')");
                    $db->execute();
                    
                }
                
                if($cat_id > 0)
                {
                    
                    $db->setQuery("INSERT INTO #__djc2_items_categories(item_id, category_id) VALUES('".$item_id."', '".$cat_id."')");
                    $db->execute();
                    
                }
}

function update_item_for_deletion($item_id)
{
               $db->setQuery("UPDATE #__djc2_items SET approval_status = 'for deletion' WHERE id = '".$item_id."'");
               $db->execute(); 
}

/*$jsonarr = '{
  "producername": "MANGO",
  "producerurl": "http://mango.com",
  "shippingandreturn": "shipping and return notes",
  "sizeguide": "path for image that describes the style guide",
  "products": [
    {
      "name": "Suede Pumps",
      "sku": "prod98200",
      "currency": "USD",
      "category": "Shoes",
      "subcategory": "Pumps",
      "color": "magenta, gold, purple",
      "size": "7,7.5,8,9",
      "notes": "Sizes are half size smaller than normal. Please make sure to select you exact size.",
      "shortdesc": "Lorem ipsum",
      "longdesc": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit eget dolor et lobortis. Cras scelerisque nisl rhoncus elit faucibus egestas mollis sed ante. Nulla eu dolor luctus, facilisis urna quis, iaculis nunc. Vestibulum sagittis turpis at neque viverra, eget aliquet ligula pretium. Aliquam suscipit interdum libero, sed aliquam diam laoreet nec. Morbi eros purus, ultricies nec accumsan vel, vehicula vitae ex. Quisque massa ante, mollis sed libero sit amet, sollicitudin fermentum nunc.",
      "merchant": "Jessica Simpsons",
      "resourceurl": "http://jessica.com/shoes/pumps/19283",
      "photos": [
        {
          "photo": "item/0/pumps.jpg",
          "fullname": "pumps.jpg",
          "name": "pumps",
          "ext": "jpg"
          
        },
        {
          "photo": "item/0/pumps2.jpg",
          "fullname": "pumps2.jpg",
          "name": "pumps2",
          "ext": "jpg"
        }
      ],
      "price": "100",
      "tags": "shoes, pumps, office, winter"
    }
  ]
}';*/

/*$jsonarr = '{"producername":"SKINSTORE","shippingandreturn":"shipping and return notes","sizeguide":"path for image that describes the style guide","products":[{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_AJ044","shortdesc":"","longdesc":"Essential brow brush duo is the perfect size for travel and touch-ups.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/AJ044-anastasia-mini-duo-brush-7/AJ044-anastasia-mini-duo-brush-7.jpg\"},{\"photo\":\"uixxxaq0914/beauty/AJ044-anastasia-mini-duo-brush-7/AJ044-anastasia-mini-duo-brush-7_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/AJ044-anastasia-mini-duo-brush-7/AJ044-anastasia-mini-duo-brush-7_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/AJ044-anastasia-mini-duo-brush-7/AJ044-anastasia-mini-duo-brush-7_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/AJ044-anastasia-mini-duo-brush-7/AJ044-anastasia-mini-duo-brush-7_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/AJ044-anastasia-mini-duo-brush-7/AJ044-anastasia-mini-duo-brush-7_l.jpg\"}]","category":"Accessories","price":"18.0","resourceurl":"http://www.skinstore.comhttp://www.skinstore.com/cosmetics-tools-brushes-products.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"Anastasia Mini Duo Brush #7","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/AJ044-anastasia-mini-duo-brush-7.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_TF289","shortdesc":"","longdesc":"Cruelty-free, portabl, e retractable Kabuki Brush is the ideal tool to apply bronzers, blushes and powders flawlessly","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/TF289-too-faced-retractable-kabuki-brush/TF289-too-faced-retractable-kabuki-brush.jpg\"},{\"photo\":\"uixxxaq0914/beauty/TF289-too-faced-retractable-kabuki-brush/TF289-too-faced-retractable-kabuki-brush_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/TF289-too-faced-retractable-kabuki-brush/TF289-too-faced-retractable-kabuki-brush_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/TF289-too-faced-retractable-kabuki-brush/TF289-too-faced-retractable-kabuki-brush_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/TF289-too-faced-retractable-kabuki-brush/TF289-too-faced-retractable-kabuki-brush_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/TF289-too-faced-retractable-kabuki-brush/TF289-too-faced-retractable-kabuki-brush_l.jpg\"}]","category":"Accessories","price":"34.0","resourceurl":"http://www.skinstore.com/p-10736-anastasia-mini-duo-brush-7.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"Too Faced Retractable Kabuki Brush","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/TF289-too-faced-retractable-kabuki-brush.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_TF288","shortdesc":"","longdesc":"These cruelty-free Teddy Bear Hair Brushes are made with a luxurious synthetic \"hair\" that is as soft and silky.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set.jpg\"},{\"photo\":\"uixxxaq0914/beauty/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set_l.jpg\"}]","category":"Accessories","price":"65.0","resourceurl":"http://www.skinstore.com/p-22078-too-faced-retractable-kabuki-brush.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"Too Faced Pro-Essential Teddy Bear Hair Brush Set","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/TF288-too-faced-pro-essential-teddy-bear-hair-brush-set.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_II080","shortdesc":"","longdesc":"A natural short hair kabuki-style brush specifically designed to fit the natural contours of the face.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/II080-true-isaac-mizrahi-powder-brush/II080-true-isaac-mizrahi-powder-brush.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II080-true-isaac-mizrahi-powder-brush/II080-true-isaac-mizrahi-powder-brush_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II080-true-isaac-mizrahi-powder-brush/II080-true-isaac-mizrahi-powder-brush_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II080-true-isaac-mizrahi-powder-brush/II080-true-isaac-mizrahi-powder-brush_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II080-true-isaac-mizrahi-powder-brush/II080-true-isaac-mizrahi-powder-brush_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II080-true-isaac-mizrahi-powder-brush/II080-true-isaac-mizrahi-powder-brush_l.jpg\"}]","category":"Accessories","price":"48.0","resourceurl":"http://www.skinstore.com/p-22077-too-faced-pro-essential-teddy-bear-hair-brush-set.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"True Isaac Mizrahi Powder Brush","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/II080-true-isaac-mizrahi-powder-brush.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_MP025","shortdesc":"","longdesc":"This chisel brush is designed exclusively for the application of Pür Minerals 4-in-1 Pressed Mineral Makeup Foundation.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/MP025-pur-minerals-chisel-brush/MP025-pur-minerals-chisel-brush.jpg\"},{\"photo\":\"uixxxaq0914/beauty/MP025-pur-minerals-chisel-brush/MP025-pur-minerals-chisel-brush_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/MP025-pur-minerals-chisel-brush/MP025-pur-minerals-chisel-brush_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/MP025-pur-minerals-chisel-brush/MP025-pur-minerals-chisel-brush_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/MP025-pur-minerals-chisel-brush/MP025-pur-minerals-chisel-brush_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/MP025-pur-minerals-chisel-brush/MP025-pur-minerals-chisel-brush_l.jpg\"}]","category":"Accessories","price":"23.0","resourceurl":"http://www.skinstore.com/p-24230-true-isaac-mizrahi-powder-brush.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"Pur Minerals Chisel Brush","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/MP025-pur-minerals-chisel-brush.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_MP026","shortdesc":"","longdesc":"The Powder Makeup Brush is an excellent brush for both face and body when applying Mineral Glow, Mineral Light, Mineral Split Pans, Pür Radiance and Universal Marble Powder.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/MP026-pur-minerals-powder-brush/MP026-pur-minerals-powder-brush.jpg\"},{\"photo\":\"uixxxaq0914/beauty/MP026-pur-minerals-powder-brush/MP026-pur-minerals-powder-brush_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/MP026-pur-minerals-powder-brush/MP026-pur-minerals-powder-brush_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/MP026-pur-minerals-powder-brush/MP026-pur-minerals-powder-brush_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/MP026-pur-minerals-powder-brush/MP026-pur-minerals-powder-brush_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/MP026-pur-minerals-powder-brush/MP026-pur-minerals-powder-brush_l.jpg\"}]","category":"Accessories","price":"21.0","resourceurl":"http://www.skinstore.com/p-18268-pur-minerals-chisel-brush.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"Pur Minerals Powder Brush","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/MP026-pur-minerals-powder-brush.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_II079","shortdesc":"","longdesc":"A natural hand-crafted soft hair artisan brush designed with an ergonomic handle for a controlled and even application.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/II079-true-isaac-mizrahi-powder-foundation-brush/II079-true-isaac-mizrahi-powder-foundation-brush.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II079-true-isaac-mizrahi-powder-foundation-brush/II079-true-isaac-mizrahi-powder-foundation-brush_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II079-true-isaac-mizrahi-powder-foundation-brush/II079-true-isaac-mizrahi-powder-foundation-brush_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II079-true-isaac-mizrahi-powder-foundation-brush/II079-true-isaac-mizrahi-powder-foundation-brush_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II079-true-isaac-mizrahi-powder-foundation-brush/II079-true-isaac-mizrahi-powder-foundation-brush_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II079-true-isaac-mizrahi-powder-foundation-brush/II079-true-isaac-mizrahi-powder-foundation-brush_l.jpg\"}]","category":"Accessories","price":"38.0","resourceurl":"http://www.skinstore.com/p-18269-pur-minerals-powder-brush.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"True Isaac Mizrahi Powder Foundation Brush","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/II079-true-isaac-mizrahi-powder-foundation-brush.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_AJ047","shortdesc":"","longdesc":"Travel-sized brush designed for precise brow shaping.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/AJ047-anastasia-small-angled-cut-brush-15/AJ047-anastasia-small-angled-cut-brush-15.jpg\"},{\"photo\":\"uixxxaq0914/beauty/AJ047-anastasia-small-angled-cut-brush-15/AJ047-anastasia-small-angled-cut-brush-15_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/AJ047-anastasia-small-angled-cut-brush-15/AJ047-anastasia-small-angled-cut-brush-15_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/AJ047-anastasia-small-angled-cut-brush-15/AJ047-anastasia-small-angled-cut-brush-15_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/AJ047-anastasia-small-angled-cut-brush-15/AJ047-anastasia-small-angled-cut-brush-15_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/AJ047-anastasia-small-angled-cut-brush-15/AJ047-anastasia-small-angled-cut-brush-15_l.jpg\"}]","category":"Accessories","price":"17.0","resourceurl":"http://www.skinstore.com/p-24229-true-isaac-mizrahi-powder-foundation-brush.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"Anastasia Small Angled Cut Brush #15","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/AJ047-anastasia-small-angled-cut-brush-15.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_II077","shortdesc":"","longdesc":"Designed to apply protective illuminating concealer simply and quickly.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/II077-true-isaac-mizrahi-concealer-brush/II077-true-isaac-mizrahi-concealer-brush.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II077-true-isaac-mizrahi-concealer-brush/II077-true-isaac-mizrahi-concealer-brush_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II077-true-isaac-mizrahi-concealer-brush/II077-true-isaac-mizrahi-concealer-brush_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II077-true-isaac-mizrahi-concealer-brush/II077-true-isaac-mizrahi-concealer-brush_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II077-true-isaac-mizrahi-concealer-brush/II077-true-isaac-mizrahi-concealer-brush_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II077-true-isaac-mizrahi-concealer-brush/II077-true-isaac-mizrahi-concealer-brush_l.jpg\"}]","category":"Accessories","price":"19.0","resourceurl":"http://www.skinstore.com/p-10751-anastasia-small-angled-cut-brush-15.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"True Isaac Mizrahi Concealer Brush","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/II077-true-isaac-mizrahi-concealer-brush.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_II076","shortdesc":"","longdesc":"Designed as a precision tool for an even application of lip color.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/II076-true-isaac-mizrahi-lip-brush/II076-true-isaac-mizrahi-lip-brush.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II076-true-isaac-mizrahi-lip-brush/II076-true-isaac-mizrahi-lip-brush_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II076-true-isaac-mizrahi-lip-brush/II076-true-isaac-mizrahi-lip-brush_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II076-true-isaac-mizrahi-lip-brush/II076-true-isaac-mizrahi-lip-brush_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II076-true-isaac-mizrahi-lip-brush/II076-true-isaac-mizrahi-lip-brush_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II076-true-isaac-mizrahi-lip-brush/II076-true-isaac-mizrahi-lip-brush_l.jpg\"}]","category":"Accessories","price":"21.0","resourceurl":"http://www.skinstore.com/p-24227-true-isaac-mizrahi-concealer-brush.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"True Isaac Mizrahi Lip Brush","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/II076-true-isaac-mizrahi-lip-brush.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_II082","shortdesc":"","longdesc":"Designed for even laydown of pigment, this natural hair brush is designed for the ultimate in application.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/II082-true-isaac-mizrahi-powder-blush-brush/II082-true-isaac-mizrahi-powder-blush-brush.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II082-true-isaac-mizrahi-powder-blush-brush/II082-true-isaac-mizrahi-powder-blush-brush_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II082-true-isaac-mizrahi-powder-blush-brush/II082-true-isaac-mizrahi-powder-blush-brush_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II082-true-isaac-mizrahi-powder-blush-brush/II082-true-isaac-mizrahi-powder-blush-brush_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II082-true-isaac-mizrahi-powder-blush-brush/II082-true-isaac-mizrahi-powder-blush-brush_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II082-true-isaac-mizrahi-powder-blush-brush/II082-true-isaac-mizrahi-powder-blush-brush_l.jpg\"}]","category":"Accessories","price":"32.0","resourceurl":"http://www.skinstore.com/p-24226-true-isaac-mizrahi-lip-brush.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"True Isaac Mizrahi Powder Blush Brush","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/II082-true-isaac-mizrahi-powder-blush-brush.jpg","notes":""},{"tags":"Accessories , Hair Tools & Appliances ,   Brushes & Combs","subsubcategory":"Brushes & Combs","merchant":"http://www.skinstore.com","sku":"SKINSTORE_II078","shortdesc":"","longdesc":"Designed for easy application of liquid and cream foundations.","size":"","currency":"USD","photos":"[{\"photo\":\"uixxxaq0914/beauty/II078-true-isaac-mizrahi-liquid-foundation-brush/II078-true-isaac-mizrahi-liquid-foundation-brush.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II078-true-isaac-mizrahi-liquid-foundation-brush/II078-true-isaac-mizrahi-liquid-foundation-brush_t.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II078-true-isaac-mizrahi-liquid-foundation-brush/II078-true-isaac-mizrahi-liquid-foundation-brush_s.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II078-true-isaac-mizrahi-liquid-foundation-brush/II078-true-isaac-mizrahi-liquid-foundation-brush_f.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II078-true-isaac-mizrahi-liquid-foundation-brush/II078-true-isaac-mizrahi-liquid-foundation-brush_m.jpg\"},{\"photo\":\"uixxxaq0914/beauty/II078-true-isaac-mizrahi-liquid-foundation-brush/II078-true-isaac-mizrahi-liquid-foundation-brush_l.jpg\"}]","category":"Accessories","price":"29.0","resourceurl":"http://www.skinstore.com/p-24232-true-isaac-mizrahi-powder-blush-brush.aspx","color":"","subcategory":"Hair Tools & Appliances","name":"True Isaac Mizrahi Liquid Foundation Brush","imageurl":"http://skincare-img.skinstore.com/resources/dynamic/store/indeximages/II078-true-isaac-mizrahi-liquid-foundation-brush.jpg","notes":""}],"producerurl":"http://www.skinstore.com"}';

*/

$jsonarr = $_POST['jsonarr'];

if(!empty($jsonarr))
{
$jsonresult = json_decode($jsonarr);

//connect to db
$db = JFactory::getDbo();
$query = $db->getQuery(true);

//check if merchant exists
$db->setQuery("SELECT * FROM #__djc2_producers WHERE UPPER(name) = '".strtoupper($jsonresult->producername)."'");
$row_producer = $db->loadAssoc();

//if merchant exists, process list
if($row_producer['id'] > 0)
{
    //traverse to each product
    for($i=0;$i<count($jsonresult->products);$i++)
    {
        $product = $jsonresult->products[$i];
        
        
        $db->setQuery('SELECT * FROM #__djc2_categories WHERE UPPER(name) = "'.trim(strtoupper($product->category)).'" AND parent_id = 0');
        $row_cat = $db->loadAssoc();
       
        if($row_cat['name']!='')
        {
            $cat_id = $row_cat['id'];
            $catid = $cat_id;
            
            $db->setQuery('SELECT * FROM #__djc2_categories WHERE UPPER(name) = "'.trim(strtoupper($product->subcategory)).'" AND parent_id = "'.$row_cat['id'].'"');
            $row_subcat = $db->loadAssoc();
           
            if($row_subcat['name']!='')
            {
                $subcat_id = $row_subcat['id'];
                $catid = $subcat_id;
                $db->setQuery('SELECT * FROM #__djc2_categories WHERE UPPER(name) = "'.trim(strtoupper($product->subsubcategory)).'" AND parent_id = "'.$row_subcat['id'].'"');
                $row_subsubcat = $db->loadAssoc();

                if($row_subsubcat['name']!='')
                {
                    $subsubcat_id = $row_subsubcat['id'];
                    $catid = $subsubcat_id;
                    //check if product exists on the existing db
                    $db->setQuery('SELECT * FROM #__djc2_items WHERE UPPER(name) = "'.trim(strtoupper(addslashes($product->name))).'"');
                    $row_item = $db->loadAssoc(); 
                    
                    //product exists
                    if($row_item['name']!="")
                    {
                        if($row_item['published'] == '1')
                        {
                        //if same producer
                        if($row_item['producer_id'] == $row_producer['id'])
                        {
                            //insert new product
                            insert_item($product, $catid, $row_producer['id'], '0', 'for approval', $cat_id, $subcat_id, $subsubcat_id);
                            
                            //update old product for trash
                            update_item_for_deletion($row_item['id']);
                        }
                        //if different producer
                        else
                        {
                            //check price
                            if($row_item['price']>=$product->price)
                            {
                                //insert new product
                                insert_item($product, $catid, $row_producer['id'], '0', 'for approval', $cat_id, $subcat_id, $subsubcat_id);
                                
                                //update old product for trash
                                update_item_for_deletion($row_item['id']);
                            }
                            else
                            {
                                //no change
                            }
                        }
                        }
                    }
                    //product does not exist
                    else
                    {
                        
                        insert_item($product, $catid, $row_producer['id'], '0', 'for approval', $cat_id, $subcat_id, $subsubcat_id);
                        
                        echo "insert success -".$product->name."<br/>";
                    }
                }
                else
                {
                   //ignore product, does not belong to any cateogry
                    echo $product->category. "-". $product->subcategory. "-".$product->subsubcategory ." - category does not exist<br/>"; 
                }
            }
            else
            {
               //ignore product, does not belong to any cateogry
                echo $product->category. "-". $product->subcategory. " - category does not exist<br/>"; 
            }
            
        }
        else
        {
            //ignore product, does not belong to any cateogry
            echo $product->category." - category does not exist<br/>";
        }
    }
    
}
}
else
{
    echo "json is empty";
}
?>
