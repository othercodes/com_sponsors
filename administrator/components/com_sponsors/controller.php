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

/**
 * Class SponsorsController
 *
 * @since  1.6
 */
class SponsorsController extends JControllerLegacy
{
    /**
     * Method to display a view.
     *
     * @param   boolean $cachable If true, the view output will be cached
     * @param   mixed $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return   JController This object to support chaining.
     *
     * @since    1.5
     */
    public function display($cachable = false, $urlparams = false)
    {
        $view = JFactory::getApplication()->input->getCmd('view', 'profiles');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }

    /**
     *
     *
     * @since version
     */
    public function discover()
    {
        $processed = 0;

        $app = JFactory::getApplication();
        $params = JComponentHelper::getParams('com_sponsors');
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'alias', 'banner1', 'banner2', 'banner3')));
        $query->from($db->quoteName('#__sponsors_profile'));
        $query->where($db->quoteName('state') . '= 1');
        $db->setQuery($query);
        $sponsors = $db->loadObjectList();

        $discoveringPath = '{root}/images/' . $params->get('banners_path', 'sponsors') . '/{alias}/{alias}-{size}.*';
        $sizes = array(
            'banner1' => '468x60',
            'banner2' => '150x80',
            'banner3' => '1140x200'
        );

        foreach ($sponsors as $sponsor) {

            $operation = false;

            foreach ($sizes as $property => $size) {

                $files = glob(strtr($discoveringPath, array(
                    '{root}' => JPATH_SITE,
                    '{alias}' => $sponsor->alias,
                    '{size}' => $size,
                )));

                if (count($files) > 0) {
                    $sponsor->{$property} = str_replace(JPATH_SITE, '', $files[0]);
                    $operation = $db->updateObject('#__sponsors_profile', $sponsor, 'id');
                }
            }

            if ($operation === true) {
                $processed++;
            }
        }

        $app->enqueueMessage(JText::sprintf('COM_SPONSOR_DISCOVERED_N_BANNERS', $processed), 'notice');

        $this->display(false, false);
    }
}
