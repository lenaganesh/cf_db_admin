##CloudFoundry/BlueMix support mode to find VCAP_SERVICES envriroment and listing to connect db connection
1. Clone the app (i.e. this repo) or download it with zip format

  ```$
  git clone https://github.com/lenaganesh/cf_db_admin
  cd cf_db_admin
  ```
  
1. If you dont have any service create it them through cf tool or through Cloud Service website
	```$
	cf create-service cleardb spark mysqldb
	```
1. Modify the manifest.yml for your project related information
	(1) - name: cfdbadmin 	==> Application Name which will be resist in your CloudFoundry/BlueMix service
	(2) host: cfdbadmin   	==> Portal name which will be used to access your PHPmyAdmin. Ensure that this one will not be used/registered by others
	(3)services:
		-mysqldb
							==> Service name which you want to bind/access the db through PHPmyAdmin

1. Check the VCAP_SERVICES service through the following command
	```$
	cf files <app-name> logs/env.log
	```
1. Push your current change to CloudFoundry. (Ensure already target to your application through "cf target api.xxxxx.xxxx.com")
	```$
	cf push
	```
1. Access your site the following with username and password of the service. You can get from VCAP_SERVICES environment variable
	http://cfdbadmin.bluemix.net/
	
### How It Works

When you push the application here's what happens.

1. The local bits are pushed to your target.  This is small, six files around 30k. It includes the changes we made and a build pack extension for PHPMyAdmin.
1. The server downloads the [PHP Build Pack] and runs it.  This installs HTTPD and PHP.
1. The build pack sees the extension that we pushed and runs it.  The extension downloads the stock PHPMyAdmin file from their server, unzips it and installs it into the `htdocs` directory.  It then copies the rest of the files that we pushed and replaces the default PHPMyAdmin files with them.  In this case, it's just the `config.inc.php` file.
1. At this point, the build pack is done and CF runs our droplet.point, the build pack is done and CF runs our droplet.

==============
###Troubleshoot:
==============
1. If service is not listing in the drop down. check the 
Check the source code :config.inc.php and result in browser
http://cfdbadmin.bluemix.net/config.inc.php



====================================================================
##FROM ORIGINAL PROJECT (Dont confuse with the following content)
====================================================================
### CloudFoundry PHP Example Application:  PHPMyAdmin

This is an example application which can be run on CloudFoundry using the [PHP Build Pack].

This is an out-of-the-box implementation of PHPMyAdmin 4.2.2.  It's an example how common PHP applications can easily be run on CloudFoundry.

### Usage

1. Clone the app (i.e. this repo).

  ```bash
  git clone https://github.com/dmikusa-pivotal/cf-ex-phpmyadmin
  cd cf-ex-phpmyadmin
  ```

1. If you don't have one already, create a MySQL service.  With Pivotal Web Services, the following command will create a free MySQL database through [ClearDb].

  ```bash
  cf create-service cleardb spark my-test-mysql-db
  ```

1. Edit the manifest.yml file.  Change the 'host' attribute to something unique.  Then under "services:" change "mysql-db" to the name of your MySQL service.  This is the name of the service that will be bound to your application and thus available to PHPMyAdmin.

1. Push it to CloudFoundry.

  ```bash
  cf push
  ```

  Access your application URL in the browser.  Login with the credentials for your service.  If you need to find these, just run this command and look for the VCAP_SERVICES environment variable.

  ```bash
  cf files <app-name> logs/env.log
  ```

### How It Works

When you push the application here's what happens.

1. The local bits are pushed to your target.  This is small, six files around 30k. It includes the changes we made and a build pack extension for PHPMyAdmin.
1. The server downloads the [PHP Build Pack] and runs it.  This installs HTTPD and PHP.
1. The build pack sees the extension that we pushed and runs it.  The extension downloads the stock PHPMyAdmin file from their server, unzips it and installs it into the `htdocs` directory.  It then copies the rest of the files that we pushed and replaces the default PHPMyAdmin files with them.  In this case, it's just the `config.inc.php` file.
1. At this point, the build pack is done and CF runs our droplet.

### Changes

These changes were made to prepare it to run on CloudFoundry:

1. Configure the database in `config.inc.php`.  This was done by reading the environment variable VCAP_SERVICES, which is populated by CloudFoundry and contains the connection information for our services, and configuring the host, port from it.  See this [link](https://github.com/dmikusa-pivotal/cf-ex-phpmyadmin/blob/master/htdocs/config.inc.php#L27) for the details.
2. Remove the setup directory, which is not needed.
3. Override the configuration file httpd-directories.conf and prevent access to the libraries directory.  See this [link](https://github.com/dmikusa-pivotal/cf-ex-phpmyadmin/blob/master/.bp-config/httpd/extra/httpd-directories.conf#L14) for the details.
4. Set the 'PmaAbsoluteUri' configuration option.  This is needed because the application is using the detected host and port, which are internal to CF, to generate in the URLs.  The links generated with the internal ip / port do not work and so we configure around that by grabbing the application's URL and port. Note that this would not work if multiple URL's were bound to the application.  [Link](https://github.com/dmikusa-pivotal/cf-ex-phpmyadmin/blob/master/htdocs/config.inc.php#L52)
5. Increasedd the timeout of the session by setting 'LoginCookieValidity' and 'session.gc_maxlifetime' to 1800.  Link to [change #1](https://github.com/dmikusa-pivotal/cf-ex-phpmyadmin/blob/master/htdocs/config.inc.php#L56) and [change #2](https://github.com/dmikusa-pivotal/cf-ex-phpmyadmin/blob/master/.bp-config/php/php.ini#L1443).

[PHP Build Pack]:https://github.com/dmikusa-pivotal/cf-php-build-pack
[ClearDb]:https://www.cleardb.com/
