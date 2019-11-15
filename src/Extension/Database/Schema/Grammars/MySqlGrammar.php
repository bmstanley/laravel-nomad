<?php

namespace Bmstanley\LaravelNomad\Extension\Database\Schema\Grammars;

use Illuminate\Database\Schema\Grammars\MySqlGrammar as BaseMySqlGrammar;
use Bmstanley\LaravelNomad\Traits\Database\Schema\Grammars\PassthruTrait;

class MySqlGrammar extends BaseMySqlGrammar
{
    use PassthruTrait;
}
