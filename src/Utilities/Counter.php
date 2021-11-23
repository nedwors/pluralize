<?php

namespace Nedwors\Pluralize\Utilities;

class Counter
{
    public $count = null;

    public function calculate($countable)
    {
        $this->count = $this->count($countable);
    }

    protected function count($countable)
    {
        if (is_numeric($countable)) {
            return $countable;
        }

        if (is_countable($countable)) {
            return count($countable);
        }
    }
}
