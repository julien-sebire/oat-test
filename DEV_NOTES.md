# Notes about the test

## Development environment

Created and tested on the following LAMP stack versions:

- debian 9.5
- apache 2.4.25
- php 7.2.11
- MariaDB 10.1.26

IDE : Phpstorm

## Development process

- Created github repository http://github.com/julix/oat-test.
- Created local vhost.
- Initialized git repository.
- Installed latest symfony4 skeleton.
- Prepared client for local server at https://hr.oat.taocloud.org/client/
    - User list: http://dev.oat-test.com/index.php/users?limit={{limit}}&offset={{offset}}&name={{filter}}
    - User: http://dev.oat-test.com/index.php/users/{{user}}
- Added sample test takers files.
- Installed phpunit test framework.
