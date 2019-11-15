<?php

namespace Bmstanley\LaravelNomad\Extension\Database\Schema\Grammars;

use Illuminate\Database\Schema\Grammars\SQLiteGrammar as BaseSQLiteGrammar;
use Bmstanley\LaravelNomad\Traits\Database\Schema\Grammars\PassthruTrait;

class SQLiteGrammar extends BaseSQLiteGrammar
{
    use PassthruTrait;
}
