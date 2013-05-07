<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td align="center">
                	<?php echo $item->id; ?>
                </td>
                <td align="center">
                	<?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td align="center">
                	<b><?php echo $item->name; ?></b>
                </td>
                <td align="center">
                	<?php echo $item->activated; ?>
                </td>
                <td align="center">
                	<?php echo $item->last_export; ?>
                </td>
                <td align="center">
                	<?php echo $item->nb_export; ?>
                </td>
        </tr>
<?php endforeach; ?>