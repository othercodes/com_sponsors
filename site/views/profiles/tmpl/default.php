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
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canCreate = $user->authorise('core.create', 'com_sponsors') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'profileform.xml');
$canEdit = $user->authorise('core.edit', 'com_sponsors') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'profileform.xml');
$canCheckin = $user->authorise('core.manage', 'com_sponsors');
$canChange = $user->authorise('core.edit.state', 'com_sponsors');
$canDelete = $user->authorise('core.delete', 'com_sponsors');
?>

<form action="<?php echo JRoute::_('index.php?option=com_sponsors&view=profiles'); ?>" method="post"
      name="adminForm" id="adminForm">

    <?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
    <table class="table table-striped" id="profileList">
        <thead>
        <tr>
            <?php if (isset($this->items[0]->state)): ?>
                <th width="5%">
                    <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
                </th>
            <?php endif; ?>

            <th class=''>
                <?php echo JHtml::_('grid.sort', 'COM_SPONSORS_PROFILES_ID', 'a.id', $listDirn, $listOrder); ?>
            </th>
            <th class=''>
                <?php echo JHtml::_('grid.sort', 'COM_SPONSORS_PROFILES_NAME', 'a.name', $listDirn, $listOrder); ?>
            </th>
            <th class=''>
                <?php echo JHtml::_('grid.sort', 'COM_SPONSORS_PROFILES_CIF', 'a.cif', $listDirn, $listOrder); ?>
            </th>
            <th class=''>
                <?php echo JHtml::_('grid.sort', 'COM_SPONSORS_PROFILES_EMAIL', 'a.email', $listDirn, $listOrder); ?>
            </th>
            <th class=''>
                <?php echo JHtml::_('grid.sort', 'COM_SPONSORS_PROFILES_VIP', 'a.vip', $listDirn, $listOrder); ?>
            </th>
            <th class=''>
                <?php echo JHtml::_('grid.sort', 'COM_SPONSORS_PROFILES_FIDO', 'a.fido', $listDirn, $listOrder); ?>
            </th>


            <?php if ($canEdit || $canDelete): ?>
                <th class="center">
                    <?php echo JText::_('COM_SPONSORS_PROFILES_ACTIONS'); ?>
                </th>
            <?php endif; ?>

        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
                <?php echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($this->items as $i => $item) : ?>
            <?php $canEdit = $user->authorise('core.edit', 'com_sponsors'); ?>

            <?php if (!$canEdit && $user->authorise('core.edit.own', 'com_sponsors')): ?>
                <?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
            <?php endif; ?>

            <tr class="row<?php echo $i % 2; ?>">

                <?php if (isset($this->items[0]->state)) : ?>
                    <?php $class = ($canChange) ? 'active' : 'disabled'; ?>
                    <td class="center">
                        <a class="btn btn-micro <?php echo $class; ?>" href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_sponsors&task=profile.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
                            <?php if ($item->state == 1): ?>
                                <i class="icon-publish"></i>
                            <?php else: ?>
                                <i class="icon-unpublish"></i>
                            <?php endif; ?>
                        </a>
                    </td>
                <?php endif; ?>

                <td>

                    <?php echo $item->id; ?>
                </td>
                <td>
                    <?php if (isset($item->checked_out) && $item->checked_out) : ?>
                        <?php echo JHtml::_('jgrid.checkedout', $i, $item->uEditor, $item->checked_out_time, 'profiles.', $canCheckin); ?>
                    <?php endif; ?>
                    <a href="<?php echo JRoute::_('index.php?option=com_sponsors&view=profile&id=' . (int)$item->id); ?>">
                        <?php echo $this->escape($item->name); ?></a>
                </td>
                <td>

                    <?php echo $item->cif; ?>
                </td>
                <td>

                    <?php echo $item->email; ?>
                </td>
                <td>

                    <?php if (!empty($item->vip)): ?>
                        <?php echo JText::_('COM_SPONSORS_PROFILES_VIP_OPTION_ON'); ?>
                    <?php else: ?>
                        <?php echo JText::_('COM_SPONSORS_PROFILES_VIP_OPTION_OFF'); ?>
                    <?php endif; ?>                </td>
                <td>

                    <?php if (!empty($item->fido)): ?>
                        <?php echo JText::_('COM_SPONSORS_PROFILES_FIDO_OPTION_ON'); ?>
                    <?php else: ?>
                        <?php echo JText::_('COM_SPONSORS_PROFILES_FIDO_OPTION_OFF'); ?>
                    <?php endif; ?>                </td>


                <?php if ($canEdit || $canDelete): ?>
                    <td class="center">
                        <?php if ($canEdit): ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_sponsors&task=profileform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit"></i></a>
                        <?php endif; ?>
                        <?php if ($canDelete): ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_sponsors&task=profileform.remove&id=' . $item->id, false, 2); ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash"></i></a>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($canCreate) : ?>
        <a href="<?php echo JRoute::_('index.php?option=com_sponsors&task=profileform.edit&id=0', false, 0); ?>"
           class="btn btn-success btn-small"><i
                    class="icon-plus"></i>
            <?php echo JText::_('COM_SPONSORS_ADD_ITEM'); ?></a>
    <?php endif; ?>

    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
    <?php echo JHtml::_('form.token'); ?>
</form>

<?php if ($canDelete) : ?>
    <script type="text/javascript">

        jQuery(document).ready(function () {
            jQuery('.delete-button').click(deleteItem);
        });

        function deleteItem() {

            if (!confirm("<?php echo JText::_('COM_SPONSORS_DELETE_MESSAGE'); ?>")) {
                return false;
            }
        }
    </script>
<?php endif; ?>
