<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use Paxx\Withings\Entity\Measure;

class MeasureCollection extends Collection
{
    /**
     * @param array $entries
     * @param callable $entryToMeasureCallback
     */
    public function __construct(array $entries = array(), callable $entryToMeasureCallback)
    {
        parent::__construct();
        foreach ($entries as $entryKey => $entryValue) {
            $formattedEntry = $entryToMeasureCallback($entryKey, $entryValue);
            if ($formattedEntry)
            {
                $this->put($formattedEntry['code'], Measure::fromArray(
                    $formattedEntry
                ));
            }
        }
    }
}
