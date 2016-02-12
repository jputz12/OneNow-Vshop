<?php
/*
	JoomlaXTC Deluxe News Pro

	version 3.51.2

	Copyright (C) 2008-2015 Monev Software LLC.	All Rights Reserved.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

	THIS LICENSE IS NOT EXTENSIVE TO ACCOMPANYING FILES UNLESS NOTED.

	See COPYRIGHT.txt for more information.
	See LICENSE.txt for more information.

	Monev Software LLC
	www.joomlaxtc.com
*/

defined( '_JEXEC' ) or die;


$support_tags = false;

if (file_exists(JPATH_SITE . '/libraries/cms/form/field/tag.php'))
    $support_tags = true;

if (!function_exists('npMakeLink')) {
	function npMakeLink($link,$label,$target) {
		$label = ($label) ? $label : $link;
		switch ($target) {
			case 1: // open in a new window
				$html = '<a href="'.htmlspecialchars($link).'" target="_blank" rel="nofollow">'.htmlspecialchars($label).'</a>';
				break;
			case 2: // open in a popup window
				$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=600';
				$html = "<a href=\"".htmlspecialchars($link)."\" onclick=\"window.open(this.href,'targetWindow','".$attribs."');return false;\">".htmlspecialchars($label).'</a>';
				break;
			case 3: // open in a modal window
				JHtml::_('behavior.modal', 'a.modal');
				$html = '<a class="modal" href="'.htmlspecialchars($link).'" rel="{handler:\'iframe\',size:{x:600,y:600}}">'.htmlspecialchars($label).'</a>';
				break;
			default: // open in parent window
				$html = '<a href="'.htmlspecialchars($link).'" rel="nofollow">'.htmlspecialchars($label).'</a>';
				break;
		}
		return $html;
	}
}

$moduleDir = 'mod_jxtc_newspro';

//Core calls
$live_site = JURI::base();
$doc = JFactory::getDocument();
$db = JFactory::getDBO();
$user = JFactory::getUser();
$contentconfig = JComponentHelper::getParams('com_content');

require_once (JPATH_SITE.'/components/com_content/helpers/route.php');

//Core Vars

$userid = $user->get('id');
$accesslevel = !$contentconfig->get('show_noauth');
$nullDate = $db->getNullDate();
$date = JFactory::getDate();
$now = $date->toSQL();

//Parameters
$artid = trim($params->get('artid', ''));
$filteraccess = $params->get('filteraccess', 0);
$avatarw = $params->get('avatarw');
$avatarh = $params->get('avatarh');
$compat = $params->get('compat', 'none');
$comcompat = $params->get('comcompat', 'none');
$catid = $params->get('catid', 0); if (!is_array($catid)) { $catid = array($catid); }
$tags = $params->get('tags', 0); if (!is_array($tags)) { $tags = array($tags); }

$usecurrentcat = $params->get('usecurrentcat', 1);
$authorid = $params->get('authorid', 0); if (!is_array($authorid)) { $authorid = array($authorid); }
$includefrontpage = $params->get('includefrontpage', 1);
$group = $params->get('group', 0);
$sortorder = $params->get('sortorder', 3);
$order = $params->get('order', 3);
$rows = $params->get('rows', 1);
$columns = $params->get('columns', 1);
$pages = $params->get('pages', 1);
$offset = $params->get('offset', 0);
$template = $params->get('template', '');
$moduletemplate = trim($params->get('modulehtml', '{mainarea}'));
$itemtemplate = trim($params->get('html', '{intro}'));
$dateformat = trim($params->get('dateformat', 'Y-m-d'));
$moreclone = $params->get('moreclone', 0);
$morepos = $params->get('morepos', 'b');
$moreqty = $params->get('moreqty', 0);
$morecols = trim($params->get('morecols', 1));
$morelegend = trim($params->get('moretext', ''));
$morelegendcolor = $params->get('morergb', 'cccccc');
$moretemplate = $params->get('morehtml', '{title}');
$languagefilter = $params->get('languagefilter', 0);

if ($template && $template != -1) {
    $moduletemplate = file_get_contents(JPATH_ROOT.'/modules/mod_jxtc_newspro/templates/'.$template.'/module.html');
    $itemtemplate = file_get_contents(JPATH_ROOT.'/modules/mod_jxtc_newspro/templates/'.$template.'/element.html');
    $moretemplate = file_get_contents(JPATH_ROOT.'/modules/mod_jxtc_newspro/templates/'.$template.'/more.html');
    if (file_exists(JPATH_ROOT.'/modules/mod_jxtc_newspro/templates/'.$template.'/template.css')) {
        $doc->addStyleSheet($live_site . 'modules/mod_jxtc_newspro/templates/' . $template . '/template.css', 'text/css');
    }
}

// Build Query
if ($usecurrentcat == 1) {
    $option = JRequest::getCmd('option');
    $view = JRequest::getCmd('view');
    if ($option == 'com_content' and $view == "category") {
			$catid = array(JRequest::getInt('id'));
    }
}

if ($tags && $support_tags) {
    $query = 'SELECT content_item_id FROM #__contentitem_tag_map WHERE type_alias LIKE "com_content.article" AND tag_id IN (' . implode(',', $tags) . ')';
    $db->setQuery($query);
    $aux = $db->loadObjectList('content_item_id');
    $aux = array_keys($aux);
    $tags = implode(",", $aux);
}

