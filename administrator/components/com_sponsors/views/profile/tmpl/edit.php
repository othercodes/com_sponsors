<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Sponsors
 * @author     Unay Santisteban <usantisteban@othercode.es>
 * @copyright  2017 OtherCode
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_sponsors/css/form.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function () {

    });

    Joomla.submitbutton = function (task) {
        if (task == 'profile.cancel') {
            Joomla.submitform(task, document.getElementById('profile-form'));
        }
        else {

            if (task != 'profile.cancel' && document.formvalidator.isValid(document.id('profile-form'))) {

                Joomla.submitform(task, document.getElementById('profile-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_sponsors&layout=edit&id=' . (int)$this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="profile-form" class="form-validate">

    <?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SPONSORS_TITLE_PROFILE', true)); ?>
        <div class="row-fluid">
            <div class="span9">
                <fieldset class="adminform">
                    <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>"/>

                    <div class="row-fluid">
                        <div class="span6">
                            <?php echo $this->form->renderField('titular'); ?>
                            <?php echo $this->form->renderField('cif'); ?>
                            <?php echo $this->form->renderField('email'); ?>
                            <?php echo $this->form->renderField('phone'); ?>
                            <?php echo $this->form->renderField('address'); ?>
                            <?php echo $this->form->renderField('url'); ?>
                            <?php echo $this->form->renderField('zip'); ?>
                            <?php echo $this->form->renderField('city'); ?>
                            <?php echo $this->form->renderField('region'); ?>
                            <?php echo $this->form->renderField('country'); ?>
                        </div>

                        <div class="span6">
                            <?php echo $this->form->renderField('facebook'); ?>
                            <?php echo $this->form->renderField('twitter'); ?>
                            <?php echo $this->form->renderField('youtube'); ?>
                            <?php echo $this->form->renderField('vip'); ?>
                            <?php echo $this->form->renderField('fido'); ?>

                            <?php echo $this->form->renderField('banner2'); ?>
                            <?php if(!empty($this->form->getValue('banner2'))) :?>
                                <div class="control-group">
                                    <img src="<?php echo JURI::root().$this->form->getValue('banner2'); ?>" />
                                </div>
                            <?php endif; ?>

                            <?php echo $this->form->renderField('banner1'); ?>
                            <?php if(!empty($this->form->getValue('banner1'))) :?>
                            <div class="control-group">
                                <img src="<?php echo JURI::root().$this->form->getValue('banner1'); ?>" />
                            </div>
                            <?php endif; ?>

                            <?php echo $this->form->renderField('banner3'); ?>
                            <?php if(!empty($this->form->getValue('banner3'))) :?>
                                <div class="control-group">
                                    <img src="<?php echo JURI::root().$this->form->getValue('banner3'); ?>" />
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>

                </fieldset>
            </div>

            <div class="span3">
                <fieldset class="adminform">
                    <input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>"/>
                    <input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>"/>
                    <input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>"/>

                    <?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>

                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
        <div class="row-fluid">
            <div class="span6">
                <?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php if (JFactory::getUser()->authorise('core.admin', 'sponsors')) : ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
            <?php echo $this->form->getInput('rules'); ?>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php endif; ?>


        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value=""/>
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>
