<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Sponsors
 * @author     Unay Santisteban <usantisteban@othercode.es>
 * @copyright  2017 OtherCode
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

use Joomla\Utilities\ArrayHelper;

/**
 * Sponsors model.
 * @since  1.6
 */
class SponsorsModelProfile extends JModelItem
{
    /**
     * Method to auto-populate the model state.
     * Note. Calling getState in this method will result in recursion.
     * @return void
     * @since    1.6
     */
    protected function populateState()
    {
        $app = JFactory::getApplication('com_sponsors');
        $user = JFactory::getUser();

        // Check published state
        if ((!$user->authorise('core.edit.state', 'com_sponsors')) && (!$user->authorise('core.edit', 'com_sponsors'))) {
            $this->setState('filter.published', 1);
            $this->setState('fileter.archived', 2);
        }

        // Load state from the request userState on edit or from the passed variable on default
        if (JFactory::getApplication()->input->get('layout') == 'edit') {
            $id = JFactory::getApplication()->getUserState('com_sponsors.edit.profile.id');

        } else {
            $id = JFactory::getApplication()->input->get('id');
            JFactory::getApplication()->setUserState('com_sponsors.edit.profile.id', $id);
        }

        $this->setState('profile.id', $id);

        // Load the parameters.
        $params = $app->getParams();
        $params_array = $params->toArray();

        if (isset($params_array['item_id'])) {
            $this->setState('profile.id', $params_array['item_id']);
        }

        $this->setState('params', $params);
    }

    /**
     * Method to get an object.
     * @param   integer $id The id of the object to get.
     * @return  mixed    Object on success, false on failure.
     * @throws \Exception
     * @since 1.0
     */
    public function &getData($id = null)
    {
        if ($this->_item === null) {
            $this->_item = false;

            if (empty($id)) {
                $id = $this->getState('profile.id');
            }

            // Get a level row instance.
            $table = $this->getTable();

            // Attempt to load the row.
            if ($table->load($id)) {
                // Check published state.
                if ($published = $this->getState('filter.published')) {
                    if (isset($table->state) && $table->state != $published) {
                        throw new Exception(JText::_('COM_SPONSORS_ITEM_NOT_LOADED'), 403);
                    }
                }

                // Convert the JTable to a clean JObject.
                $properties = $table->getProperties(1);
                $this->_item = ArrayHelper::toObject($properties, 'JObject');
            }
        }

        if (isset($this->_item->titular)) {
            $this->_item->titular_name = JFactory::getUser($this->_item->titular)->name;
        }
        if (isset($this->_item->created_by)) {
            $this->_item->created_by_name = JFactory::getUser($this->_item->created_by)->name;
        }
        if (isset($this->_item->modified_by)) {
            $this->_item->modified_by_name = JFactory::getUser($this->_item->modified_by)->name;
        }

        return $this->_item;
    }

    /**
     * Get an instance of JTable class
     * @param   string $type Name of the JTable class to get an instance of.
     * @param   string $prefix Prefix for the table class name. Optional.
     * @param   array $config Array of configuration values for the JTable object. Optional.
     * @return  JTable|bool JTable if success, false on failure.
     * @since 1.0
     */
    public function getTable($type = 'Profile', $prefix = 'SponsorsTable', $config = array())
    {
        $this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_sponsors/tables');

        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Get the id of an item by alias
     * @param   string $alias Item alias
     * @return  mixed
     * @since 1.0
     */
    public function getItemIdByAlias($alias)
    {
        $table = $this->getTable();
        $properties = $table->getProperties();

        if (!array_key_exists('alias', $properties)) {
            return null;
        }

        $table->load(array('alias' => $alias));

        return $table->id;
    }

    /**
     * Method to check in an item.
     * @param   integer $id The id of the row to check out.
     * @return  boolean True on success, false on failure.
     * @since    1.6
     */
    public function checkin($id = null)
    {
        // Get the id.
        $id = (!empty($id)) ? $id : (int)$this->getState('profile.id');

        if ($id) {
            // Initialise the table
            $table = $this->getTable();

            // Attempt to check the row in.
            if (method_exists($table, 'checkin')) {
                if (!$table->checkin($id)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Method to check out an item for editing.
     * @param   integer $id The id of the row to check out.
     * @return  boolean True on success, false on failure.
     * @since    1.6
     */
    public function checkout($id = null)
    {
        // Get the user id.
        $id = (!empty($id)) ? $id : (int)$this->getState('profile.id');

        if ($id) {
            // Initialise the table
            $table = $this->getTable();

            // Get the current user object.
            $user = JFactory::getUser();

            // Attempt to check the row out.
            if (method_exists($table, 'checkout')) {
                if (!$table->checkout($user->get('id'), $id)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the name of a category by id
     * @param   int $id Category id
     * @return  Object|null    Object if success, null in case of failure
     * @since    1.0
     */
    public function getCategoryName($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
            ->select('title')
            ->from('#__categories')
            ->where('id = ' . $id);
        $db->setQuery($query);

        return $db->loadObject();
    }

    /**
     * Publish the element
     * @param   int $id Item id
     * @param   int $state Publish state
     * @return  boolean
     * @since    1.0
     */
    public function publish($id, $state)
    {
        $table = $this->getTable();
        $table->load($id);
        $table->state = $state;

        return $table->store();
    }

    /**
     * Method to delete an item
     * @param   int $id Element id
     * @return  bool
     * @since    1.0
     */
    public function delete($id)
    {
        $table = $this->getTable();

        return $table->delete($id);
    }

    /**
     * Return the alias field for each view
     * @param string $view
     * @return string
     * @since 1.0
     */
    public function getAliasFieldNameByView($view)
    {
        switch ($view) {
            case 'profile':
            case 'profileform':
                return 'alias';
                break;
        }
    }

    /**
     * Return the sponsor articles
     * @return array
     * @since 1.0
     */
    public function getArticles($sponsor)
    {

        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select('*');
        $query->from('#__content AS a');
        $query->where('created_by = ' . $sponsor->titular);

        $query->where('state = 1');
        //$query->order('created');

        $db->setQuery($query);
        $result = $db->loadObjectList();

        return $result;

    }

}
