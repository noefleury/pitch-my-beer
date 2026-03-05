<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Throwable;

/**
 * A simple Table component
 *
 * Example:
 *
 * <x-table :headers="['#', 'name', 'date']" :rows="$data"></x-table>
 *
 * @see     \Tests\Feature\View\Components\TableTest
 * @see     \Tests\Unit\View\Components\TableTest
 */
class Table extends Component
{
    /**
     * Create a new component instance.
     * @throws Throwable
     */
    public function __construct(
        public readonly array $headers,
        public readonly array $rows,
    ) {
        $this->ensureValid();
    }

    /**
     * Ensure table headers size and rows size are matching
     * @throws Throwable
     */
    private function ensureValid(): void
    {
        $headersCount = count($this->headers);
        foreach ($this->rows as $row) {
            throw_if(
                count($row) !== $headersCount,
                'Component error. Table headers size mismatch with rows size',
            );
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
