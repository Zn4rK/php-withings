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
     * @return MeasureCollection
     */
    public static function fromEntries(array $entries = array(), callable $entryToMeasureCallback)
    {
        $instance = new static(); // Overloading the Collection::__construct() is a bad idea .. it breaks ->keys() for example
        
        foreach ($entries as $entryKey => $entryValue) {
            $formattedEntry = $entryToMeasureCallback($entryKey, $entryValue);
            if ($formattedEntry)
            {
                $instance->put($formattedEntry['code'], Measure::fromArray(
                    $formattedEntry
                ));
            }
        }
        
        return $instance;
    }
    
    /**
     * List available measures
     * Returns MeasureCollection with only codes
     * 
     * @return MeasureCollection
     */
    public function availableMeasures()
    {
        return $this->keys();
    }
    
    /**
     * Retreive a measure by it's code ; $activity->steps for example
     *
     * @return Measure
     */
    public function __get($propertyName)
    {
        return $this->get($propertyName);
    }
    
    /**
     * Retreive a measure by it's code ; $activity->getSteps() for example
     * But also allows to retreive collection's properties ; $activity->getUpdatedAt() for example
     *
     * @return Measure
     */
    public function __call($methodName, $arguments)
    {
        if (strncmp($methodName, 'get', 3) === 0)
        {
            $property = lcfirst(substr($methodName, 3));
            // We may check if $this->{$property} is public here .. But it needs Reflection and this seems slow
            // This is only an helper / retrocompat' feature to have getCreatedAt() for example
            return $this->get($property) ?: $this->{$property};
        }
        else // Try to access an undefined or non-public function not starting with get
        {
            $exception = (PHP_MAJOR_VERSION < 7) ? '\Exception' : '\Error'; // Try to imitate PHP behaviour
            throw new $exception(sprintf('Call to undefined or private method %s::%s()', get_called_class(), $methodName));
        }
    }

}
