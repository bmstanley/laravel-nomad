# laravel-nomad

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.txt)
[![Total Downloads][ico-downloads]][link-downloads]

This Laravel package provides additional functionality for the Illuminate Database migrations. Currently the only additional functionality is the ability to specify custom database field types, but new functionality can be added as requested/submitted.

## Supported Versions

5.5

## Install

Via Composer

``` bash
$ composer require bmstanley/laravel-nomad
```

For Laravel 5.5 and newer, no configuration is needed. The package will be auto-discovered.

## Usage

#### Custom Field Types
Laravel's migrations provide methods for a wide base of the standard field types used in the supported databases, however it is not an exhaustive list. Additionally, some databases have extensions that can be enabled that add new field types. Unfortunately, one cannot create fields with these new data types using built-in migration methods.

As an example, PostgreSQL has a "citext" module to allow easy case-insensitive matching. This module adds a new "citext" field data type for storing case-insensitive string data. The built-in migration methods do not have a way to create a "citext" field, so one would have to add a direct "ALTER" statement to run after the table is created.

This package adds a new `passthru` method to allow defining custom data types in the migration. The `passthru` method can be used to add a field with any data type, as the specified type is merely passed through to the schema grammar.

The `passthru` method requires two parameters: the data type and the field name. An optional third parameter can be used to specify the actual data type definition, if needed. The `definition` method can also be chained on to specify the actual data type definition. A usage example is shown below:

``` php
class CreateUsersTable extends Migration {
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->passthru('citext', 'name');
            $table->passthru('citext', 'title')->nullable();
            $table->passthru('string', 'email', 'varchar(255)')->unique();
            $table->passthru('string', 'password')->definition('varchar(60)');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
}
```

## Contributing

Contributions are very welcome. Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email patrick@shiftonelabs.com instead of using the issue tracker.

## Credits

- [Patrick Carlo-Hickman][link-author]
- [Brian Stanley][link-author-2]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.txt) for more information.

[ico-version]: https://img.shields.io/packagist/v/bmstanley/laravel-nomad.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/bmstanley/laravel-nomad.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/bmstanley/laravel-nomad
[link-downloads]: https://packagist.org/packages/bmstanley/laravel-nomad
[link-author]: https://github.com/patrickcarlohickman
[link-author-2]: https://github.com/bmstanley
[link-contributors]: ../../contributors