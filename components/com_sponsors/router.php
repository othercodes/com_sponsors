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

JLoader::registerPrefix('Sponsors', JPATH_SITE . '/components/com_sponsors/');

/**
 * Class SponsorsRouter
 *
 * @since  3.3
 */
class SponsorsRouter extends JComponentRouterBase
{
    /**
     * Build method for URLs
     * This method is meant to transform the query parameters into a more human
     * readable form. It is only executed when SEF mode is switched on.
     * @param   array &$query An array of URL arguments
     * @return  array  The URL arguments to use to assemble the subsequent URL.
     * @since   3.3
     */
    public function build(&$query)
    {
        $segments = array();
        $view = null;

        if (isset($query['task'])) {
            $taskParts = explode('.', $query['task']);
            $segments[] = implode('/', $taskParts);
            $view = $taskParts[0];
            unset($query['task']);
        }

        if (isset($query['view'])) {
            $segments[] = $query['view'];
            $view = $query['view'];

            unset($query['view']);
        }

        if (isset($query['id'])) {
            if ($view !== null) {
                $model = SponsorsHelpersSponsors::getModel($view);
                if ($model !== null) {
                    $item = $model->getData($query['id']);
                    $alias = $model->getAliasFieldNameByView($view);
                    $segments[] = (isset($alias)) ? $item->alias : $query['id'];
                }
            } else {
                $segments[] = $query['id'];
            }

            unset($query['id']);
        }

        return $segments;
    }

    /**
     * Parse method for URLs
     * This method is meant to transform the human readable URL back into
     * query parameters. It is only executed when SEF mode is switched on.
     * @param   array &$segments The segments of the URL to parse.
     * @return  array  The URL attributes to be used by the application.
     * @since   3.3
     */
    public function parse(&$segments)
    {
        $vars = array();

        // View is always the first element of the array
        $vars['view'] = array_shift($segments);
        $model = SponsorsHelpersSponsors::getModel($vars['view']);

        while (!empty($segments)) {
            $segment = array_pop($segments);

            // If it's the ID, let's put on the request
            if (is_numeric($segment)) {
                $vars['id'] = $segment;
            } else {
                $id = $model->getItemIdByAlias(str_replace(':', '-', $segment));
                if (!empty($id)) {
                    $vars['id'] = $id;
                } else {
                    $vars['task'] = $vars['view'] . '.' . $segment;
                }
            }
        }

        return $vars;
    }
}
