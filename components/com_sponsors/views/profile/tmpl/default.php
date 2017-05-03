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

$address = array('zip' => true, 'city' => true, 'region' => true, 'country' => true);
foreach ($address as $key => $element) {
    if (!empty($this->item->{$key}) && $element === true) {
        $address[$key] = $this->item->$key;
    }
}

?>
<?php if (isset($this->item->banner3)): ?>
    <div class="row-fluid">
        <div class="span12">
            <?php if (isset($this->item->url)): ?><a href="<?php echo $this->item->url; ?>" target="_blank" rel="nofollow"><?php endif; ?>
                <img src="<?php echo $this->item->banner3; ?>"
                <?php if (isset($this->item->url)): ?></a><?php endif; ?>
        </div>
    </div>
<?php endif; ?>


    <div class="row-fluid">

        <div class="span4">
            <address>
                <strong><?php echo utf8_decode($this->item->name); ?></strong><br>
                <?php echo nl2br($this->item->address); ?><br>
                <?php echo implode(' ', $address); ?>
                <br/><br/>

                <strong><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_CIF'); ?></strong>
                <?php echo $this->item->cif; ?><br/><br/>

                <?php if (isset($this->item->phone)): ?>
                    <strong><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_PHONE'); ?></strong>
                    <a href="tel:<?php echo $this->item->phone; ?>" rel="nofollow"><?php echo $this->item->phone; ?></a>
                    <br>
                <?php endif; ?>

                <?php if (isset($this->item->email)): ?>
                    <strong><?php echo JText::_('COM_SPONSORS_FORM_LBL_PROFILE_EMAIL'); ?></strong>
                    <a href="mailto:<?php echo $this->item->email; ?>"><?php echo $this->item->email; ?></a>
                <?php endif; ?>
            </address>
            <div class="social" style="margin-bottom: 15px;">

                <?php if (isset($this->item->facebook)): ?>
                    <a href="<?php echo $this->item->facebook; ?>" target="_blank" rel="nofollow">
                        <img src="http://pezdisco.es/media/mod_socialmediaicons/images/facebook.png" style="max-width:32px;">
                    </a>
                <?php endif; ?>

                <?php if (isset($this->item->twitter)): ?>
                    <a href="<?php echo $this->item->twitter; ?>" target="_blank" rel="nofollow">
                        <img src="http://pezdisco.es/media/mod_socialmediaicons/images/twitter.png" style="max-width:32px;">
                    </a>
                <?php endif; ?>

                <?php if (isset($this->item->youtube)): ?>
                    <a href="<?php echo $this->item->youtube; ?>" target="_blank" rel="nofollow">
                        <img src="http://pezdisco.es/media/mod_socialmediaicons/images/youtube.png" style="max-width:32px;">
                    </a>
                <?php endif; ?>

            </div>
        </div>

        <div class="span6">

        </div>

    </div>

<?php if ($canEdit && $this->item->checked_out == 0): ?>
    <a class="btn" href="<?php echo JRoute::_('index.php?option=com_sponsors&task=profile.edit&id=' . $this->item->id); ?>"><?php echo JText::_("COM_SPONSORS_EDIT_ITEM"); ?></a>
<?php endif; ?>