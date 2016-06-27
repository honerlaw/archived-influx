# influx

A simple pure PHP 7 web server.

This is no longer being worked on or maintained. The idea was to get minimal experience working with pthreads on windows and linux as well as working with php sockets on both windows and linux using pure php.

### How to run the server
1. Make sure you are using the thread safe version of PHP 7+
2. Make sure pthreads is installed
3. Make sure sockets are enabled (add `php_sockets` extension to `php.ini`)
4. `cd` to the root directory of the project and run `php init.php` to start the server


### How to run tests
1. Make sure you are using the thread safe version of PHP 7+
2. Make sure pthreads is installed
3. Make sure sockets are enabled (add `php_sockets` extension to `php.ini`)
4. `cd` to the tests directory of the project and run `php phpunit.phar`
