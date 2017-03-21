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
 * Class SponsorsFrontendHelper
 *
 * @since  1.6
 */
class SponsorsHelpersSponsors
{
    /**
     * Get an instance of the named model
     *
     * @param   string $name Model name
     *
     * @return null|object
     */
    public static function getModel($name)
    {
        $model = null;

        // If the file exists, let's
        if (file_exists(JPATH_SITE . '/components/com_sponsors/models/' . strtolower($name) . '.php')) {
            require_once JPATH_SITE . '/components/com_sponsors/models/' . strtolower($name) . '.php';
            $model = JModelLegacy::getInstance($name, 'SponsorsModel');
        }

        return $model;
    }

    /**
     * Gets the files attached to an item
     *
     * @param   int $pk The item's id
     *
     * @param   string $table The table's name
     *
     * @param   string $field The field's name
     *
     * @return  array  The files
     */
    public static function getFiles($pk, $table, $field)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
            ->select($field)
            ->from($table)
            ->where('id = ' . (int)$pk);

        $db->setQuery($query);

        return explode(',', $db->loadResult());
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed $item The item
     *
     * @return  bool
     */
    public static function canUserEdit($item)
    {
        $permission = false;
        $user = JFactory::getUser();

        if ($user->authorise('core.edit', 'com_sponsors')) {
            $permission = true;
        } else {
            if (isset($item->created_by)) {
                if ($user->authorise('core.edit.own', 'com_sponsors') && $item->created_by == $user->id) {
                    $permission = true;
                }
            } else {
                $permission = true;
            }
        }

        return $permission;
    }
}
