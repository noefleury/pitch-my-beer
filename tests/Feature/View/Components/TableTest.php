<?php

namespace Tests\Feature\View\Components;

use App\View\Components\Table;
use Tests\TestCase;
use Throwable;

/**
 * @see Table
 */
class TableTest extends TestCase
{


    /**
     * @throws Throwable
     */
    public function test_table_generation()
    {
        $headers = ['#', 'name', 'year'];
        $rows    = [[1, 'dummy', 2026], [2, 'another dummy', 2026]];

        $view = $this->blade(
            '<x-table :headers="$headers" :rows="$rows"></x-table>',
            ['headers' => $headers, 'rows' => $rows],
        );

        $view->assertSeeInOrder([
            '<th>#</th>',
            '<th>name</th>',
            '<th>year</th>',
        ],
            false);

        $view->assertSeeInOrder([
            '<td>1</td>',
            '<td>dummy</td>',
            '<td>2026</td>',
            '<td>2</td>',
            '<td>another dummy</td>',
            '<td>2026</td>',
        ], false);
    }

    public function test_table_generation_handle_trusted_columns()
    {
        $headers = ['#', 'name', 'link'];
        $rows    = [[1, '<button>injection</button>', '<button>go</button>']];
        $trusted = ['link'];

        $view = $this->blade(
            '<x-table :headers="$headers" :rows="$rows" :trusted="$trusted"></x-table>',
            ['headers' => $headers, 'rows' => $rows, 'trusted' => $trusted],
        );

        $view->assertSeeInOrder([
            '<th>#</th>',
            '<th>name</th>',
            '<th>link</th>',
        ],
            false);

        $view->assertSeeText('<button>injection</button>');
        $view->assertSee('<button>injection</button>');
        $view->assertDontSeeText('<button>go</button>');
        $view->assertSee('<button>go</button>', false);
    }

}
