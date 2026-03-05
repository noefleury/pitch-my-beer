<?php

namespace Tests\Unit\View\Components;

use App\View\Components\Table;
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

}
