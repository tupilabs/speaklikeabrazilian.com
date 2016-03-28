# Welcome!

We are very happy that you are thinking about contributing to Speak Like A Brazilian.

## Environment set up

### Database

If you are using sqlite for database, you have to:

1. `touch database/database.sqlite` this is your database file
2. In your .env file, set the following entries:

* DB_CONNECTION=sqlite

It can be convenient to install Aqua Datastudio or sqlite3, so that you can peek at the schema and
data if necessary.

### ElasticSearch

SLBR uses ElasticSearch for search, and shift31/laravel-elasticsearch to interface with the service
from Laravel. In your .env file, set the following entries:

* ES_SERVER=localhost:9200

Or if you are using the docker-compose set up

* ES_SERVER=elasticsearch:9200

## Development guideline

### Code standards

A few things to note before hacking the code.

* Parameters in views use the snake case pattern parameter_name
* Parameters in PHP use the camel case pattern parameterName
* Parameters never start in a capital letter
* Constants are always written in only capital letters