# Laravel DataTables Mongodb Plugin

Forked from pimlie/laravel-datatables-mongodb

For: jenssegers/laravel-mongodb + yajra/laravel-datatables-oracle ~9.x: Use `pimlie/laravel-datatables-mongodb`(https://github.com/pimlie/laravel-datatables-mongodb)

Support mongodb/laravel-mongodb^5.x + yajra/laravel-datatables-oracle ^12.x

## Documentation
- [Laravel DataTables Documentation](http://yajrabox.com/docs/laravel-datatables)

This plugin provides most functionalities described in the Laravel Datatables documentation. See `Known issues` below

## Installation
1. Add to composer.json:
{
    [...],
    "require": {
        [...],
        "pimlie/laravel-datatables-mongodb": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/skiddyvn/laravel-datatables-mongodb"
        }
    ]
}
2. Run composer update

## Configure
Add the service provide:

```
'providers' => [
    ...,
    Yajra\DataTables\DataTablesServiceProvider::class,
    Pimlie\DataTables\MongodbDataTablesServiceProvider::class, // add _after_ Yajra's ServiceProvider
]
```

__or__ open the `config/datatables.php` file and add the engines manually to the config:
```php
    /**
     * Datatables list of available engines.
     * This is where you can register your custom datatables engine.
     */
    'engines'        => [
        // The Jenssegers\Mongodb classes extend the default Query/Eloquent classes
        // thus the engines need to be listed above the default engines
        // to make sure they are tried first
        'moloquent'      => Pimlie\DataTables\MongodbDataTable::class,
        'mongodb-query'  => Pimlie\DataTables\MongodbQueryDataTable::class,
        'mongodb-hybrid' => Pimlie\DataTables\HybridMongodbQueryDataTable::class,

        'eloquent'       => Yajra\DataTables\EloquentDataTable::class,
        'query-builder'  => Yajra\DataTables\QueryDataTable::class,
        'collection'     => Yajra\DataTables\CollectionDataTable::class,
    ],

    /**
     * Datatables accepted builder to engine mapping.
     * This is where you can override which engine a builder should use
     * Note, only change this if you know what you are doing!
     */
    'builders'       => [
        //Jenssegers\Mongodb\Eloquent\Builder::class             => 'moloquent',
        //Jenssegers\Mongodb\Query\Builder::class                => 'mongodb-query',
        //Jenssegers\Mongodb\Helpers\EloquentBuilder::class      => 'eloquent',
        //Illuminate\Database\Eloquent\Relations\Relation::class => 'eloquent',
        //Illuminate\Database\Eloquent\Builder::class            => 'eloquent',
        //Illuminate\Database\Query\Builder::class               => 'query',
        //Illuminate\Support\Collection::class                   => 'collection',
    ],
```

## Usage

### Use the `datatables()` method

For this to work you need to have the class definitions added to the `engines` and `builders` datatables configuration, see above.

```php
use \App\MyMongodbModel;

$datatables = datatables(MyMongodbModel::all());

```

### Use the dataTable class directly.

```php
use Pimlie\DataTables\MongodbDataTable;

return (new MongodbDataTable(App\User::where('id', '>', 1))->toJson()
```

### Use via trait.
- Add the `MongodbDataTableTrait` trait to your model.

```php
use Jenssegers\Mongodb\Eloquent\Model;
use Pimlie\DataTables\Traits\MongodbDataTableTrait;

class User extends Model
{
	use MongodbDataTableTrait;
}
```

- Call dataTable() directly on your model.

```php
Route::get('users/data', function() {
	return User::dataTable()->toJson();
});
```

## Known issues

- the `orderColumn` and `orderColumns` methods are empty placeholders and do nothing
- there is currently no support for viewing/searching/ordering on (non-embedded) relationships between Models (eg through a `user.posts` column key)