$query = 'SELECT a.id, a.access,a.introtext,a.fulltext, a.title,UNIX_TIMESTAMP(a.created) as created,UNIX_TIMESTAMP(a.modified) as modified, a.catid, a.created_by, a.created_by_alias, a.hits, a.alias, a.images, a.urls,
	cc.title as cat_title, cc.params as cat_params, cc.description as cat_description, cc.alias as cat_alias, cc.id as cat_id,
	u.name as author, u.username as authorid,
	CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,
	CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug
	FROM #__content AS a';
if ($includefrontpage == '0') {
    $query .= ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id';
}
$query .= ' INNER JOIN #__categories AS cc ON cc.id = a.catid
	LEFT JOIN #__users AS u ON u.id = a.created_by';
if ($includefrontpage == '2') {
    $query .= ', #__content_frontpage AS f ';
}
$query .= ' WHERE a.state = 1 ';
if ($includefrontpage == '2') {
    $query .= ' AND f.content_id = a.id ';
}
$query .= 'AND ( a.publish_up = ' . $db->Quote($nullDate) . ' OR a.publish_up <= ' . $db->Quote($now) . ' )
	AND ( a.publish_down = ' . $db->Quote($nullDate) . ' OR a.publish_down >= ' . $db->Quote($now) . ' )
	AND (cc.published = 1 OR cc.published IS NULL)';

if ($accesslevel && $filteraccess) {
    $groups = implode(',', $user->getAuthorisedViewLevels());
    $query .= ' AND a.access IN (' . $groups . ')';
}
if ($artid) {
    $articles = explode(',', $artid);
    JArrayHelper::toInteger($articles);
    $query .= ' AND a.id in (' . implode(',', $articles) . ') ';
} else {
  if ($catid[0] != 0) {
		$query .= ' AND (cc.id=' . implode(' OR cc.id=', $catid) . ')';
  }
    
  if ($tags && $support_tags) {
		$query .= ' AND a.id in (' . $tags . ') ';
  }
}
if ($includefrontpage == '0') {
    $query .= ' AND f.content_id IS NULL ';
}

if ($authorid[0] != 0) {
    $query .= ' AND created_by in (' . implode(',', $authorid) . ')';
}

//language
switch ($languagefilter) {
	case 1: // 1 Default language
		$query.=" AND a.language = '*'";
	break;
	case 2: // 2 User language
		$lang_tag = JFactory::getLanguage()->get('tag');
		$query.=" AND a.language = '".$lang_tag."'";
	break;
	case 3: // 3 default + User languages
		$lang_tag = JFactory::getLanguage()->get('tag');
		$query.=" AND (a.language = '*' OR a.language = '".$lang_tag."')";
	break;
	default: // 0 All
}

if ($group == 1) {
    $query .= ' GROUP BY a.created_by';
}
$query .= ' ORDER BY ';

$aux = ($order == '0') ? ' ASC ' : ' DESC ';

switch ($sortorder) {
    case 0: // creation
        $query .= 'a.created'.$aux;
        break;
    case 1: // modified
        $query .= 'a.modified'.$aux;
        break;
    case 2: // hits
        $query .= 'a.hits'.$aux;
        break;
    case 3: // joomla order
        $query .= 'a.ordering'.$aux;
        break;
    case 5: // Category Title
        $query .= 'cc.title'.$aux;
        break;
    case 6: // Article Title
        $query .= 'a.title'.$aux;
        break;
    case 7:
        $query .= 'RAND()';
        break;
}

$mainqty = $columns * $rows * $pages;
$db->setQuery($query, $offset, $mainqty + $moreqty);
$items = $db->loadObjectList();

if (count($items) == 0) return; // Return if empty

// Check for RL support
$enablerl = false;
jimport( 'joomla.plugin.helper' );
if (JpluginHelper::isEnabled('content','jxtcreadinglist')) {
	$enablerl = true;
}

// Main area
$rowmaxintro = $params->get('maxintro', '');
$rowmaxintrosuf = $params->get('maxintrosuf', '...');
$rowmaxtitle = $params->get('maxtitle', '');
$rowmaxtitlesuf = $params->get('maxtitlesuf', '...');
$rowmaxtext = $params->get('maxtext', '');
$rowmaxtextsuf = $params->get('maxtextsuf', '...');
$rowtextbrk = $params->get('textbrk', '');
require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default'));

// More area
$rowmaxintro = $params->get('moreintro', '');
$rowmaxintrosuf = $params->get('moreintrosuf', '...');
$rowmaxtitle = $params->get('moretitle', '');
$rowmaxtitlesuf = $params->get('moretitlesuf', '...');
$rowmaxtext = $params->get('moremaxtext', '');
$rowmaxtextsuf = $params->get('moremaxtextsuf', '...');
$rowtextbrk = $params->get('moretextbrk', '');

$items = $params->get('moreclone', 0)
	? array_slice($items,0,$moreqty)
	: array_slice($items,($columns * $rows * $pages),$moreqty);

require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default').'_more');

if ($params->get('contentPlugins', 1)) {
	JPluginHelper::importPlugin('content');
	$contentconfig = JComponentHelper::getParams('com_content');
	$dispatcher = JDispatcher::getInstance();
	$item = new stdClass();
	$item->text = $modulehtml;
	$results = $dispatcher->trigger('onContentPrepare', array ('com_content.article', &$item, &$contentconfig, 0 ));
	$modulehtml = $item->text;
}

echo '<div id="' . $jxtc . '">' . $modulehtml . '</div>';
