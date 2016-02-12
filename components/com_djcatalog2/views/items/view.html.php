<?php
/**
 * @version $Id: view.html.php 464 2015-07-06 06:24:25Z michal $
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

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class DJCatalog2ViewItems extends JViewLegacy {
	
	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->_addPath('template', JPATH_COMPONENT.  '/themes/default/views/items');
		$theme = DJCatalog2ThemeHelper::getThemeName();
		if ($theme && $theme != 'default') {
			$this->_addPath('template', JPATH_COMPONENT.  '/themes/'.$theme.'/views/items');
		}
	}
	
	function display($tpl = null) {
		JHTML::_( 'behavior.modal' );
		$app = JFactory::getApplication();
		$jinput = $app->input;
		$view = $jinput->get('view');
		$document= JFactory::getDocument();
		$model = $this->getModel();
		$user	= JFactory::getUser();
		$groups	= $user->getAuthorisedViewLevels();
		
		$menus		= $app->getMenu('site');
		$menu  = $menus->getActive();
		
		$mOption = (empty($menu->query['option'])) ? null : $menu->query['option'];
    	$mCatid = (empty($menu->query['cid'])) ? null : (int)$menu->query['cid'];
    	$mProdid   = (empty($menu->query['pid'])) ? null : (int)$menu->query['pid'];
		
    	$filter_catid		= $jinput->getInt('cid', null);
		if ($filter_catid === null && $mOption == 'com_djcatalog2' && $mCatid) {
			$filter_catid = $mCatid;
			$jinput->set('cid', $filter_catid);
		}
		
		$filter_producerid	= $jinput->get( 'pid',null,'string' );
		if ($filter_producerid === null && $mOption == 'com_djcatalog2' && $mProdid) {
			$filter_producerid = $mProdid;
			$jinput->set('pid', (int)$filter_producerid);
		}
		
		$params = Djcatalog2Helper::getParams();
		
		$filter_order		= $jinput->get( 'order',$params->get('items_default_order','i.ordering'),'cmd' );
		$filter_order_Dir	= $jinput->get( 'dir',	$params->get('items_default_order_dir','asc'), 'word' );
		$search				= urldecode($jinput->get( 'search','','string' ));
		$search				= JString::strtolower( $search );

		$limitstart	= $jinput->get('limitstart', 0, 'int');
		$limit_items_show = $params->get('limit_items_show',10);
		//$jinput->set('limit', $limit_items_show);
		
		$lists = array();
		
		if (JString::strlen($search) > 0 && (JString::strlen($search)) < 2 || JString::strlen($search) > 40) {
			 JError::raiseNotice(  E_USER_NOTICE, JText::_( 'COM_DJCATALOG2_SEARCH_RESTRICTION') );
		}
		if ($filter_order_Dir == '' || $filter_order_Dir == 'desc') {
			$lists['order_Dir'] = 'asc';			
		} else {
			$lists['order_Dir'] = 'desc';
		}
		$lists['order'] = $filter_order;
		
		$layout = $jinput->get('layout', 'default', 'string');
		$dispatcher	= JDispatcher::getInstance();
		$categories = Djc2Categories::getInstance(array('state'=>'1', 'access'=>$groups));
		
		// current category
		$category = $categories->get((int) $jinput->getInt('cid',0));
		$subcategories = null;
		if (!empty($category)) {
			$subcategories = $category->getChildren();
			//$subcategories = $model->getSubCategories($category);
		}
		/* If Cateogory not published set 404 */
		if (($category && $category->id > 0 && $category->published == 0) || empty($category)) {
			throw new Exception(JText::_('COM_DJCATALOG2_PRODUCT_NOT_FOUND'), 404);
		}
		
		if (!in_array($category->access, $groups))
		{
			throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
		}
		
		$list = $model->getItems();
		$total = count($list);//$model->getTotal();
		$pagination = $model->getPagination();
		
		// search filter
		$lists['search']= $search;
		
		// category filter
		$category_options = $categories->getOptionList('- '.JText::_('COM_DJCATALOG2_SELECT_CATEGORY').' -');
		if ($filter_catid > 0 && (int)$params->get('category_filter_type', '0') > 0) {
			$category_path = $category->getPath();
			if (count($category_path) > 0) {
				$parent_category = null;
				$parent_id = 0;
				if ($params->get('category_filter_type', '1') == '1' || count($category_path) == 1) {
					//$parent_category = $categories->get((int)end($category_path));
					$parent_id = ($mCatid == 0 && count($category_path) == 1) ? 0 : (int)end($category_path);
				} else if ($params->get('category_filter_type', '1') == '2') {
					$parent_id = ($mCatid == 0) ? $mCatid : ((int)end($category_path) == $category->id) ? $category->id : $category->parent_id;
				} else {
					$parent_id = ((int)$mCatid > 0) ? 0 : (int)$category_path[1];
				}
				
				$parent_category = $categories->get($parent_id);
				
				if ($parent_category) {
					$childrenList = array($parent_category->id);
					$parent_category->makeChildrenList($childrenList);
					foreach ($category_options as $key => $option) {
						if (!in_array($option->value, $childrenList)) {
							unset($category_options[$key]);
						}
						if ($option->value == $parent_category->id) {
							$category_options[$key]->text = ($parent_category->id == $filter_catid || (int)$option->value == 0) ?  '- '.JText::_('COM_DJCATALOG2_SELECT_CATEGORY').' -' : '- '.JText::_('COM_DJCATALOG2_SELECT_CATEGORY_LEVEL_UP').' -';
						}
					}
				}
			}
		}
		
		$lists['categories'] = JHTML::_('select.genericlist', $category_options, 'cid', 'class="inputbox input"', 'value', 'text', $filter_catid);
		
		// producer filter
		$producers_first_option = new stdClass();
		$producers_first_option->id = '0';
		$producers_first_option->text = '- '.JText::_('COM_DJCATALOG2_SELECT_PRODUCER').' -';
		$producers_first_option->disable = false;
		$prodList = $model->getProducers();
		$producers = count($prodList) ? array_merge(array($producers_first_option),$prodList) : array($producers_first_option);
		$lists['producers'] = JHTML::_('select.genericlist', $producers, 'pid', 'class="inputbox input"', 'id', 'text', (int)$filter_producerid);
		
		$lists['index'] = $model->getIndexCount();
		
		
		/* plugins */
		JPluginHelper::importPlugin('djcatalog2');
		JPluginHelper::importPlugin('content');
		if ($category && $category->id > 0) {
			$results = $dispatcher->trigger('onPrepareItemDescription', array (& $category, & $params, $limitstart));
		}
		
		if (count($list)) {
			JPluginHelper::importPlugin('djcatalog2');
		
			foreach ($list as $k=>$v) {
				$list[$k]->event = new stdClass();
		
				$resultsAfterTitle = $dispatcher->trigger('onAfterDJCatalog2DisplayTitle', array (&$list[$k], &$this->params, 0, 'items.'.$params->get('list_layout','items')));
				$list[$k]->event->afterDJCatalog2DisplayTitle = trim(implode("\n", $resultsAfterTitle));
		
				$resultsBeforeContent = $dispatcher->trigger('onBeforeDJCatalog2DisplayContent', array (&$list[$k], &$this->params, 0, 'items.'.$params->get('list_layout','items')));
				$list[$k]->event->beforeDJCatalog2DisplayContent = trim(implode("\n", $resultsBeforeContent));
		
				$resultsAfterContent = $dispatcher->trigger('onAfterDJCatalog2DisplayContent', array (&$list[$k], &$this->params, 0, 'items.'.$params->get('list_layout','items')));
				$list[$k]->event->afterDJCatalog2DisplayContent = trim(implode("\n", $resultsAfterContent));
			}
		}

		$this->assignref('document',$document);
		$this->assignref('item',$category);
		$this->assignref('categories',$categories);
		$this->assignref('subcategories',$subcategories);
		$this->assignref('lists', $lists);
		$this->assignref('items', $list);
		$this->assignref('lists',	$lists);
		$this->assignref('total', $total);
		$this->assignref('pagination',	$pagination);
		$this->assignref('params',	$params);
		$this->assignref('model',	$model);
		$this->attributes = $model->getAttributes();
		$this->column_attributes = $model->getFieldGroups();
		$this->sortables = $model->getSortables();
		$this->_prepareDocument();
		
        parent::display($tpl);
	}
	
	protected function _prepareDocument() {
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$pathway	= $app->getPathway();
		$title		= null;
		$heading		= null;

		$menu = $menus->getActive();
		
		$id = (int) @$menu->query['cid'];
		$pid	= $app->input->get( 'pid',null,'string' );
		$limitstart = $app->input->get('limitstart', 0, 'int');
		
		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		$title = $this->params->get('page_title', '');
		
		$metakeys = null;
		$metadesc = null;

		if ($menu && ($menu->query['option'] != 'com_djcatalog2' || $menu->query['view'] != 'items' || $id != $this->item->id)) {
			
			if (!empty($this->item->metatitle)) {
				$title = $this->item->metatitle;
			}
			else if ($this->item->name && $this->item->id > 0) {
				$title = $this->item->name;
			}
			
			$path = array();
			if ($this->item->id == 0) {
				//$path = array(array('title' => $title, 'link' => ''));
			} else {
				$path = array(array('title' => $this->item->name, 'link' => ''));
			}
			
			$category = $this->categories->get($this->item->parent_id);
			if ($category) {
				while (($menu->query['option'] != 'com_djcatalog2' || $menu->query['view'] == 'item' || $id != $category->id) && $category->id > 0)
				{
					$path[] = array('title' => $category->name, 'link' => DJCatalogHelperRoute::getCategoryRoute($category->catslug));
					$category = $this->categories->get($category->parent_id);
				}
			}

			$path = array_reverse($path);
			
			foreach ($path as $item)
			{
				$pathway->addItem($item['title'], $item['link']);
			}
		} else if (!empty($menu)) {
			if ($this->params->get('menu-meta_description')) {
				$metadesc = $this->params->get('menu-meta_description');
			}
			if ($this->params->get('menu-meta_keywords')) {
				$metakeys = $this->params->get('menu-meta_keywords');
			}
		}
		
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0)) {
			if ($app->getCfg('sitename_pagetitles', 0) == '2') {
				$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
			} else {
				$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
			}
		}
		
		if ($this->pagination->total > 0 && $this->pagination->total > $this->pagination->limit) {
			$pages_total = ceil($this->pagination->total / $this->pagination->limit);
			$page_no = ceil(($this->pagination->limitstart + 1) / $this->pagination->limit);
			
			$previous_page = ($page_no > 1) ? (($page_no - 2) * $this->pagination->limit) : false;
			$next_page = ($page_no < $pages_total) ? ($page_no * $this->pagination->limit) : false;
			
			if ($previous_page !== false) {
				$this->document->addHeadLink(JRoute::_('&limitstart='.(int)$previous_page), 'prev', 'rel');
			}
			if ($next_page !== false) {
				$this->document->addHeadLink(JRoute::_('&limitstart='.(int)$next_page), 'next', 'rel');
			}
			
			if ($this->pagination->limitstart > 0) {
				if ($page_no > 0) {
					$title .= ' ['.$page_no.'/'.$pages_total.']';
				}
			}
			
		}

		$this->document->setTitle($title);
		
		$uri = JFactory::getURI();
		$vars = $uri->getQuery(true);
		unset($vars['order']);
		unset($vars['dir']);
		unset($vars['l']);
		
		$canonical = DJCatalogHelperRoute::getCategoryRoute($this->item->catslug, $pid);
		/*if ($limitstart > 0) {
			$canonical .= '&amp;limitstart='.$limitstart;
		}*/
		if (!empty($vars)){
			$canonical .= '&'.$uri->buildQuery($vars);
		}
		
		foreach($this->document->_links as $key => $headlink) {
			if ($headlink['relation'] == 'canonical' ) {
				unset($this->document->_links[$key]);
			}
		}
		
		$this->document->addHeadLink(JRoute::_($canonical), 'canonical');

		if (!empty($this->item->metadesc))
		{
			$this->document->setDescription($this->item->metadesc);
		}
		elseif (!empty($metadesc)) 
		{
			$this->document->setDescription($metadesc);
		}

		if (!empty($this->item->metakey))
		{
			$this->document->setMetadata('keywords', $this->item->metakey);
		}
		elseif (!empty($metakeys)) 
		{
			$this->document->setMetadata('keywords', $metakeys);
		}
		
		if ($app->input->get('filtering', false)) {
			$this->document->setMetadata('robots', 'noindex, follow');
		} else if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
		
		$this->document->addCustomTag('<meta property="og:title" content="'.trim($title).'" />');
		$this->document->addCustomTag('<meta property="twitter:title" content="'.trim($title).'" />');
		if ($metadesc) {
			$this->document->addCustomTag('<meta property="og:description" content="'.trim($metadesc).'" />');
			$this->document->addCustomTag('<meta property="twitter:description" content="'.trim($metadesc).'" />');
		}
		$this->document->addCustomTag('<meta property="og:url" content="'.JRoute::_(DJCatalogHelperRoute::getCategoryRoute($this->item->catslug), true, -1).'" />');
		if ($item_images = DJCatalog2ImageHelper::getImages('category',$this->item->id)) {
			if (isset($item_images[0])) {
				$this->document->addCustomTag('<meta property="og:image" content="'.$item_images[0]->large.'" />');
				$this->document->addCustomTag('<meta property="twitter:image:src" content="'.$item_images[0]->large.'" />');
				//$this->document->setMetadata('og:image', $item_images[0]->large);
			}
		}
		
		if ($this->params->get('rss_enabled', '1') == '1') {
			$this->feedlink =  JRoute::_(DJCatalogHelperRoute::getCategoryRoute($this->item->catslug, $pid).'&format=feed&type=rss&limitstart=0');
			//$link = '&format=feed&limitstart=';
			$attribs = array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');
			$this->document->addHeadLink(JRoute::_( DJCatalogHelperRoute::getCategoryRoute($this->item->catslug, $pid) . '&format=feed&type=rss'), 'alternate', 'rel', $attribs);
			$attribs = array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');
			$this->document->addHeadLink(JRoute::_( DJCatalogHelperRoute::getCategoryRoute($this->item->catslug, $pid) . '&format=feed&type=atom'), 'alternate', 'rel', $attribs);
		}
		
	}

}




