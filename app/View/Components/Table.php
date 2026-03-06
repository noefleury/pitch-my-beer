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
 * <x-table :headers="['#', 'name', 'link']" :rows="$data" :trusted="['link']"></x-table>
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
        public array $trusted = [],
    ) {
        $this->ensureValid();
        $this->mapTrustedColumnsToIndex();
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
     * This method will map trusted columns name to their index in the rows (using headers)
     * @return void
     * @throws Throwable
     */
    private function mapTrustedColumnsToIndex(): void
    {
        $this->trusted = array_map(fn($trusted) => array_search($trusted, $this->headers), $this->trusted);
        throw_if(
            in_array(false, $this->trusted),
            'Component error. Table trusted columns contain unexisting header',
        );
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
