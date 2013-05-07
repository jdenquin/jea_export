<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jea_export&view=free&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" id="free-form">
      <input type="hidden" name="jform[activated]" id="jform_activated" value="0" />
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_JEA_EXPORT_FREE_DETAILS' ); echo $this->item->name; ?></legend>
                <ul class="adminformlist">
<?php foreach($this->form->getFieldset() as $field): ?>
                        <li><?php echo $field->label;echo $field->input;?></li>
<?php endforeach; ?>
                </ul>
        </fieldset>
        <div>
                <input type="hidden" name="task" value="free.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>