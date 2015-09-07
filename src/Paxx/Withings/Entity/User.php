<?php

namespace Paxx\Withings\Entity;

use Carbon\Carbon;
use Paxx\Withings\Api;

class User extends Entity
{
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
    protected $api;

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
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @return String
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @return String
     */
    public function getShortName() {
        return $this->shortName;
    }

    /**
     * @return string
     */
    public function getGender() {
        return $this->gender == 0 ? 'male' : 'female';
    }

    /**
     * @return int
     */
    public function getGenderRaw() {
        return $this->gender;
    }

    /**
     * @return int
     */
    public function getFatMethod() {
        return $this->fatMethod;
    }

    /**
     * @return Carbon
     */
    public function getBirthDate() {
        return $this->birthDate;
    }

    /**
     * @return bool
     */
    public function isPublic() {
        return $this->isPublic;
    }

    public function getMeasures() {
        return $this->api->getMeasures(array('user_id' => $this->id));
    }

}
