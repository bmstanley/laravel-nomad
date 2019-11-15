<?php

namespace Bmstanley\LaravelNomad\Tests;

class ConnectionTest extends TestCase
{

    public function testMysqlConnectionIsOverridden()
    {
        $conn = $this->makeConnection('mysql');

        $this->assertInstanceOf('Bmstanley\LaravelNomad\Extension\Database\MySqlConnection', $conn);
    }

    public function testPgsqlConnectionIsOverridden()
    {
        $conn = $this->makeConnection('pgsql');

        $this->assertInstanceOf('Bmstanley\LaravelNomad\Extension\Database\PostgresConnection', $conn);
    }

    public function testSqliteConnectionIsOverridden()
    {
        $conn = $this->makeConnection('sqlite');

        $this->assertInstanceOf('Bmstanley\LaravelNomad\Extension\Database\SQLiteConnection', $conn);
    }

    public function testSqlsrvConnectionIsOverridden()
    {
        $conn = $this->makeConnection('sqlsrv');

        $this->assertInstanceOf('Bmstanley\LaravelNomad\Extension\Database\SqlServerConnection', $conn);
    }
}
