# Notes about the test

## Development environment

Created and tested on the following LAMP stack versions:

- debian 9.5
- apache 2.4.25
- php 7.2.11
- MariaDB 10.1.26

IDE : Phpstorm

## Development process

### Step 1: a first working webservice, responding to the online client in my local browser.

- Created github repository http://github.com/julix/oat-test.
- Created local vhost.
- Initialized git repository.
- Installed latest symfony4 skeleton.
- Prepared client for local server at https://hr.oat.taocloud.org/client/
    - User list: http://dev.oat-test.com/index.php/users?limit={{limit}}&offset={{offset}}&name={{filter}}
    - User: http://dev.oat-test.com/index.php/users/{{user}}
- Added sample test takers files.
- Installed phpunit test framework.
- Created routes + controllers for the two endpoints (GET method).
- Added first test just to ensure the controllers respond (empty JSON array).
- Activated SSL on my default apache vhost since the online client calls the webservice as https.
- Fixed CORS problem to access my local url from https://hr.oat.taocloud.org/client/
- Changed client configuration:
    - User list: https://127.0.0.1/oat-test/public/index.php/users?limit={{limit}}&offset={{offset}}&name={{filter}}
    - User: https://127.0.0.1/oat-test/public/index.php/users/{{user}}
- Added a dummy user to test the user details

Note: a Rest Api should return Http code 404 when no corresponding data is found.
However, the online client doesn't seem to deal with that for the user list, so I simply returned an empty Json ([]) to avoid error popup window.
The user detail call deals with it.
Didn't find any specification on this.

