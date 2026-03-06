<?php

namespace Tests\Unit\View\Components;

use App\View\Components\Table;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * @see Table
 */
class TableTest extends TestCase
{

    /**
     * @throws Throwable
     */
    public function test_that_table_check_headers_and_rows_match(): void
    {
        $this->expectExceptionMessage('Component error. Table headers size mismatch with rows size');

        new Table(['id', 'name', 'year'], [[1, 'dummy', 2026], [2, 'no year column']]);
    }

    /**
     * @throws Throwable
     */
    public function test_that_table_check_trusted_vars_exists_in_headers(): void
    {
        $this->expectExceptionMessage('Component error. Table trusted columns contain unexisting header');

        new Table(['id', 'name', 'year'], [[1, 'dummy', 2026]], ['link']);
    }

    public function test_build_table_rows()
    {
        $collection = collect([
            (object)['id' => 123, 'name' => 'dummy', 'date' => Carbon::parse('2026-03-06 18:12')],
            (object)['id' => 124, 'name' => 'another dummy', 'date' => Carbon::parse('2026-03-06 18:13')],
        ]);

        $rows = Table::buildTableRows(
            $collection,
            [
                'id',
                'name',
                fn(object $object) => $object->date->format('H:i'),
            ]
        );

        $this->assertSame([
            [123, 'dummy', '18:12'],
            [124, 'another dummy', '18:13'],
        ], $rows);
    }

    public function test_build_table_rows_when_unhandled_attribute_type()
    {
        $collection = collect([
            (object)['id' => 123],
        ]);

        $this->expectExceptionMessage('Component error. Tried to build table rows with un-handled attribute type');

        Table::buildTableRows(
            $collection,
            [
                555, // integer
            ]
        );
    }

}
