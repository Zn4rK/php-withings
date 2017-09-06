<?php

namespace Paxx\Withings\Entity;

use JsonSerializable;
use Paxx\Withings\Traits\JsonUtils;
use Carbon\Carbon;
use Paxx\Withings\Api;

class User implements JsonSerializable
{
    use JsonUtils;
    
    /**
     * @var Integer
     */
    protected $id;

    /**
     * @var String
     */
    protected $firstName;

    /**
     * @var String
     */
    protected $lastName;

    /**
     * @var String
     */
    protected $shortName;

    /**
     * @var Integer
     */
    protected $gender;

    /**
     * @var Integer
     */
    protected $fatMethod;

    /**
     * @var Carbon
     */
    protected $birthDate;

    /**
     * @var Boolean
     */
    protected $isPublic;

    /**
     * @param Api
     */
    private $api;

    /**
     * @param Api $api
     * @param array $params
     */
    public function __construct(Api $api, array $params = array()) {
        // Set the reference to the $api so we can reuse it to get the measures
        $this->api       = $api;
        $this->id        = $params['id'];
        $this->firstName = $params['firstname'];
        $this->lastName  = $params['lastname'];
        $this->shortName = $params['shortname'];
        $this->gender    = $params['gender'];
        $this->fatMethod = $params['fatmethod'];
        $this->birthDate = Carbon::createFromTimestamp($params['birthdate']);
        $this->isPublic  = !!$params['ispublic'];

        // Unset params
        unset($params);
    }

    /**
     * Get Withings User id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the first name
     *
     * @return String
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get the last name
     *
     * @return String
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get the short name
     *
     * @return String
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Get the gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender == 0 ? 'male' : 'female';
    }

    /**
     * Get the raw gender (0 for male, and 1 for female)
     *
     * @return int
     */
    public function getGenderRaw()
    {
        return $this->gender;
    }

    /**
     * Get the fat method
     *
     * @return int
     */
    public function getFatMethod()
    {
        return $this->fatMethod;
    }

    /**
     * Get the birthdate
     *
     * @return Carbon
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Is this user public or not
     *
     * @return bool
     */
    public function isPublic()
    {
        return $this->isPublic;
    }

    /**
     * Shortcut to the API for measures
     *
     * @return \Paxx\Withings\Collection\MeasureCollection
     */
    public function getMeasures()
    {
        return $this->api->getMeasures();
    }

    /**
     * Shortcut to the API for activites
     *
     * @return Activity
     */
    public function getActivites()
    {
        return $this->api->getActivity();
    }
    
    /**
     * Returns an array of parameters to serialize when this is serialized with
     * json_encode().
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $this_properties = array_keys(get_object_vars($this));
        $this_properties = array_diff($this_properties, ['api']);
        return $this->jsonSerializeProperties($this_properties);
    }

}
