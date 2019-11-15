<?php

namespace Bmstanley\LaravelNomad;

use LogicException;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class LaravelNomadServiceProvider extends ServiceProvider
{
    /**
     * The connection classes to use for the drivers.
     *
     * @var array
     */
    protected $classes = [
        'mysql' => 'Bmstanley\LaravelNomad\Extension\Database\MySqlConnection',
        'pgsql' => 'Bmstanley\LaravelNomad\Extension\Database\PostgresConnection',
        'sqlite' => 'Bmstanley\LaravelNomad\Extension\Database\SQLiteConnection',
        'sqlsrv' => 'Bmstanley\LaravelNomad\Extension\Database\SqlServerConnection',
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFeatureDetection();

        $this->registerConnections();
    }

    /**
     * Register the feature detection service.
     *
     * @return void
     */
    public function registerFeatureDetection()
    {
        $this->app->singleton('nomad.feature.detection', 'Bmstanley\LaravelNomad\FeatureDetection');
    }

    /**
     * Register the database connection extensions.
     *
     * @return void
     */
    public function registerConnections()
    {
        $driver = $this->app['nomad.feature.detection']->connectionResolverDriver();

        $method = 'registerVia'.studly_case($driver);

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        throw new LogicException(sprintf('Connection registration method [%s] does not exist.', $method));
    }

    /**
     * Register the database connection extensions through app bindings.
     *
     * @return void
     */
    public function registerViaBindings()
    {
        foreach ($this->classes as $driver => $class) {
            $this->app->bind('db.connection.'.$driver, $class);
        }
    }

    /**
     * Register the database connection extensions through the `Connection` method.
     *
     * @return void
     */
    public function registerViaConnectionMethod()
    {
        foreach ($this->classes as $driver => $class) {
            Connection::resolverFor($driver, function ($connection, $database, $prefix, $config) use ($class) {
                return new $class($connection, $database, $prefix, $config);
            });
        }
    }
}
