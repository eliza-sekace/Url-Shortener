This is a simple URL shortener app, using few packages.
To run the app, first install dependencies using composer.

Run ```composer install```

The application uses database and one table is needed.

Table name: 'short_urls';

| Column     | Data type |
| ----------- | ----------- |
| id     | Primary key, INT       |
| long_url  | UNI, VARCHAR, 255        |
| short_code | UNI, VARCHAR, 11     |

The database configuration is in App\Database\Connection.
By default configuration:

|Parameter   | Value |
| ----------- | ----------- |
| dbname    | short_urls      |
| user | root       |
| host | localhost   |

To run app locally, execute: <br>
```php -S localhost:8000```


