<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * phpMyAdmin sample configuration, you can use it as base for
 * manual configuration. For easier setup you can use setup/
 *
 * All directives are explained in documentation in the doc/ folder
 * or at <http://docs.phpmyadmin.net/>.
 *
 * @package PhpMyAdmin
 */

/*
 * This is needed for cookie based authentication to encrypt password in
 * cookie
 */
$cfg['blowfish_secret'] = 'N3nfij93EJjn3f8d8nfj9dzZ'; /* YOU MUST FILL IN THIS FOR COOKIE AUTH! */

/*
 * Servers configuration
 */
$index = 0;

/*
 * Read MySQL service properties from _ENV['VCAP_SERVICES']
 */
$services = json_decode($_ENV['VCAP_SERVICES'], true);
print "Service Found:{$_ENV['VCAP_SERVICES']}";
//$service = $services['mysql-5.5'][0]; // pick the first service
print "Service Found:$services";
/*
 * Generating list of servers
 */

$service = array();
print "</br>Individual:</br>";

/*
 * Dummy
 */
$index++;
$cfg['Servers'][$index]['auth_type'] = 'cookie';
/* Server parameters */
$cfg['Servers'][$index]['host'] = '-- SELECT SERVICE --';
print "</br>HostName {$cfg['Servers'][$index]['host']}";

$cfg['Servers'][$index]['port'] = '0';
print "</br>Port: {$cfg['Servers'][$index]['port']}";

$cfg['Servers'][$index]['connect_type'] = ':';
print "</br>Connection Type: {$cfg['Servers'][$index]['connect_type']} ";

$cfg['Servers'][$index]['compress'] = false;
print "</br>Compress Mode: {$cfg['Servers'][$index]['compress']}";

/* Select mysql if your server does not have mysqli */
$cfg['Servers'][$index]['extension'] = ':';
print "</br>Extension: {$cfg['Servers'][$index]['extension']}";
$cfg['Servers'][$index]['AllowNoPassword'] = false;
print "</br>Password: {$cfg['Servers'][$index]['AllowNoPassword']}";

foreach ($services as $k=>$v){
	print "</br>:X:{$v[0]['label']}:</br>"; // etc.
	
	$size = count($cfg);
	print "</br>Before:Configuration size:$size:Index:$index";

	$service = $services[$v[0]['label']][0];
	//$v[0]['label'] ==>service name details;
	$index++;
	$cfg['Servers'][$index]['auth_type'] = 'cookie';
	/* Server parameters */
	$cfg['Servers'][$index]['host'] = $service['credentials']['hostname'];
	print "</br>HostName {$cfg['Servers'][$index]['host']}";

	$cfg['Servers'][$index]['port'] = $service['credentials']['port'];
	print "</br>Port: {$cfg['Servers'][$index]['port']}";

	$cfg['Servers'][$index]['connect_type'] = 'tcp';
	print "</br>Connection Type: {$cfg['Servers'][$index]['connect_type']} ";

	$cfg['Servers'][$index]['compress'] = false;
	print "</br>Compress Mode: {$cfg['Servers'][$index]['compress']}";

	/* Select mysql if your server does not have mysqli */
	$cfg['Servers'][$index]['extension'] = 'mysqli';
	print "</br>Extension: {$cfg['Servers'][$index]['extension']}";
	$cfg['Servers'][$index]['AllowNoPassword'] = false;
	print "</br>Password: {$cfg['Servers'][$index]['AllowNoPassword']}";
}



/*
 * Read MySQL service properties from _ENV['VCAP_SERVICES']
 */
$services = json_decode($_ENV['VCAP_SERVICES'], true);
$service = $services['cleardb'][0]; // pick the first service

$size = count($cfg);
print "</br>After-Configuration size:$size</br>";

/*
 * phpMyAdmin configuration storage settings.
 */

/*
 * Read application configuration, get uri
 */
$appCfg = json_decode($_ENV['VCAP_APPLICATION'], true);
$scheme = ($_SERVER['HTTPS'] != '') ? 'https' : 'http';
$cfg['PmaAbsoluteUri'] = $scheme . '://' . $appCfg['uris'][0] . "/";

