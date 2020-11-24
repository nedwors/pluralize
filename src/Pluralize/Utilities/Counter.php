<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class Counter
{
    public function calculate($countable)
    {
        return $this->count($countable);
    }

    protected function count($countable)
    {
        if (is_integer($countable)) {
            return $countable;
        }

        if (is_array($countable)) {
            return count($countable);
        }

        if ($countable instanceof Collection) {
            return $countable->count();
        }

        if ($countable instanceof LengthAwarePaginator) {
            return $countable->total();
        }

        if ($countable instanceof Paginator) {
            return count($countable->items());
        }
    }
}