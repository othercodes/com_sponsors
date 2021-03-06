<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Sponsors
 * @author     Unay Santisteban <usantisteban@othercode.es>
 * @copyright  2017 OtherCode
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

$counter = 1;
if ($this->params->get('random', 0) == 1) {
    shuffle($this->items);
}
?>

<div class="row-fluid">
    <?php foreach ($this->items as $i => $item) : ?>
    <div class="span<?php echo round(12 / $this->params->get('columns')); ?>">
        <div class="banner-patrocinador">
            <?php if ($item->vip == 1) : ?>

            <a href="<?php echo JRoute::_('index.php?option=com_sponsors&view=profile&id=' . (int)$item->id); ?>">
                <?php else : ?>

                <a href="<?php echo $item->url; ?>" rel="nofollow" target="_blank">

                    <?php endif; ?>

                    <?php if ($this->params->get('banner') == 1): ?>
                        <img src="<?php echo $item->banner1; ?>" alt="<?php echo $this->escape($item->name); ?>" style="max-width:468px;"/>
                    <?php elseif ($this->params->get('banner') == 2): ?>
                        <img src="<?php echo $item->banner2; ?>" alt="<?php echo $this->escape($item->name); ?>" style="max-width:150px;"/>
                    <?php else: ?>
                        <img src="<?php echo $item->banner3; ?>" alt="<?php echo $this->escape($item->name); ?>" style="max-width:1140px;"/>
                    <?php endif; ?>
                </a>
        </div>
    </div>
    <?php if ($this->params->get('columns') == $counter++) : ?>
    <?php $counter = 1; ?>
</div>
<div class="row-fluid">
    <?php endif; ?>

    <?php endforeach; ?>
</div>