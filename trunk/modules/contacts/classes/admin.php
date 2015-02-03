<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright(c) 2008-2015 PhreeSoft      (www.PhreeSoft.com)       |
// +-----------------------------------------------------------------+
// | This program is free software: you can redistribute it and/or   |
// | modify it under the terms of the GNU General Public License as  |
// | published by the Free Software Foundation, either version 3 of  |
// | the License, or any later version.                              |
// |                                                                 |
// | This program is distributed in the hope that it will be useful, |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of  |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the   |
// | GNU General Public License for more details.                    |
// +-----------------------------------------------------------------+
//  Path: /modules/contacts/classes/admin.php
//
namespace contacts\classes;
require_once ('/config.php');
class admin extends \core\classes\admin {
	public $sort_order  = 3;
	public $id 			= 'contacts';
	public $description = MODULE_CONTACTS_DESCRIPTION;
	public $core		= true;
	public $version		= '3.71';

	function __construct() {
		$this->text = sprintf(TEXT_MODULE_ARGS, TEXT_CONTACTS);
		$this->prerequisites = array( // modules required and rev level for this module to work properly
		  'phreedom'   => 3.6,
		  'phreebooks' => 3.6,
		);
		// Load configuration constants for this module, must match entries in admin tabs
	    $this->keys = array(
		  'ADDRESS_BOOK_CONTACT_REQUIRED'        => '0',
		  'ADDRESS_BOOK_ADDRESS1_REQUIRED'       => '1',
		  'ADDRESS_BOOK_ADDRESS2_REQUIRED'       => '0',
		  'ADDRESS_BOOK_CITY_TOWN_REQUIRED'      => '1',
		  'ADDRESS_BOOK_STATE_PROVINCE_REQUIRED' => '1',
		  'ADDRESS_BOOK_POSTAL_CODE_REQUIRED'    => '1',
		  'ADDRESS_BOOK_TELEPHONE1_REQUIRED'     => '0',
		  'ADDRESS_BOOK_EMAIL_REQUIRED'          => '0',
		);
		// add new directories to store images and data
		$this->dirlist = array(
		  'contacts',
		  'contacts/main',
		);
		// Load tables
		$this->tables = array(
		  TABLE_ADDRESS_BOOK => "CREATE TABLE " . TABLE_ADDRESS_BOOK . " (
			  address_id int(11) NOT NULL auto_increment,
			  class VARCHAR( 255 ) NOT NULL DEFAULT '',
			  ref_id int(11) NOT NULL default '0',
			  type char(2) NOT NULL default '',
			  primary_name varchar(32) NOT NULL default '',
			  contact varchar(32) NOT NULL default '',
			  address1 varchar(32) NOT NULL default '',
			  address2 varchar(32) NOT NULL default '',
			  city_town varchar(24) NOT NULL default '',
			  state_province varchar(24) NOT NULL default '',
			  postal_code varchar(10) NOT NULL default '',
			  country_code char(3) NOT NULL default '',
			  telephone1 VARCHAR(20) NULL DEFAULT '',
			  telephone2 VARCHAR(20) NULL DEFAULT '',
			  telephone3 VARCHAR(20) NULL DEFAULT '',
			  telephone4 VARCHAR(20) NULL DEFAULT '',
			  email VARCHAR(48) NULL DEFAULT '',
			  website VARCHAR(48) NULL DEFAULT '',
			  notes text,
			  PRIMARY KEY (address_id),
			  KEY customer_id (ref_id,type)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
		  TABLE_CONTACTS => "CREATE TABLE " . TABLE_CONTACTS . " (
			  id int(11) NOT NULL auto_increment,
			  type char(1) NOT NULL default 'c',
			  short_name varchar(32) NOT NULL default '',
			  inactive enum('0','1') NOT NULL default '0',
			  contact_first varchar(32) default NULL,
			  contact_middle varchar(32) default NULL,
			  contact_last varchar(32) default NULL,
			  store_id varchar(15) NOT NULL default '',
			  gl_type_account varchar(15) NOT NULL default '',
			  gov_id_number varchar(16) NOT NULL default '',
			  dept_rep_id varchar(16) NOT NULL default '',
			  account_number varchar(16) NOT NULL default '',
			  special_terms varchar(32) NOT NULL default '0',
			  price_sheet varchar(32) default NULL,
	          tax_id INT(11) default '-1',
	          attachments text,
			  first_date date NOT NULL default '0000-00-00',
			  last_update date default NULL,
			  last_date_1 date default NULL,
			  last_date_2 date default NULL,
			  PRIMARY KEY (id),
			  KEY type (type),
			  KEY short_name (short_name)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
		  TABLE_CONTACTS_LOG => "CREATE TABLE " . TABLE_CONTACTS_LOG . " (
			  log_id int(11) NOT NULL auto_increment,
			  contact_id int(11) NOT NULL default '0',
			  entered_by int(11) NOT NULL default '0',
			  log_date datetime NOT NULL default '0000-00-00',
			  action varchar(32) NOT NULL default '',
			  notes text,
			  PRIMARY KEY (log_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
		  TABLE_DEPARTMENTS => "CREATE TABLE " . TABLE_DEPARTMENTS . " (
			  id int(11) NOT NULL auto_increment,
			  description_short varchar(30) NOT NULL default '',
			  description varchar(30) NOT NULL default '',
			  subdepartment enum('0','1') NOT NULL default '0',
			  primary_dept_id int(11) NOT NULL default '0',
			  department_type tinyint(4) NOT NULL default '0',
			  department_inactive enum('0','1') NOT NULL default '0',
			  PRIMARY KEY (id),
			  KEY type (department_type)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
		  TABLE_DEPT_TYPES => "CREATE TABLE " . TABLE_DEPT_TYPES . " (
			  id int(11) NOT NULL auto_increment,
			  description varchar(30) NOT NULL default '',
			  PRIMARY KEY (id)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
		  TABLE_PROJECTS_COSTS => "CREATE TABLE " . TABLE_PROJECTS_COSTS . " (
			  cost_id int(8) NOT NULL auto_increment,
			  description_short varchar(16) collate utf8_unicode_ci NOT NULL default '',
			  description_long varchar(64) collate utf8_unicode_ci NOT NULL default '',
			  cost_type varchar(3) collate utf8_unicode_ci default NULL,
			  inactive enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
			  PRIMARY KEY (cost_id),
			  KEY description_short (description_short)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
		  TABLE_PROJECTS_PHASES => "CREATE TABLE " . TABLE_PROJECTS_PHASES . " (
			  phase_id int(8) NOT NULL auto_increment,
			  description_short varchar(16) collate utf8_unicode_ci NOT NULL default '',
			  description_long varchar(64) collate utf8_unicode_ci NOT NULL default '',
			  cost_type varchar(3) collate utf8_unicode_ci default NULL,
			  cost_breakdown enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
			  inactive enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
			  PRIMARY KEY (phase_id),
			  KEY description_short (description_short)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
	    );
		$this->mainmenu["customers"] = array(
				'order' 		=> MENU_HEADING_CUSTOMERS_ORDER,
				'text' 			=> TEXT_CUSTOMERS,
				'security_id'	=> '',
				'link' 			=> html_href_link(FILENAME_DEFAULT, 'module=phreedom&amp;page=main&amp;mID=cat_ar', 'SSL'),
				'params'      	=> '',
		);
		$this->mainmenu["vendors"] = array(
				'order' 		=> MENU_HEADING_VENDORS_ORDER,
				'text' 			=> TEXT_VENDORS,
				'security_id' 	=> '',
				'link' 			=> html_href_link(FILENAME_DEFAULT, 'module=phreedom&amp;page=main&amp;mID=cat_ap', 'SSL'),
				'params'      	=> '',
		);
		$this->mainmenu["employees"] = array(
				'order' 		=> MENU_HEADING_EMPLOYEES_ORDER,
				'text' 			=> TEXT_EMPLOYEES,
				'security_id'	=> '',
				'link' 			=> html_href_link(FILENAME_DEFAULT, 'module=phreedom&amp;page=main&amp;mID=cat_hr', 'SSL'),
				'params'      	=> '',
		);
		// Set the menus
		$this->mainmenu["customers"]['submenu']["contact"] = array(
				'order'		  => 10,
				'text'        => TEXT_CUSTOMERS,
				'link'        => '',//html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=c&amp;list=1', 'SSL'),
				'show_in_users_settings' => false,
				'params'      => '',
		);
		$this->mainmenu["customers"]['submenu']["contact"]['submenu']["new_customer"] = array(
				'text'        => sprintf(TEXT_NEW_ARGS, TEXT_CUSTOMER),
				'order'       => 5,
				'security_id' => SECURITY_ID_MAINTAIN_CUSTOMERS,
				'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;action=new&amp;type=c', 'SSL'),
				'show_in_users_settings' => false,
				'params'	    => '',
		);
		$this->mainmenu["customers"]['submenu']["contact"]['submenu']["customer_mgr"] = array(
				'text'        => sprintf(TEXT_MANAGER_ARGS, TEXT_CUSTOMER),
				'order'       => 10,
				'security_id' => SECURITY_ID_MAINTAIN_CUSTOMERS,
				'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=c&amp;list=1', 'SSL'),
				'show_in_users_settings' => true,
				'params'	    => '',
		);
		$this->mainmenu["customers"]['submenu']["crm"] = array(
				'text'        => TEXT_PHREECRM,
				'order'       => 15,
				'link'        => '',//html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=i&amp;list=1', 'SSL'),
				'show_in_users_settings' => true,
				'params'	  => '',
		);
		$this->mainmenu["vendors"]['submenu']["contact"] = array(
				'order'		  => 10,
				'text'        => TEXT_VENDORS,
				'link'        => '',//html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=v&amp;list=1', 'SSL'),
				'show_in_users_settings' => false,
				'params'      => '',
		);
		$this->mainmenu["vendors"]['submenu']["contact"]['submenu']["new_vendor"] = array(
				'text'        => sprintf(TEXT_NEW_ARGS, TEXT_VENDOR),
				'order'       => 5,
				'security_id' => SECURITY_ID_MAINTAIN_VENDORS,
				'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;action=new&amp;type=v', 'SSL'),
				'show_in_users_settings' => false,
				'params'      => '',
		);
		$this->mainmenu["vendors"]['submenu']["contact"]['submenu']["vendor_mgr"] = array(
				'text'        => sprintf(TEXT_MANAGER_ARGS, TEXT_VENDOR),
				'order'       => 10,
				'security_id' => SECURITY_ID_MAINTAIN_VENDORS,
				'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=v&amp;list=1', 'SSL'),
				'show_in_users_settings' => true,
				'params'      => '',
		);
		$this->mainmenu["employees"]['submenu']["contact"] = array(
				'order'		  => 10,
				'text'        => TEXT_EMPLOYEES,
				'link'        => '',//html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=e&amp;list=1', 'SSL'),
				'show_in_users_settings' => false,
				'params'      => '',
		);
		$this->mainmenu["employees"]['submenu']["contact"]['submenu']["new_employee"] = array(
				'text'        => sprintf(TEXT_NEW_ARGS, TEXT_EMPLOYEE),
				'order'       => 5,
				'security_id' => SECURITY_ID_MAINTAIN_EMPLOYEES,
				'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;action=new&amp;type=e', 'SSL'),
				'show_in_users_settings' => false,
				'params'      => '',
		);
		$this->mainmenu["employees"]['submenu']["contact"]['submenu']["employee_mgr"] = array(
				'text'        => sprintf(TEXT_MANAGER_ARGS, TEXT_EMPLOYEE),
				'order'       => 10,
				'security_id' => SECURITY_ID_MAINTAIN_EMPLOYEES,
				'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=e&amp;list=1', 'SSL'),
				'show_in_users_settings' => true,
				'params'      => '',
		);
		if (defined('ENABLE_MULTI_BRANCH') && ENABLE_MULTI_BRANCH == true) { // don't show menu if multi-branch is disabled
			$this->mainmenu["company"]['submenu']["branches"] = array(
					'order'		  => 55,
					'text'        => TEXT_BRANCHES,
					'link'        => '',//html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=b&amp;list=1', 'SSL'),
					'show_in_users_settings' => false,
					'params'      => '',
			);
			$this->mainmenu["company"]['submenu']["branches"]['submenu']["new_branch"] = array(
					'text'        => sprintf(TEXT_NEW_ARGS, TEXT_BRANCH),
					'order'        => 55,
					'security_id' => SECURITY_ID_MAINTAIN_BRANCH,
					'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;action=new&amp;type=b', 'SSL'),
					'show_in_users_settings' => false,
					'params'      => '',
			);
			$this->mainmenu["company"]['submenu']["branches"]['submenu']["branch_mgr"] = array(
					'text'        => sprintf(TEXT_MANAGER_ARGS, TEXT_BRANCH),
					'order'       => 56,
					'security_id' => SECURITY_ID_MAINTAIN_BRANCH,
					'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=b&amp;list=1', 'SSL'),
					'show_in_users_settings' => true,
					'params'      => '',
			);
		} // end disable if not looking at branches
		$this->mainmenu["customers"]['submenu']['projects'] = array(
				'order'		  => 60,
				'text'        => TEXT_PROJECTS,
				'link'        => '',//html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=j&amp;list=1', 'SSL'),
				'show_in_users_settings' => false,
				'params'      => '',
		);
		$this->mainmenu["customers"]['submenu']['projects']['submenu']["new_project"] = array(
				'text'        => sprintf(TEXT_NEW_ARGS, TEXT_PROJECT),
				'order'       => 5,
				'security_id' => SECURITY_ID_MAINTAIN_PROJECTS,
				'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;action=new&amp;type=j', 'SSL'),
				'show_in_users_settings' => false,
				'params'      => '',
		);
		$this->mainmenu["customers"]['submenu']['projects']['submenu']["project_mgr"] = array(
				'text'        => sprintf(TEXT_MANAGER_ARGS, TEXT_PROJECT),
				'order'       => 10,
				'security_id' => SECURITY_ID_MAINTAIN_PROJECTS,
				'show_in_users_settings' => true,
				'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=main&amp;type=j&amp;list=1', 'SSL'),
				'params'      => '',
		);
		
		if (\core\classes\user::security_level(SECURITY_ID_CONFIGURATION) > 0){
			$this->mainmenu["company"]['submenu']["configuration"]['submenu']["contacts"] = array(
					'order'	      => sprintf(TEXT_MODULE_ARGS, TEXT_CONTACTS),
					'text'        => sprintf(TEXT_MODULE_ARGS, TEXT_CONTACTS),
					'security_id' => SECURITY_ID_CONFIGURATION,
					'link'        => html_href_link(FILENAME_DEFAULT, 'module=contacts&amp;page=admin', 'SSL'),
					'show_in_users_settings' => false,
					'params'      => '',
			);
		}
	    parent::__construct();
	}

	function install($path_my_files, $demo = false) {
	    global $admin;
	    parent::install($path_my_files, $demo);
		if (!db_field_exists(TABLE_CURRENT_STATUS, 'next_cust_id_num')) $admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " ADD next_cust_id_num VARCHAR( 16 ) NOT NULL DEFAULT 'C10000';");
		if (!db_field_exists(TABLE_CURRENT_STATUS, 'next_vend_id_num')) $admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " ADD next_vend_id_num VARCHAR( 16 ) NOT NULL DEFAULT 'V10000';");
		if (!db_field_exists(TABLE_CURRENT_STATUS, 'next_crm_id_num'))  $admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " ADD next_crm_id_num VARCHAR( 16 ) NOT NULL DEFAULT '10000';");
		require_once(DIR_FS_MODULES . 'phreedom/functions/phreedom.php');
		xtra_field_sync_list('contacts', TABLE_CONTACTS);
	}

  	function upgrade(\core\classes\basis &$basis) {
    	global $admin, $messageStack;
    	parent::upgrade($basis);
    	if (version_compare($this->status, '3.3', '<') ) {
	  		$admin->DataBase->query("ALTER TABLE " . TABLE_CONTACTS . " CHANGE short_name short_name VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ''");
		  	if (db_table_exists(DB_PREFIX . 'contacts_extra_fields')) {
		    	// first create a new tab
				if (!defined('SETUP_TITLE_EXTRA_FIELDS')) define('SETUP_TITLE_EXTRA_FIELDS','New Tab');
		    	$updateDB = $admin->DataBase->query("insert into " . TABLE_EXTRA_TABS . " set
			  	  module_id = 'contacts',
			  	  tab_name = '"    . SETUP_TITLE_EXTRA_FIELDS . "',
			  	  description = '" . SETUP_TITLE_EXTRA_FIELDS . "',
			  	  sort_order = '20'");
				$tab_id = db_insert_id();
		    	$result = $admin->DataBase->query("select * from " . DB_PREFIX . 'contacts_extra_fields');
		    	while (!$result->EOF) {
			  		$params = unserialize($result->fields['params']); // need to insert contact_type
			  		$params['contact_type'] = $result->fields['contact_type'];
		      		$updateDB = $admin->DataBase->query("insert into " . TABLE_EXTRA_FIELDS . " set
			    	  module_id = 'contacts',
			    	  tab_id = '"      . $tab_id . "',
			    	  entry_type = '"  . $result->fields['entry_type']  . "',
			    	  field_name = '"  . $result->fields['field_name']  . "',
			    	  description = '" . $result->fields['description'] . "',
			    	  params = '"      . serialize($params) . "'");
		      		$result->MoveNext();
		    	}
		    	$admin->DataBase->query("DROP TABLE " . DB_PREFIX . "contacts_extra_fields");
		  	}
		}
		if (version_compare($this->status, '3.5', '<') ) {
	  		if ( db_field_exists(TABLE_CURRENT_STATUS, 'next_cust_id_desc')) $admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " DROP next_cust_id_desc");
	  		if ( db_field_exists(TABLE_CURRENT_STATUS, 'next_vend_id_desc')) $admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " DROP next_vend_id_desc");
	  		if (!db_field_exists(TABLE_CONTACTS, 'attachments')) $admin->DataBase->query("ALTER TABLE " . TABLE_CONTACTS . " ADD attachments TEXT NOT NULL AFTER tax_id");
    	}
    	if (version_compare($this->status, '3.7', '<') ) {
      		if (!db_field_exists(TABLE_CONTACTS_LOG, 'entered_by')) $admin->DataBase->query("ALTER TABLE " . TABLE_CONTACTS_LOG . " ADD entered_by INT(11) NOT NULL DEFAULT '0' AFTER contact_id");
    	}
		if (!db_field_exists(TABLE_CURRENT_STATUS, 'next_crm_id_num')){
    		$result = $admin->DataBase->query("Select MAX(short_name + 1) AS new  FROM " . TABLE_CONTACTS . " WHERE TYPE = 'i'");
			$admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " ADD next_crm_id_num VARCHAR( 16 ) NOT NULL DEFAULT '{$result->fields['new']}';");
		}
		if (version_compare($this->status, '4.0', '<') ) { //updating dashboards to store the namespaces.
			$basis->DataBase->exec ("ALTER TABLE ".TABLE_CONTACTS." ADD class VARCHAR( 255 ) NOT NULL DEFAULT '' AFTER id");
			$sql = $basis->DataBase->prepare("SELECT * FROM ".TABLE_CONTACTS." WHERE class <> '' ");
			$sql->execute();
			while ($result = $sql->fetch(\PDO::FETCH_LAZY)){
				$temp = '\contacts\classes\type\\'.$result['class'];
				$cInfo = new $temp($result);
				$cInfo->save_contact();
			}
		}
		xtra_field_sync_list('contacts', TABLE_CONTACTS);
  	}

	function delete($path_my_files) {
	    global $admin;
	    parent::delete($path_my_files);
	    if (db_field_exists(TABLE_CURRENT_STATUS, 'next_cust_id_num'))  $admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " DROP next_cust_id_num");
		if (db_field_exists(TABLE_CURRENT_STATUS, 'next_cust_id_desc')) $admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " DROP next_cust_id_desc");
	    if (db_field_exists(TABLE_CURRENT_STATUS, 'next_vend_id_num'))  $admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " DROP next_vend_id_num");
		if (db_field_exists(TABLE_CURRENT_STATUS, 'next_vend_id_desc')) $admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " DROP next_vend_id_desc");
		if (db_field_exists(TABLE_CURRENT_STATUS, 'next_crm_id_desc')) $admin->DataBase->query("ALTER TABLE " . TABLE_CURRENT_STATUS . " DROP next_crm_id_desc");
		$admin->DataBase->query("delete from " . TABLE_EXTRA_FIELDS . " where module_id = 'contacts'");
		$admin->DataBase->query("delete from " . TABLE_EXTRA_TABS   . " where module_id = 'contacts'");
	}

	function load_reports() {
		$id = $this->add_report_heading(TEXT_CUSTOMERS,   'cust');
		$this->add_report_folder($id, TEXT_REPORTS,           'cust', 'fr');
		$id = $this->add_report_heading(TEXT_EMPLOYEES,   'hr');
		$this->add_report_folder($id, TEXT_REPORTS,           'hr',   'fr');
		$id = $this->add_report_heading(TEXT_VENDORS,     'vend');
		$this->add_report_folder($id, TEXT_REPORTS,           'vend', 'fr');
		parent::load_reports();
	}
	
	/**
	 * this function will load the contact manager page
	 */
	function LoadContactMgrPage(\core\classes\basis &$basis) {
		$criteria[] = "a.type = '{$type}m'";
		if (isset($basis->cInfo->search_text) && $basis->cInfo->search_text <> '') {
			$search_fields = array('a.primary_name', 'a.contact', 'a.telephone1', 'a.telephone2', 'a.address1',
					'a.address2', 'a.city_town', 'a.postal_code', 'c.short_name');
			// hook for inserting new search fields to the query criteria.
			if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
			$criteria[] = '(' . implode(" like '%{$basis->cInfo->search_text}%' or ", $search_fields) . " like '%{$basis->cInfo->search_text}%')";
		}
		if (!$_SESSION['f0']) $criteria[] = "(c.inactive = '0' or c.inactive = '')"; // inactive flag
		$search = (sizeof($criteria) > 0) ? (' where ' . implode(' and ', $criteria)) : '';
		$field_list = array('c.class','c.id', 'c.inactive', 'c.short_name', 'c.contact_first', 'c.contact_last',
				'a.telephone1', 'c.attachments', 'c.first_date', 'c.last_update', 'c.last_date_1', 'c.last_date_2',
				'a.primary_name', 'a.address1', 'a.city_town', 'a.state_province', 'a.postal_code');
		// hook to add new fields to the query return results
		if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);
		$query_raw = "SELECT SQL_CALC_FOUND_ROWS " . implode(', ', $field_list)  . "
			FROM " . TABLE_CONTACTS . " c LEFT JOIN " . TABLE_ADDRESS_BOOK . " a ON c.id = a.ref_id {$search} ORDER BY $disp_order";
		//$query_result = $admin->DataBase->query($query_raw, (MAX_DISPLAY_SEARCH_RESULTS * ($_REQUEST['list'] - 1)).", ".  MAX_DISPLAY_SEARCH_RESULTS);
		$sql = $basis->DataBase->prepare($query_raw);
		$sql->execute();
		while ($result = $sql->fetch(\PDO::FETCH_CLASS | \PDO::FETCH_CLASSTYPE)) {
			$basis->cInfo->contacts_list[] = $result;
		}
		$query_split  = new \core\classes\splitPageResults($_REQUEST['list'], '');
		history_save('contacts'.$type);
		$basis->module		= 'contacts';
		$basis->page		= 'main';
		$basis->template 	= 'template_main';
		switch ($type) {
			case 'b': $basis->page_title = sprintf(TEXT_MANAGER_ARGS, TEXT_BRANCH);		break;
			case 'c': $basis->page_title = sprintf(TEXT_MANAGER_ARGS, TEXT_CUSTOMER);	break;
			case 'e': $basis->page_title = sprintf(TEXT_MANAGER_ARGS, TEXT_EMPLOYEE);	break;
			case 'i': $basis->page_title = TEXT_PHREECRM; 								break;
			case 'j': $basis->page_title = sprintf(TEXT_MANAGER_ARGS, TEXT_PROJECT);	break;
			case 'v': $basis->page_title = sprintf(TEXT_MANAGER_ARGS, TEXT_VENDOR);		break;
		}
		
	}
	
	function load_demo() {
		global $admin;
		// Data for table `address_book`
		$admin->DataBase->query("TRUNCATE TABLE " . TABLE_ADDRESS_BOOK);
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (1, 1, 'vm', 'Obscure Video', '', '1354 Triple A Ave', '', 'Chatsworth', 'CA', '93245', 'USA', '800.345.5678', '', '', '', 'obsvid@obscurevideo.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (2, 2, 'cm', 'CompuHouse Computer Systems', '', '8086 Intel Ave', '', 'San jose', 'CA', '94354', 'USA', '800-555-1234', '', '', '', 'sales@compuhouse.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (3, 3, 'vm', 'Speedy Electronics, Inc.', '', '777 Lucky Street', 'Unit #2B', 'San Jose', 'CA', '92666', 'USA', '802-555-9876', '', '', '', 'custserv@speedyelec.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (4, 4, 'cm', 'Computer Repair Services', '', '12932 136th Ave.', 'Suite A', 'Denver', 'CO', '80021', 'USA', '303-555-5469', '', '', '', 'servive@comprepair.net', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (5, 5, 'vm', 'LCDisplays Corp.', '', '28973 Pixel Place', '', 'Los Angeles', 'CA', '90001', 'USA', '800-555-5548', '', '', '', 'cs@lcdisplays.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (6, 6, 'vm', 'Big Box Corp', '', '11 Square St', '', 'Longmont', 'CO', '80501', 'USA', '303-555-9652', '', '', '', 'big.box@yahoo.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (7, 7, 'cm', 'John Smith Jr.', '', '13546 Euclid Ave', '', 'Ontario', 'CA', '92775', 'USA', '818-555-1000', '', '', '', 'jsmith@aol.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (8, 8, 'cm', 'Jim Baker', '', '995 Maple Street', 'Unit #56', 'Northglenn', 'CO', '80234', 'USA', 'unlisted', '', '', '', 'jb@hotmail.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (9, 9, 'cm', 'Lisa Culver', '', '1005 Gillespie Dr', '', 'Boulder', 'CO', '80303', 'USA', '303-555-6677', '', '', '', 'lisa@myveryownemailaddress.net', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (10, 10, 'cm', 'Parts Locator LLC', '', '55 Sydney Hwy', '', 'Deerfield Beach', 'FL', '33445', 'USA', '215-555-0987', '', '', '', 'parts@partslocator.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (11, 11, 'vm', 'Accurate Input, LLC', '', '1111 Stuck Key Ave', '', 'Burbank', 'CA', '91505', 'USA', '800-555-1267', '', '818-555-5555', '', 'sales@accurate.com', 'www.AccurateInput.com', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (12, 12, 'vm', 'BackMeUp Systems, Inc', '', '1324 44th Ave.', '', 'New York', 'NY', '10019', 'USA', '212-555-9854', '', '', '', 'sales@backmeup.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (13, 13, 'vm', 'Closed Cases', 'Fernando', '23 Frontage Rd', '', 'New York', 'NY', '10019', 'USA', '888-555-6322', '800-555-5716', '', '', 'custserv@closedcases.net', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (14, 14, 'vm', 'MegaWatts Power Supplies', '', '11 Joules St.', '', 'Denver', 'CO', '80234', 'USA', '303-222-5617', '', '', '', 'help@hotmail.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (15, 15, 'vm', 'Slipped Disk Corp.', 'Accts. Receivable', '1234 Main St', 'Suite #1', 'La Verne', 'CA', '91750', 'USA', '714-555-0001', '', '', '', 'sales@slippedisks.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (16, 16, 'em', 'John Smith', '', '123 Birch Ave', 'Apt 12', 'Anytown', 'CO', '80234', 'USA', '303-555-3451', '', '', '', 'john@mycompany.com', '', '');");
		$admin->DataBase->query("INSERT INTO " . TABLE_ADDRESS_BOOK . " VALUES (17, 17, 'em', 'Mary Johnson', '', '6541 First St', '', 'Anytown', 'CO', '80234', 'USA', '303-555-7426', '', '', '', 'nary@mycomapny.com', '', '');");
		// Data for table `contacts`
		$admin->DataBase->query("TRUNCATE TABLE " . TABLE_CONTACTS);
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (1, 'v', 'Obscure Video', '0', '', '', '', '', '2000', '', '', '', '3:1:10:30:2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (2, 'c', 'CompuHouse', '0', '', '', '', '', '4000', '', '', '', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (3, 'v', 'Speedy Electronics', '0', '', '', '', '', '2000', '', '', '', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (4, 'c', 'Computer Repair', '0', '', '', '', '', '4000', '', '', '', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (5, 'v', 'LCDisplays', '0', '', '', '', '', '2000', '', '', '', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (6, 'v', 'Big Box', '0', '', '', '', '', '2000', '', '', '', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (7, 'c', 'Smith, John', '0', '', '', '', '', '4000', '', '', '', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (8, 'c', 'JimBaker', '0', '', '', '', '', '4000', '', '', '', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (9, 'c', 'Culver', '0', '', '', '', '', '4000', '', '', '', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (10, 'c', 'PartsLocator', '0', '', '', '', '', '4000', '', '', '', '3:0:10:30:2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (11, 'v', 'Accurate Input', '0', '', '', '', '', '2000', '', '', 'SK200706', '3:0:10:30:2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (12, 'v', 'BackMeUp', '0', '', '', '', '', '2000', '', '', '', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (13, 'v', 'Closed Cases', '0', '', '', '', '', '2000', '', '', '', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (14, 'v', 'MegaWatts', '0', '', '', '', '', '2000', '', '', 'MW20070301', '0::::2500.00', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (15, 'v', 'Slipped Disk', '0', '', '', '', '', '2000', '', '', '', '0::::2500.00', '', '', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (16, 'e', 'John', '0', 'John', '', 'Smith', '', 'b', '', 'Sales', '', '::::', '', '0', '', now(), NULL, NULL, NULL);");
		$admin->DataBase->query("INSERT INTO " . TABLE_CONTACTS . " (`id`, `type`, `short_name`, `inactive`, `contact_first`, `contact_middle`, `contact_last`, `store_id`, `gl_type_account`, `gov_id_number`, `dept_rep_id`, `account_number`, `special_terms`, `price_sheet`, `tax_id`, `attachments`, `first_date`, `last_update`, `last_date_1`, `last_date_2`) VALUES (17, 'e', 'Mary', '0', 'Mary', '', 'Johnson', '', 'e', '', 'Accounting', '', '::::', '', '0', '', now(), NULL, NULL, NULL);");
		// Data for table `departments`
		$admin->DataBase->query("TRUNCATE TABLE " . TABLE_DEPARTMENTS);
		$admin->DataBase->query("INSERT INTO " . TABLE_DEPARTMENTS . " VALUES ('1', 'Sales', 'Sales', '0', '', 2, '0');");
		$admin->DataBase->query("INSERT INTO " . TABLE_DEPARTMENTS . " VALUES ('2', 'Administration', 'Administration and Operations', '0', '', 1, '0');");
		$admin->DataBase->query("INSERT INTO " . TABLE_DEPARTMENTS . " VALUES ('3', 'Accounting', 'Accounting and Finance', '0', '', 1, '0');");
		$admin->DataBase->query("INSERT INTO " . TABLE_DEPARTMENTS . " VALUES ('4', 'Shipping', 'Shipping Operation', '0', '', 4, '0');");
		$admin->DataBase->query("INSERT INTO " . TABLE_DEPARTMENTS . " VALUES ('5', 'Warehouse', 'Materials Receiving', '0', '', 4, '0');");
		// Data for table `departments_types`
		$admin->DataBase->query("TRUNCATE TABLE " . TABLE_DEPT_TYPES);
		$admin->DataBase->query("INSERT INTO " . TABLE_DEPT_TYPES . " VALUES (1, 'Administration');");
		$admin->DataBase->query("INSERT INTO " . TABLE_DEPT_TYPES . " VALUES (2, 'Sales and Marketing');");
		$admin->DataBase->query("INSERT INTO " . TABLE_DEPT_TYPES . " VALUES (3, 'Manufacturing');");
		$admin->DataBase->query("INSERT INTO " . TABLE_DEPT_TYPES . " VALUES (4, 'Shipping & Receiving');");
		parent::load_demo();
	}
}
?>