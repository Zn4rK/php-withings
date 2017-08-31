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
    
    /**
     * List available measures
     *
     * @return Array
     */
    public function getAvailableMeasures()
    {
        return $this->keys();
    }
    
    /**
     * Retreive a measure by it's code ; $activity->getSteps() for example
     *
     * @return Measure
     */
    public function __get($name)
    {
        return $this->get($name);
    }
}
