<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use Paxx\Withings\Entity\Measure;

class MeasureCollection
{
    public $measures;
    
    /**
     * @param array $entries
     * @param callable $entryToMeasureCallback
     * @return MeasureCollection
     */
    public function __construct(array $entries = array(), callable $entryToMeasureCallback)
    {
        $this->measures = new Collection();
        foreach ($entries as $entryKey => $entryValue) {
            $formattedEntry = $entryToMeasureCallback($entryKey, $entryValue);
            if ($formattedEntry)
            {
                $this->measures->put($formattedEntry['code'], Measure::fromArray(
                    $formattedEntry
                ));
            }
        }
    }
    
    /**
     * List available measures
     *
     * @return Collection
     */
    public function getAvailableMeasures()
    {
        return $this->measures->keys();
    }
    
    /**
     * Retreive a measure by it's code ; $activity->steps for example
     *
     * @return Measure
     */
    public function __get($propertyName)
    {
        return $this->measures->get($propertyName);
    }
    
    /**
     * Retreive a measure by it's code ; $activity->getSteps() for example
     *
     * @return Measure
     */
    public function __call($methodName, $arguments)
    {
        if (strncmp($methodName, 'get', 3) === 0) {
            return $this->measures->get(lcfirst(substr($methodName, 3)));
        } else {
            $exception = (PHP_MAJOR_VERSION < 7) ? '\Exception' : '\Error'; // Try to imitate PHP behaviour
            throw new $exception(sprintf('Call to undefined method %s::%s()', get_called_class(), $methodName));
        }
    }
}
