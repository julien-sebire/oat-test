# oat-test

This project sets up a web service providing read-only a list of users.

It allows you to provide user data as different file format. As to now, it only support JSON and CSV files. 
Two sample files are provided as a first set of usable data.

See [Provide your data](#data) to see how to provide your own data.

See [API](#api) for the web service specification.

*Note:*
This repository is a test case for OAT dev team and should only be seen as a development process log.
See [Development notes](DEV_NOTES.md) to see the development details.

## Requirements

- PHP 7.1+
- Symfony 4.2+
- Apache or any other web server

## Installation

Since this is not in the packagist repositories (for obvious reasons), the installation just follow these steps :

- Clone this repo (git clone https://github.com/julix/oat-test.git) or download and unzip the [archive](https://github.com/julix/oat-test/archive/master.zip) to the directory of your choice on your server (e.g. /var/www/oat-test).
- Set up your vhost document root to the /public directory of the repository (e.g. /var/www/oat-test/public).
    See [Apache vhost examples](https://httpd.apache.org/docs/2.4/en/vhosts/examples.html) or [NginX vhost examples](https://www.nginx.com/resources/wiki/start/topics/examples/server_blocks/) for more information.
- Try and visit the service page in your web browser: <your vhost>/index.php/users. You should see a rather large Json string.

## <a name="data"></a>Provide your data

To provide your own data:

- Put your JSON or CSV file in the /_resources directory
- Reference it in the corresponding attribute in the /config/services.yaml:
    - json_source_file for JSON file (line 7)
    - csv_source_file for CSV file (line 8)
- In the same file, choose the corresponding data provider (line 50):
    - @app.json_provider for JSON file
    - @app.csv_provider for CSV file

## File format

### JSON format:

The JSON file must contain a array of objects, with the following fields :

### CSV format:

The CSV file must contain a user by line, with the following fields :

- login
- password
- title
- lastname
- firstname
- gender
- email
- picture
- address

## <a name="api"></a>API

Two endpoints are provided:

### User list

| Verb | URI         | Parameters | Type                 | Description                                                                                          |
|------|-------------|------------|----------------------|------------------------------------------------------------------------------------------------------|
| GET  | /users      |            |                      | Returns the whole user list                                                                          |
|      |             | limit      | Integer (default: 0) | Limits the number of results returned (0 means no limit)                                             |
|      |             | offset     | Integer (default: 0) | Index of the first result returned (beginning at 0)                                                  |
|      |             | name       | String               | Returns all users responding to the given name (searches in first name, last name, e-mail and login) |

### Examples:

    /users
    
Returns the whole user list.

    /users/?limit=10
    
Returns users at indexes 1 to 10.

    /users/?limit=10&offset=30
    
Returns users at indexes 31 to 40.

    /users/?name=doe
    
Returns all users having the string "doe" in their first name, last name, e-mail or login.
    

### User details

| Verb | URI         | Description                                                                            |
|------|-------------|----------------------------------------------------------------------------------------|
| GET  | /users/{id} | Returns the user with the given id or an error 404 when 0 or more than 1 user is found |

### Examples:

    /users/{johndoe}
    
Returns the user "johndoe" details.

