<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

// Get the mime type class.
$mime = !empty($this->result->mime) ? 'mime-' . $this->result->mime : null;

// Get the base url.
$base = JURI::getInstance()->toString(array('scheme', 'host', 'port'));

// Get the route with highlighting information.
if (!empty($this->query->highlight) && empty($this->result->mime) && $this->params->get('highlight_terms', 1) && JPluginHelper::isEnabled('system', 'highlight')) {
	$route = $this->result->route . '&highlight=' . base64_encode(serialize($this->query->highlight));
} else {
	$route = $this->result->route;
}
?>

<dt class="result-title <?php echo $mime; ?>">
	<a href="<?php echo JRoute::_($route); ?>"><?php echo $this->result->title; ?></a>
</dt>
<?php if ($this->params->get('show_description', 1)): ?>
<dd class="result-text<?php echo $this->pageclass_sfx; ?>">
	<?php echo JHtml::_('string.truncate', $this->result->description, $this->params->get('description_length', 255)); ?>
</dd>
<?php endif; ?>
<?php if ($this->params->get('show_url', 1)): ?>
<dd class="result-url<?php echo $this->pageclass_sfx; ?>">
	<?php echo $base . JRoute::_($this->result->route); ?>
</dd>
<?php endif;