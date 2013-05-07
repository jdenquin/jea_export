<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jea_export&view=annonce&task=enregistrer'); ?>"
      method="post" name="adminForm" id="annonce-form">
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_JEA_EXPORT_ANNONCE_INFOS' ); echo $this->item->id; ?></legend>
                <ul class="adminformlist">
					<?php foreach($this->form->getFieldset('infos') as $field): ?>
                        <li><?php echo $field->label;echo $field->input;?></li>
					<?php endforeach; ?>
                </ul>
        </fieldset>
        
	        <fieldset class="adminform">
	        	<legend><?php echo JText::_('COM_JEA_EXPORT_ANNONCE_PASSERELLE'); ?></legend>
	        	<ul class="adminformlist">
	        		<?php // BOOM IMMO ?>
	        		<li>
	        			<label><?php echo JText::_('COM_JEA_EXPORT_BOOMIMMO_LABEL')?></label>
	        			<?php
	        				$empty = false;
	        				if ($this->item->pasrl_id == '') { $empty = true; }
	        				$pasrl = explode(',', $this->item->pasrl_id); 
							$boom = array_search('boomimmo', $pasrl); 
						?>
	        			<input type="checkbox" name="boom_immo" id="boom_immo" <?php if ($boom !== FALSE && !$empty) { echo 'value="1"'; } if ($boom !== FALSE && !$empty) echo 'checked="checked"'; ?> />
	        		</li>
	        		<?php // WEB IMMOBILIER?>
	        		<li>
	        			<label><?php echo JText::_('COM_JEA_EXPORT_WEBIMMO_LABEL')?></label>
	        			<?php 
	        				$webimmo = array_search('webimmo', $pasrl);
	        			?>
	        			<input type="checkbox" name="web_immo" id="web_immo" <?php if ($webimmo !== FALSE && !$empty) { echo 'value="1"'; } if ($webimmo !== FALSE && !$empty) echo 'checked="checked"'; ?> />
	        		</li>
	        		<li>
	        			<label><?php echo JText::_('COM_JEA_EXPORT_TROVIT_LABEL')?></label>
	        			<?php 
	        				$trovit = array_search('trovit', $pasrl);
	        			?>
	        			<input type="checkbox" name="trovit" id="trovit" <?php if ($trovit !== FALSE && !$empty) { echo 'value="1"'; } if ($trovit !== FALSE && !$empty) echo 'checked="checked"'; ?> />
	        		</li>
	        	</ul>
	        </fieldset>
        
        
        <div>
                <input type="hidden" name="task" value="annonce.enregistrer" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>