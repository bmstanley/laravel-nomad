<?php

namespace ShiftOneLabs\LaravelNomad\Tests;

use ReflectionMethod;
use Illuminate\Database\Connection;
use Illuminate\Foundation\Application;
use Illuminate\Database\Schema\Builder;
use ShiftOneLabs\LaravelNomad\FeatureDetection;
use ShiftOneLabs\LaravelNomad\Tests\Stubs\PdoStub;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Schema\Blueprint as Blueprint;
use Illuminate\Database\Schema\Grammars\Grammar as Grammar;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        $app = new Application();

        $app['env'] = $env = 'testing';

        $app->bindInstallPaths(array(
            'app' => __DIR__ . '/../src',
            'base' => __DIR__ . '/..',
        ));

        $app->instance('app', $app);
        $app->instance('config', $config = new \Illuminate\Config\Repository($app->getConfigLoader(), $env));

        $app->register('\Illuminate\Database\DatabaseServiceProvider');
        $app->register('\ShiftOneLabs\LaravelNomad\LaravelNomadServiceProvider');

        $this->detection = $app['nomad.feature.detection'];

        return $app;
    }

    public function makeConnection($type)
    {
        if ($this->detection->isConnectionResolver(FeatureDetection::CONNECTION_RESOLVER_METHOD)) {
            return $this->app->make('Illuminate\Database\Connectors\ConnectionFactory')->make([
                'driver' => $type,
                'database' => 'database',
            ]);
        }

        return $this->app->make('db.connection.' . $type, [new PdoStub(), 'database']);
    }

    public function getNewBlueprint($table = 'table')
    {
        return new \ShiftOneLabs\LaravelNomad\Extension\Database\Schema\Blueprint($table);
    }

    public function getBuilderBlueprint(Builder $builder, $table = 'table')
    {
        return $this->callRestrictedMethod($builder, 'createBlueprint', array($table));
    }

    public function getColumnSql(Grammar $grammer, Blueprint $blueprint)
    {
        return $this->callRestrictedMethod($grammer, 'getColumns', array($blueprint));
    }

    public function callRestrictedMethod($object, $method, array $args = array())
    {
        $reflectionMethod = new ReflectionMethod($object, $method);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invokeArgs($object, $args);
    }
}
