<?php

namespace Paxx\Withings\Entity;

use Carbon\Carbon;

class Subscription
{
    /**
     * @var Carbon
     */
    protected $expiresAt;

    /**
     * @var String
     */
    protected $comment;

    /**
     * @var String
     */
    protected $callback;

    /**
     * @var String
     */
    protected $appli;

    public function __construct(array $params = array())
    {
        $this->expiresAt = Carbon::createFromTimestamp($params['expires']);
        $this->comment = $params['comment'];
        $this->callback = $params['callbackurl'];
        $this->appli = $params['appli'];
    }

    /**
     * Date at which the notification configuration will expire.
     *
     * @return Carbon
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Comment entered when creating the notification configuration.
     *
     * @return String
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Callback entered when creating the notification configuration.
     *
     * @return String
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Appli entered when creating the notification configuration.
     *
     * @return Integer
     */
    public function getAppli()
    {
        return $this->appli;
    }
}
