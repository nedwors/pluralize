<?php

namespace Nedwors\Pluralize\Utilities;

use Illuminate\Support\Str;

class Parser
{
    protected $regexPattern = "/(\S+)\|(\S+)/i";
    protected $string;
    protected $count;

    public function run($string, $count)
    {
        $this->string = $string;
        $this->count = $count;

        return $this->parse();
    }

    protected function parse()
    {
        $matches = $this->findMatches();

        return $matches ? $this->modifyString($matches) : $this->string;
    }

    protected function modifyString($matches)
    {
        return collect($this->pairReplacementsWithMatches($matches))
                ->reduce(fn ($carry, $item) => $this->replaceValue($carry, $item), $this->string);
    }

    protected function pairReplacementsWithMatches($matches)
    {
        return collect($matches)
                ->map(fn ($match) => Str::replaceFirst('|', '\|', $match))
                ->zip($this->getReplacements($matches));
    }

    protected function getReplacements($matches)
    {
        return collect($matches)->map(fn ($match) => $this->getCorrectSegmentOfStringForCount($match));
    }

    protected function getCorrectSegmentOfStringForCount($string)
    {
        return $this->countIsSingular() ? Str::before($string, '|') : Str::after($string, '|');
    }

    protected function countIsSingular(): bool
    {
        return $this->count == 1 || $this->count == -1;
    }

    protected function replaceValue($string, $item)
    {
        return preg_replace('/'.$item[0].'/', $item[1], $string);
    }

    protected function findMatches()
    {
        preg_match_all($this->regexPattern, $this->string, $matches);

        return $matches[0];
    }
}
