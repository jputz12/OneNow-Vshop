<?php
/**
 * @version $Id: default_files.php 375 2015-02-21 16:30:36Z michal $
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

defined ('_JEXEC') or die('Restricted access'); ?>

<div class="djc_files">
<h3><?php echo JText::_('COM_DJCATALOG2_FILES'); ?></h3>
<ul>
<?php foreach($this->item->files as $file) {?>
	<li class="djc_file">
		<a target="_blank" class="button" href="<?php echo ('index.php?option=com_djcatalog2&format=raw&task=download&fid='.$file->id);?>">
			<span><?php echo htmlspecialchars($file->caption); ?></span>
		</a>
		<?php if ($this->params->get('show_fileinfos_item', 1) > 0) {?>
		<br />
		<span class="djc_filesize small"><?php echo $file->ext; ?> | <?php echo $file->size; ?> | <?php echo sprintf(JText::_('COM_DJCATALOG2_FILE_HITS'),$file->hits); ?></span>
		<?php } ?>
	</li>
<?php } ?>
</ul>
</div>