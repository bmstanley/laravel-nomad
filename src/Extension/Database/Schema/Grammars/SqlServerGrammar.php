<?php

namespace Bmstanley\LaravelNomad\Extension\Database\Schema\Grammars;

use Bmstanley\LaravelNomad\Traits\Database\Schema\Grammars\PassthruTrait;
use Illuminate\Database\Schema\Grammars\SqlServerGrammar as BaseSqlServerGrammar;

class SqlServerGrammar extends BaseSqlServerGrammar
{
    use PassthruTrait;
}
