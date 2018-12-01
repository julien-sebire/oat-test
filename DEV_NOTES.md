# Notes about the test


## Development environment

Created and tested on the following LAMP stack versions:

- debian 9.5
- apache 2.4.25
- php 7.2.11
- MariaDB 10.1.26

IDE : Phpstorm


## Development schedule

To do this test in a realistic manner, I decided on the following schedule:

- day 1 (friday 30th): 8h
- day 2 (saturday 1st): 8h
- 8 hours break (night and meals)

I roughly ended with the following durations :

- day 1: 7.5 hours
    - 3:30pm to 7:30pm: 4 hours
    - lunch break and taking care of my daughter
    - 10:00pm to 1:30am: 3.5 hours
- 6.5 hours night
- day 2: 7.5 hours
    - 7:00am to 12:15pm: 5 hours
    - lunch break
    - 12:45pm to 11:15pm: 2.5 hours
- Total: 15 hours with small breaks every now and then.

## Development process


### Step 1: A first working webservice, responding to the online client in my local browser.

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


### Step 2: Business logic.

- Added a data object to hold user data. Only protected properties and trivial public accessors for now, so no test on User class.
- Moved the responsibility of query logic from controller to a user repository interface.
- Implemented UserRepository and User with array <-> object conversion with field mapping.
    - Changed result returned by userController with User object to array conversion.
    - this may seem overkill but will be useful when different data sources come to play. (not YAGNI, I know)
- Adding user selection (id, name) in User, and used them in UserRepository
    - Stopped on a breaking unit test, to be sure where to start again tomorrow - time to go to bed
    - Resumed UserRepository test implementation: now using User objects instead of arrays + moved the raw data to bottom of test class for readability sake.


### Step 3: Retrieving data.

- Used an object implementing DataProviderInterface to feed UserRepository with users.
- Created a first basic JsonProvider:
    - specify data source file
    - reads a json file
    - convert it to User objects
- Added dependency injection configuration
- Added a CsvProvider
    - factorized sourceFile code in a FileProvider
    - JsonProvider and CsvProvider only do the job of reading files into an array of users represented by associative arrays.
- Added dependency injection configuration for CsvProvider + one-line provider changer (services.yaml line 50)


### Step 4: Refining the client results

I noticed the following things in the client display:

- User details for some users return an error 500. Browser cache hid this problem from my eyes.
    
    => array_filter does not reorder array keys, array_values would solve it.

- Column headers in the grid reflect the field names in the Json.

    => Let's have prettier column names.

- The column used as Entity Id is not displayed and userId is not provided for the call to user details, redirecting to user list.

    => Added a userId field instead of login.
    => Configured userId as Entity Id in the client
    => I chose to keep the login still using the login value as primary key (could have used an arbitrary integer, but login should be deterministic so I kept login).

- Details fields for picture is fixed value "picture".
- User List should not display password and picture url (I guess).
- Details view shows login and userId.

    => Replaced User::toArray with User::getListArray and User::getDetailsArray to be able to provide different fields to the list and details view.

Went through all client functionality (search, navigation, details), working smoothly.

## To go further

Data access from database, such as mysql could be done in two ways:
    - a database access layer providing a full list of users to the UserRepository
    - Renaming UserRepository to a more specific name such as FileUserRepository and implementing a DatabseUserRepositoring to take advantage of all the requesting possibilities of chosen RDBM.
