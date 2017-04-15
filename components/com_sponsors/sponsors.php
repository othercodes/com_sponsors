<?php
/**
 * @version    CVS: 1.0.0
 * @package    com_sponsors
 * @author     Unay Santisteban <usantisteban@othercode.es>
 * @copyright  2017 otherCode
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */


/*****************************************
 *   MAIN ENTRY POINT FOR OUR COMPONENT
 *****************************************
 *
 * No direct access for external elements.
 */

defined('_JEXEC') or die;

/**
 * Include dependencies
 *  - main controller class
 */
jimport('joomla.application.component.controller');

/**
 * Register the component path
 *  - prefix: Sponsors, for autoload proposes
 *  - controller: SponsorsController alias for the file controller.php
 */
JLoader::registerPrefix('Sponsors', JPATH_COMPONENT);
JLoader::register('SponsorsController', JPATH_COMPONENT . '/controller.php');

/**
 * Get a new instance of the SponsorController class
 *  - SponsorsController -> components/com_sponsor/controller.php
 */
$controller = JControllerLegacy::getInstance('Sponsors');

/**
 * Execute the required method in the URL param task
 * (task=doSomething), basically is a redirect method
 */
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
