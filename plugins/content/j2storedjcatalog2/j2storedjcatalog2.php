<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
class plgContentJ2storedjcatalog2 extends JPlugin
{
	public $_element ='j2storedjcatalog2';

	public function __construct(& $subject, $config)
	{	parent::__construct($subject, $config);
		$this->loadLanguage('com_j2store', JPATH_ADMINISTRATOR);
		$this->loadLanguage();
	}

	/**
	 * Method to return j2store cart html
	 * @param object $item
	 * @return string
	 */
	public function onDJCatalog2BeforeCart($itemObject, $params, $context){
		if ( !defined( 'F0F_INCLUDED' ) ) {
			include_once JPATH_LIBRARIES . '/f0f/include.php';
		}
		$app = JFactory::getApplication();
		$option = $app->input->getString('option');
		if ( $app->isSite() && $option == 'com_djcatalog2' ) {
			$html = '';
			$params = $this->params;
			$j2params = J2Store::config();
			$cache = JFactory::getCache();
			$cache->clean( 'com_j2store' );
			if (isset($itemObject->id) && !empty($itemObject->id) ) {
				$product = F0FTable::getAnInstance( 'Product', 'J2StoreTable' );
				$product->reset();
				if($product->get_product_by_source( 'com_djcatalog2',$itemObject->id )){

					$image_html = '';

					if($option =='com_djcatalog2' && $context == 'items.items') {

						$mainimage_width = $this->params->get('list_image_thumbnail_width',120);
						$additional_image_width = $this->params->get('list_product_additional_image_width',80);

						if($this->params->get('category_product_options',1) == 1){
							$html = $product->get_product_html();
						}else{
							$html = $product->get_product_html('without_options');
						}
						$show_image = $this->params->get('category_display_j2store_images', 1);
						$image_type = $this->params->get('category_image_type', 'thumbnail');
						//to set enable zoom option in category view
						if($this->params->get('category_enable_image_zoom',1)){
							$this->params->set('item_enable_image_zoom',1);
							$images = $product->get_product_images_html($image_type,$this->params);
						}else{
							$this->params->set('item_enable_image_zoom',0);
							$images = $product->get_product_images_html($image_type,$this->params);
						}
					}else{
						$html = $product->get_product_html();
						//set the image width
						$mainimage_width = $this->params->get('item_product_main_image_width',120);
						$additional_image_width = $this->params->get('item_product_additional_image_width',100);
						$show_image = $this->params->get('item_display_j2store_images', 1);
						$image_type = $this->params->get('item_image_type', 'thumbnail');
						$images = $product->get_product_images_html($image_type,$this->params);
					}

					//custom css to adjust the j2store product images width
					$content =".j2store-product-images .j2store-mainimage img ,.j2store-product-images .j2store-thumbnail-image img ,.upsell-product-image img , .cross-sell-product-image img {width:{$mainimage_width}px} .j2store-img-responsive  { width :{$additional_image_width}px;}";
					JFactory::getDocument()->addStyleDeclaration($content);
					if($show_image  && $images !== false) {
						$image_html = $images;
					}
					if($html === false) {
						$html = '';
					}
					$html = $image_html.$html;
				}
			}
		}
		return $html;
	}

	function onContentPrepareForm($form, $data)
	{
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		if($app->isSite()) {
			return true;
		}
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}
		// Check we are manipulating a valid form.
		$name = $form->getName();
		if (!in_array($name, array('com_djcatalog2.item'))) {
			return true;
		}

		$id  = $app->input->getInt('id');
		$j2html = $this->getJ2storeCartHtml($id);
		$j2html = json_encode($j2html);
		 $script = "
		if(typeof(j2store) == 'undefined') {
				var j2store = {};
				}
				if(typeof(j2store.jQuery) == 'undefined') {
					j2store.jQuery = jQuery.noConflict();
				}

				//to fix jquery-ui css conflict
				jQuery.curCSS = jQuery.css;

