<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

// Status Of Delimiter
$closeDelimiter = false;
$openTable = true;
$hiddenFields = '';

// Output: Userfields
foreach($this->userFields['fields'] as $field) {

	if($field['type'] == 'delimiter') {

		// For Every New Delimiter
		// We need to close the previous
		// table and delimiter
		if($closeDelimiter) { ?>
			</table>
		</fieldset>
		<?php
		$closeDelimiter = false;
		} //else {
			?>
			<fieldset>
			<span class="userfields_info"><?php echo $field['title'] ?></span>

			<?php
			$closeDelimiter = true;
			$openTable = true;
		//}
	} elseif ($field['hidden'] == true) {

		// We collect all hidden fields
		// and output them at the end
		$hiddenFields .= $field['formcode'] . "\n";

	} else {

		// If we have a new delimiter
		// we have to start a new table
		if($openTable) {
			$openTable = false;
			?>

			<table  class="adminForm user-details">

		<?php
		}

		// Output: Userfields
		?>
				<tr>
					<td class="key" title="<?php echo $field['description'] ?>" >
						<label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
							<?php echo $field['title'] . ($field['required'] ? ' *' : '') ?>
						</label>
					</td>
					<td>
						<?php echo $field['formcode'] ?>
					</td>
				</tr>
	<?php
	}

}

// At the end we have to close the current
// table and delimiter ?>

			</table>
		</fieldset>

<?php // Output: Hidden Fields
echo $hiddenFields;