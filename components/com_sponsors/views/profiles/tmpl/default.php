<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Sponsors
 * @author     Unay Santisteban <usantisteban@othercode.es>
 * @copyright  2017 OtherCode
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * get this parameters from the configuration
 */
$columns = 3;
$counter = 1;

?>

<div class="row-fluid">
    <?php foreach ($this->items as $i => $item) : ?>

    <div class="span<?php echo round(12/$columns); ?>">
        <a href="<?php echo JRoute::_('index.php?option=com_sponsors&view=profile&id=' . (int)$item->id); ?>">
            <img src="<?php echo $item->banner1; ?>" alt="<?php echo $this->escape($item->name); ?>" />
        </a>
    </div>

    <?php if ($columns === $counter++) : ?>
    <?php $counter = 1; ?>
</div>
<div class="row-fluid">
    <?php endif; ?>

    <?php endforeach; ?>
</div>