				(function($) {
				$(document).ready(function() {

				var form = $('form');
				var j2storestring =$j2html;
				form.find('fieldset > ul').append('<li><a data-toggle=\'tab\' href=\'#j2store\'>J2Store</a></li>');
				form.find('.tab-content').append('<div class=\'tab-pane\' id=\'j2store\'></div>');
			 	var elements = $(j2storestring).map(function() {
			 		return $('#j2store').append(this).html();
		 	 	});
				form.find('#j2store .container').removeClass('container');
				form.find('#j2store .container').addClass('j2store-container');
			});
			})(j2store.jQuery);
		";
		$doc->addScriptDeclaration($script);
		return true;
	}

	public function getJ2storeCartHtml($source_id=null){
		$app = JFactory::getApplication();
		$html = '';
		$productTable = F0FTable::getAnInstance('Product' ,'J2StoreTable');
		$productTable->load(array('product_source'=>'com_djcatalog2','product_source_id' => $app->input->getInt('id')));
		$product_id = (isset($productTable->j2store_product_id)) ? $productTable->j2store_product_id : '';
		$inputvars = array(
				'task' 					=>'edit',
				'render_toolbar'        => '0',
				'product_source_id'		=>	$productTable->product_source_id,
				'j2store_product_id'	=>	$product_id,
				'id'					=>	$product_id,
				'product_source'		=>'com_djcatalog2',
				'product_source_view'	=>'item',
				'form_prefix'=>'jform[params][j2store]'
		);
		$input = new F0FInput($inputvars);
		@ob_start();
		F0FDispatcher::getTmpInstance('com_j2store', 'product', array('layout'=>'form', 'tmpl'=>'component', 'input' => $input))->dispatch();
		$html = ob_get_contents();

		ob_end_clean();
		return $html;
	}



	/**
	 * Example after save content method
	 * Article is passed by reference, but after the save, so no changes will be saved.
	 * Method is called right after the content is saved
	 *
	 * @param	string		The context of the content passed to the plugin (added in 1.6)
	 * @param	object		A JTableContent object
	 * @param	bool		If the content is just about to be created
	 *
	 */

	function onContentAfterSave($context, $data, $isNew)
	{
		$app = JFactory::getApplication();
		// Check we are manipulating a valid form.
		if (!in_array($context, array('com_djcatalog2.item'))) {
			return true;
		}
		$input = JFactory::getApplication()->input;
		$j2storedata = $input->get('jform',array(),'ARRAY');

		$id  = $data->id;

		if ( isset( $j2storedata['params'][ 'j2store' ] ) && is_array( $j2storedata['params'][ 'j2store' ] ) && !empty( $j2storedata['params'][ 'j2store' ] ) && $input->get('view') =='item' ) {
			$product_data = $j2storedata['params'][ 'j2store' ] ;
			 if ( !defined( 'F0F_INCLUDED' ) ) {
			 	include_once JPATH_LIBRARIES . '/f0f/include.php';
			 }
		 	$product_data = $j2storedata['params']['j2store'];
			if(!empty($id)  &&  $product_data['enabled'] ==1){
				$product_data['product_source'] ='com_djcatalog2';
				$product_data['product_source_id'] =  $id;

				if ( isset( $product_data[ 'item_options' ] ) && is_array( $product_data[ 'item_options' ] ) && !empty( $product_data[ 'item_options' ] ) ) {
					foreach ( $product_data[ 'item_options' ] as &$item_option ) {
						if ( is_array( $item_option ) ) {
							$item_option = (object)$item_option;
						}
					}
				}
				F0FModel::getTmpInstance( 'Products', 'J2StoreModel' )->save( $product_data );
			}
		 }

		return true;
	}


	/**
	 * Remove all item price information for the given article ID from j2store-price table
	 *
	 * Method is called before article data is deleted from the database
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	object	The data relating to the content that was deleted.
	 */
	public function onContentAfterDelete( $context, $table) {
		$app = JFactory::getApplication();

		if($context != 'com_djcatalog2.item'){
			return false;

		}
		//var_dump($data);
		$articleId = $app->input->get('cid',array(),'Array');
		$articleId = isset($articleId[0]) ? $articleId[0] : 0;

		if (!defined('F0F_INCLUDED'))
		{
			include_once JPATH_LIBRARIES . '/f0f/include.php';
		}

		if($articleId) {
			$productModel = F0FModel::getTmpInstance('Products', 'J2StoreModel');
			$itemlist = $productModel->product_source('com_djcatalog2')
			->product_source_id($articleId)
			->getItemList();
			try {
				foreach($itemlist as $item) {
					if($item->product_source == 'com_djcatalog2' && $item->product_source_id == $articleId){
						$productModel->setId($item->j2store_product_id)->delete();
					}
				}
			}catch (Exception $e) {
				throw new Exception($e->getMessage());
			}

		}
		return true;
	}

	/**
	 * Method to get Product
	 * @param unknown_type $product
	 */
	 function onJ2StoreAfterGetProduct(&$product) {

		if(isset($product->product_source) && $product->product_source == 'com_djcatalog2' ) {
			static $sets;
			if(!is_array($sets)) {
				$sets = array();
			}
			require_once(JPATH_SITE.'/components/com_djcatalog2/helpers/route.php');
		 	$item = $this->getItem($product->product_source_id);

			if($item){
				//assign
				$product->source = $item;
				$product->product_name = $item->name;
				$product->product_edit_url = 'index.php?option=com_djcatalog2&task=item.edit&id='.$item->id;
				$product->product_view_url = JRoute::_(DJCatalogHelperRoute::getItemRoute($item->id,$item->cat_id ,$item->name ));
				if($item->state == 1 ) {
					$product->exists = 1;
				} else {
					$product->exists = 0;
				}
				$sets[$product->product_source][$product->product_source_id] = $item;
			} else {
				$product->exists = 0;
			}
		}
	}


	public function getItem($pk = null)
	{
		static $sets;
		if(!is_array($sets)) {
			$sets = array();
		}
		$db = JFactory::getDbo();
		$query = $db -> getQuery(true);
		$query -> select('i.*, CASE WHEN (i.special_price > 0.0 AND i.special_price < i.price) THEN i.special_price ELSE i.price END as final_price');
		$query -> from('#__djc2_items as i');

		$query -> select('c.id as _category_id, c.name as category, c.published as publish_category, c.alias as category_alias');
		$query -> join('left', '#__djc2_categories AS c ON c.id = i.cat_id');

		$query -> select('p.id as _producer_id, p.name as producer, p.published as publish_producer, p.alias as producer_alias');
		$query -> join('left', '#__djc2_producers AS p ON p.id = i.producer_id');

		$query -> select('ua.name AS author, ua.email AS author_email');
		$query -> join('left', '#__users AS ua ON ua.id = i.created_by');

		$query -> select('countries.country_name ');
		$query -> join('left', '#__djc2_countries AS countries ON countries.id = i.country');

		$nullDate = $db->quote($db->getNullDate());
		$date = JFactory::getDate();
		$nowDate = $db->quote($date->toSql());

		$query->where('i.id ='.(int)$pk);
		$query->where('(i.publish_up = ' . $nullDate . ' OR i.publish_up <= ' . $nowDate . ')');
		$query->where('(i.publish_down = ' . $nullDate . ' OR i.publish_down >= ' . $nowDate . ')');
		$query -> group('i.id');
		$db -> setQuery($query);
		$item = $db -> loadObject();

		if (!empty($item)) {
			$item->slug = (empty($item->alias)) ? $item->id : $item->id.':'.$item->alias;
			$item->catslug = (empty($item->category_alias)) ? $item->cat_id : $item->cat_id.':'.$item->category_alias;
			$item->prodslug = (empty($item->producer_alias)) ? $item->producer_id : $item->producer_id.':'.$item->producer_alias;
		}
		$sets[$pk] = $item;

		return $sets[$pk];
	}
}
