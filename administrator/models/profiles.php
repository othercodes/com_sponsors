<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Sponsors
 * @author     Unay Santisteban <usantisteban@othercode.es>
 * @copyright  2017 OtherCode
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Sponsors records.
 *
 * @since  1.6
 */
class SponsorsModelProfiles extends JModelList
{
/**
	* Constructor.
	*
	* @param   array  $config  An optional associative array of configuration settings.
	*
	* @see        JController
	* @since      1.6
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.`id`',
				'ordering', 'a.`ordering`',
				'name', 'a.`name`',
				'alias', 'a.`alias`',
				'cif', 'a.`cif`',
				'titular', 'a.`titular`',
				'address', 'a.`address`',
				'url', 'a.`url`',
				'zip', 'a.`zip`',
				'city', 'a.`city`',
				'cstate', 'a.`cstate`',
				'country', 'a.`country`',
				'email', 'a.`email`',
				'phone', 'a.`phone`',
				'facebook', 'a.`facebook`',
				'twitter', 'a.`twitter`',
				'youtube', 'a.`youtube`',
				'vip', 'a.`vip`',
				'fido', 'a.`fido`',
				'banner1', 'a.`banner1`',
				'banner2', 'a.`banner2`',
				'created_by', 'a.`created_by`',
				'modified_by', 'a.`modified_by`',
				'state', 'a.`state`',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);
		// Filtering vip
		$this->setState('filter.vip', $app->getUserStateFromRequest($this->context.'.filter.vip', 'filter_vip', '', 'string'));

		// Filtering fido
		$this->setState('filter.fido', $app->getUserStateFromRequest($this->context.'.filter.fido', 'filter_fido', '', 'string'));


		// Load the parameters.
		$params = JComponentHelper::getParams('com_sponsors');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.name', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return   string A store id.
	 *
	 * @since    1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*'
			)
		);
		$query->from('`#__sponsors_profile` AS a');

		// Join over the users for the checked out user
		$query->select("uc.name AS uEditor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Join over the user field 'titular'
		$query->select('`titular`.name AS `titular`');
		$query->join('LEFT', '#__users AS `titular` ON `titular`.id = a.`titular`');

		// Join over the user field 'created_by'
		$query->select('`created_by`.name AS `created_by`');
		$query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');

		// Join over the user field 'modified_by'
		$query->select('`modified_by`.name AS `modified_by`');
		$query->join('LEFT', '#__users AS `modified_by` ON `modified_by`.id = a.`modified_by`');

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('( a.name LIKE ' . $search . '  OR  a.cif LIKE ' . $search . '  OR  a.email LIKE ' . $search . ' )');
			}
		}


		//Filtering vip
		$filter_vip = $this->state->get("filter.vip");
		if ($filter_vip)
		{
			$query->where("a.`vip` = '".$db->escape($filter_vip)."'");
		}

		//Filtering fido
		$filter_fido = $this->state->get("filter.fido");
		if ($filter_fido)
		{
			$query->where("a.`fido` = '".$db->escape($filter_fido)."'");
		}
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();

		foreach ($items as $oneItem) {
					$oneItem->vip = JText::_('COM_SPONSORS_PROFILES_VIP_OPTION_' . strtoupper($oneItem->vip));
					$oneItem->fido = JText::_('COM_SPONSORS_PROFILES_FIDO_OPTION_' . strtoupper($oneItem->fido));
		}
		return $items;
	}
}
