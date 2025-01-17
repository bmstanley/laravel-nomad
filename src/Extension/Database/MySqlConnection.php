<?php

namespace Bmstanley\LaravelNomad\Extension\Database;

use Illuminate\Database\MySqlConnection as BaseMySqlConnection;
use Bmstanley\LaravelNomad\Extension\Database\Schema\Blueprint;
use Bmstanley\LaravelNomad\Extension\Database\Schema\Grammars\MySqlGrammar as SchemaGrammar;

class MySqlConnection extends BaseMySqlConnection
{

    /**
     * Get the default schema grammar instance.
     *
     * @return \Bmstanley\LaravelNomad\Extension\Database\Schema\Grammars\MySqlGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar());
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\MySqlBuilder
     */
    public function getSchemaBuilder()
    {
        $parentBuilder = parent::getSchemaBuilder();

        // add a blueprint resolver closure that returns the custom blueprint
        $parentBuilder->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });

        return $parentBuilder;
    }
}