$cfg['LoginCookieValidity'] = 1800;

/* User used to manipulate with storage */
// $cfg['Servers'][$i]['controlhost'] = '';
// $cfg['Servers'][$i]['controlport'] = '';
// $cfg['Servers'][$i]['controluser'] = 'pma';
// $cfg['Servers'][$i]['controlpass'] = 'pmapass';

/* Storage database and tables */
// $cfg['Servers'][$i]['pmadb'] = 'phpmyadmin';
// $cfg['Servers'][$i]['bookmarktable'] = 'pma__bookmark';
// $cfg['Servers'][$i]['relation'] = 'pma__relation';
// $cfg['Servers'][$i]['table_info'] = 'pma__table_info';
// $cfg['Servers'][$i]['table_coords'] = 'pma__table_coords';
// $cfg['Servers'][$i]['pdf_pages'] = 'pma__pdf_pages';
// $cfg['Servers'][$i]['column_info'] = 'pma__column_info';
// $cfg['Servers'][$i]['history'] = 'pma__history';
// $cfg['Servers'][$i]['table_uiprefs'] = 'pma__table_uiprefs';
// $cfg['Servers'][$i]['tracking'] = 'pma__tracking';
// $cfg['Servers'][$i]['designer_coords'] = 'pma__designer_coords';
// $cfg['Servers'][$i]['userconfig'] = 'pma__userconfig';
// $cfg['Servers'][$i]['recent'] = 'pma__recent';
// $cfg['Servers'][$i]['users'] = 'pma__users';
// $cfg['Servers'][$i]['usergroups'] = 'pma__usergroups';
// $cfg['Servers'][$i]['navigationhiding'] = 'pma__navigationhiding';
/* Contrib / Swekey authentication */
// $cfg['Servers'][$i]['auth_swekey_config'] = '/etc/swekey-pma.conf';

/*
 * End of servers configuration
 */

/*
 * Directories for saving/loading files from server
 */
$cfg['UploadDir'] = $_ENV['TMPDIR'];
$cfg['SaveDir'] = $_ENV['TMPDIR'];

/**
 * Defines whether a user should be displayed a "show all (records)"
 * button in browse mode or not.
 * default = false
 */
//$cfg['ShowAll'] = true;

/**
 * Number of rows displayed when browsing a result set. If the result
 * set contains more rows, "Previous" and "Next".
 * default = 30
 */
//$cfg['MaxRows'] = 50;

/**
 * disallow editing of binary fields
 * valid values are:
 *   false    allow editing
 *   'blob'   allow editing except for BLOB fields
 *   'noblob' disallow editing except for BLOB fields
 *   'all'    disallow editing
 * default = blob
 */
//$cfg['ProtectBinary'] = 'false';

/**
 * Default language to use, if not browser-defined or user-defined
 * (you find all languages in the locale folder)
 * uncomment the desired line:
 * default = 'en'
 */
//$cfg['DefaultLang'] = 'en';
//$cfg['DefaultLang'] = 'de';

/**
 * default display direction (horizontal|vertical|horizontalflipped)
 */
//$cfg['DefaultDisplay'] = 'vertical';


/**
 * How many columns should be used for table display of a database?
 * (a value larger than 1 results in some information being hidden)
 * default = 1
 */
//$cfg['PropertiesNumColumns'] = 2;

/**
 * Set to true if you want DB-based query history.If false, this utilizes
 * JS-routines to display query history (lost by window close)
 *
 * This requires configuration storage enabled, see above.
 * default = false
 */
//$cfg['QueryHistoryDB'] = true;

/**
 * When using DB-based query history, how many entries should be kept?
 *
 * default = 25
 */
//$cfg['QueryHistoryMax'] = 100;

/**
 * Should error reporting be enabled for JavaScript errors
 *
 * default = 'ask' 
 */
//$cfg['SendErrorReports'] = 'ask';

/*
 * You can find more configuration options in the documentation
 * in the doc/ folder or at <http://docs.phpmyadmin.net/>.
 */

?>
