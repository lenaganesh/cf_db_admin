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
$i = 0;

/*
 * Read MySQL service properties from _ENV['VCAP_SERVICES']
 */
 
$services = json_decode($_ENV['VCAP_SERVICES'], true);
print "Service Found:{$_ENV['VCAP_SERVICES']}";
print "</br>Individual:</br>$services</br>";
$result = count($services);
print "Services Found:$result</br>List of Variables:</br>";
//print_r ($services);
$i = 0;
print "</br>Individual:</br>";
foreach ($services as $k=>$v){
    print "$v[0]</br>"; // etc.
	print_r($v[0]); // etc.
	print ":X:{$v[0]['label']}:</br>"; // etc.
	$i++;
	populateServer($v[0]['label'],$services,$i);
	print ":Y:{$v['label']}:</br>"; // etc.
}
print "</br>Recursive</br>";
print_r($services);
//print "Services Found:$services['label']";
print "Services Found:$services[0][0]</br>";

print "label:$services[1]</br>";
var_dump($services);

function populateServer($serviceName,$services,$i) {
	$service = $services[$serviceName][0];
	 /* Authentication type */
	$cfg['Servers'][$i]['auth_type'] = 'cookie';
	/* Server parameters */
	$cfg['Servers'][$i]['host'] = $service['credentials']['hostname'];
	print "HostName {$cfg['Servers'][$i]['host']}";

	$cfg['Servers'][$i]['port'] = $service['credentials']['port'];
	print "Port: {$cfg['Servers'][$i]['port']}";

	$cfg['Servers'][$i]['connect_type'] = 'tcp';
	print "Type: {$cfg['Servers'][$i]['connect_type']} ";

	$cfg['Servers'][$i]['compress'] = false;
	print "cfg: {$cfg['Servers'][$i]['compress']}";

	/* Select mysql if your server does not have mysqli */
	$cfg['Servers'][$i]['extension'] = 'mysqli';
	$cfg['Servers'][$i]['AllowNoPassword'] = false;
 }

?>