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
                <td>
                	<?php 
                		// Affichage de la premiere image correspondant au bien
                		$images = (array) json_decode($item->images);
                		$imgBasePath = '..'.DS.'images'.DS.'com_jea'.DS.'images'.DS.$item->id.DS;
                		if (!empty($images))
                		{
                			$thumbName = 'thumb-admin-' . $images[0]->name;
                			echo '<img src="' . $imgBasePath . $thumbName . '" />';
                		}
                	?>
                </td>
                <td align="center">
                	<b>
                		<a href="<?php echo JRoute::_('index.php?option=com_jea_export&task=annonce.edit&id='.(int) $item->id); ?>">
                		<?php echo $this->escape($item->ref); ?> </a> 
                	</b>
                </td>
                <td align="center">
                	<?php echo $item->title; ?>
                </td>
                <td align="center">
                	<?php echo $item->town; ?>
                </td>
                <td align="center">
                	<?php
                		$pasrls = explode(',', $item->pasrl_id);
                		$nb_pasrl = count($pasrls) - 1;
                		echo $nb_pasrl;
                	?>
                </td> 
        </tr>
<?php endforeach; ?>