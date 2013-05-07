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
                	<b>
                		<a href="<?php echo JRoute::_('index.php?option=com_jea_export&task=free.edit&id='.(int) $item->id); ?>">
                		<?php echo $item->name; ?>
                	</b>
                </td>
                <td align="center">
                	<?php echo $item->code_agence; ?>
                </td>
                <td align="center">
                	<?php 
                		if ((int) $item->activated == 0)
                		{
                			?><img src="../media/com_jea_export/images/non_active.png" alt="Non Active" /><?php 
                		}
                		else 
                		{
                			?><img src="../media/com_jea_export/images/active.png" alt="Active" /><?php 
                		}                	
                	?>
                </td>
                <td align="center">
                	<?php echo date('d/m/Y H:i:s', strtotime($item->last_export)); ?>
                </td>
                <td align="center">
                	<?php echo $item->nb_export; ?>
                </td>
                <td width="40" align="center">
                	<?php if($item->code_agence == ''){?>
                		<a href="<?php echo $item->signup_link; ?>"><?php echo JText::_('COM_JEA_EXPORT_SIGNUP_LABEL')?></a>
                	<?php }else{ echo '&nbsp;'; }?>
                </td>
        </tr>
<?php endforeach; ?>