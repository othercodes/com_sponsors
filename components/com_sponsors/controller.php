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

jimport('joomla.application.component.controller');

/**
 * Class SponsorsController
 * @since  1.6
 */
class SponsorsController extends JControllerLegacy
{
    /**
     * Method to display a view.
     * @param boolean $cachable If true, the view output will be cached
     * @param mixed $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     * @return JControllerLegacy  This object to support chaining.
     * @since 1.5
     */
    public function display($cachable = false, $urlparams = false)
    {
        $app = JFactory::getApplication();

        /**
         * Retrieve the view param for the URL
         *  - view=profiles () by default!
         */
        $view = $app->input->getCmd('view', 'profiles');

        /**
         * Store the value of view param in the
         * input (GET, POST, REQUEST) with view key
         */
        $app->input->set('view', $view);

        /**
         * Run the parent display method and return
         * $this (chainable)
         */
        return parent::display($cachable, $urlparams);
    }

}
