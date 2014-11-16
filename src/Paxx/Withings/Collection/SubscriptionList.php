<?php

namespace Paxx\Withings\Collection;

class SubscriptionList extends Collection
{
    public function __construct(array $params = array())
    {
        if (! empty($params['profiles'])) {
            foreach ($params['profiles'] as &$subscription) {
                $subscription = new Subscription($subscription);
            }
        }

        parent::__construct($params);
    }
}
