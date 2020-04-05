## COVID-19 API

Lumen based API for the data from [CSSEGISandData/COVID-19](https://github.com/CSSEGISandData/COVID-19)

API available to use at [https://covid19.wistrix.dev](https://covid19.wistrix.dev)

### Installation

1. Run [composer](https://getcomposer.org/doc/00-intro.md)

    ```
    composer install
    ```

2. WAMP, LAMP, MAMP, XAMP Server

    If you are using any of WAMP, LAMP, MAMP, XAMP Servers, then don't forget to create a database.

3. Configure the ```.env``` file
    
    Rename ```.env.example``` file to ```.env```, set your application key to a random string with 32 characters long, edit database name, database username, and database password if needed.

4. Migrate database tables
    
    ```
    php artisan migrate
    ```
5. Fetch and import data

    ```
    php artisan covid19:fetch
    php artisan covid19:countries
    php artisan covid19:timeseries
    ```
6. Set permissions

    ```
    sudo chown -R www-data:www-data /path-to-your-project
    sudo find /path-to-your-project -type d -exec chmod 755 {} \;
    sudo find /path-to-your-project -type f -exec chmod 664 {} \;
    ```
    Note: The web server user is normally ```www-data``` but adjust this if needed.
    
6. Setup scheduler
    
    Add the following cron entry to your server.
    ```
    * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
    ```
    Note: You can adjust the commands frequency by updating the ```app/Console/Kernel.php``` file.
    
### Endpoints

#### GET /countries

Get all the countries.

**Response**

```JSON
{
  "data": [
    {
      "id": 123,
      "name": "ABC",
      "code": "ABC",
      "latitude": 1.000000,
      "longitude": -1.000000
    }
  ]
}
```

#### GET /countries/{id}

Get a country resource.

**Response**

```JSON
{
  "data": {
    "id": 123,
    "name": "ABC",
    "code": "ABC",
    "latitude": 1.000000,
    "longitude": -1.000000
  }
}
```

#### GET /countries/{id}/timeseries

Get all the timeseries data for a country.

**Response**

```JSON
{
  "data": [
    {
      "id": 123,
      "country_id": 123,
      "date": "YYYY-MM-DD",
      "confirmed": 123,
      "deaths": 123,
      "recovered": 123
    }
  ]
}
```

#### GET /countries/{id}/latest

Get the latest timeseries data for a country.

**Response**

```JSON
{
  "data": {
    "id": 123,
    "country_id": 123,
    "date": "YYYY-MM-DD",
    "confirmed": 123,
    "deaths": 123,
    "recovered": 123
  }
}
```

#### GET /timeseries

Get all the timeseries data.

**Response**

```JSON
{
  "data": [
    {
      "id": 123,
      "country_id": 123,
      "date": "YYYY-MM-DD",
      "confirmed": 123,
      "deaths": 123,
      "recovered": 123
    }
  ]
}
```

#### GET /timeseries/latest

Get the latest timeseries data.

**Response**

```JSON
{
  "data": [
    {
      "id": 123,
      "country_id": 123,
      "date": "YYYY-MM-DD",
      "confirmed": 123,
      "deaths": 123,
      "recovered": 123
    }
  ]
}
```

### Commands

Fetch the CSSEGISandData data.
```
php artisan covid19:fetch
```

Import the countries data.
```
php artisan covid19:countries
```

Import the time series data.
```
php artisan covid19:timeseries
```

### Credits

Johns Hopkins - [CSSEGISandData/COVID-19](https://github.com/CSSEGISandData/COVID-19)
