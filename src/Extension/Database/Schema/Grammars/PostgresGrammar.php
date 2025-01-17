<?php

namespace Bmstanley\LaravelNomad\Extension\Database\Schema\Grammars;

use Bmstanley\LaravelNomad\Traits\Database\Schema\Grammars\PassthruTrait;
use Illuminate\Database\Schema\Grammars\PostgresGrammar as BasePostgresGrammar;

class PostgresGrammar extends BasePostgresGrammar
{
    use PassthruTrait;
}
