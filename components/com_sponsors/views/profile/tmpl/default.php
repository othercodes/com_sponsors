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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_sponsors.' . $this->item->id);

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_sponsors' . $this->item->id)) {
    $canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

    <div class="item_fields">

        <table class="table">

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_NAME'); ?></th>
                <td><?php echo utf8_decode($this->item->name); ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_CIF'); ?></th>
                <td><?php echo $this->item->cif; ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_ADDRESS'); ?></th>
                <td><?php echo nl2br($this->item->address); ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_URL'); ?></th>
                <td><?php echo $this->item->url; ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_ZIP'); ?></th>
                <td><?php echo $this->item->zip; ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_CITY'); ?></th>
                <td><?php echo utf8_decode($this->item->city); ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_REGION'); ?></th>
                <td><?php echo utf8_decode($this->item->region); ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_COUNTRY'); ?></th>
                <td><?php echo utf8_decode($this->item->country); ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_EMAIL'); ?></th>
                <td><?php echo $this->item->email; ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_PHONE'); ?></th>
                <td><?php echo $this->item->phone; ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_FACEBOOK'); ?></th>
                <td><?php echo $this->item->facebook; ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_TWITTER'); ?></th>
                <td><?php echo $this->item->twitter; ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_YOUTUBE'); ?></th>
                <td><?php echo $this->item->youtube; ?></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_BANNER1'); ?></th>
                <td><img src="<?php echo $this->item->banner1; ?>" alt="banner"/></td>
            </tr>

            <tr>
                <th><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_BANNER2'); ?></th>
                <td><img src="<?php echo $this->item->banner2; ?>" alt="banner"/></td>
            </tr>

        </table>

    </div>

<?php if ($canEdit && $this->item->checked_out == 0): ?>

    <a class="btn" href="<?php echo JRoute::_('index.php?option=com_sponsors&task=profile.edit&id=' . $this->item->id); ?>"><?php echo JText::_("COM_SPONSORS_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete', 'com_sponsors.profile.' . $this->item->id)) : ?>

    <a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
        <?php echo JText::_("COM_SPONSORS_DELETE_ITEM"); ?>
    </a>

    <div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?php echo JText::_('COM_SPONSORS_DELETE_ITEM'); ?></h3>
        </div>
        <div class="modal-body">
            <p><?php echo JText::sprintf('COM_SPONSORS_DELETE_CONFIRM', $this->item->id); ?></p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal">Close</button>
            <a href="<?php echo JRoute::_('index.php?option=com_sponsors&task=profile.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
                <?php echo JText::_('COM_SPONSORS_DELETE_ITEM'); ?>
            </a>
        </div>
    </div>

<?php endif; ?>