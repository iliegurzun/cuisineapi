# Cuisine API
## Install the application
- download the application
- run `composer install`
- run `php app/console server:run 0.0.0.0:8080 >/dev/null &`
- run the application in your browser by accessing 127.0.0.1:8080/app_dev.php
- in order to run the test suite run `php phpunit.phar --verbose --debug -c app/`
## Choice of web application framework
I chose Symfony2 as web application framework because it is a stable environment, it has a great comunity and a great documentation, it's free and it's not that hard to learn.
Laravel is also a microframework based on Symfony 2

And also, this is the framework I used for about 3 years :)
## Different API consumers usage
It is very simple to use. For instance, on web applications you can use AngularJS or other client-side javascript libraries and simply make an XMLHttpRequest to one of the exposed endpoints to get the desired data.


