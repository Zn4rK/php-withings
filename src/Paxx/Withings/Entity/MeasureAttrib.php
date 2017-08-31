<?php

namespace Paxx\Withings\Entity;

class MeasureAttrib
{
    public static $attribMap = array(
        0 => [
            'code' => 'userDevice',
            'desc' => 'The measuregroup has been captured by a device and is known to belong to this user (and is not ambiguous)'
        ],
        1 => [
            'code' => 'sharedDevice',
            'desc' => 'The measuregroup has been captured by a device but may belong to other users as well as this one (it is ambiguous)'
        ],
        2 => [
            'code' => 'userManual',
            'desc' => 'The measuregroup has been entered manually for this particular user'
        ],
        4 => [
            'code' => 'userCreation',
            'desc' => 'The measuregroup has been entered manually during user creation (and may not be accurate)'
        ],
        5 => [
            'code' => 'autoBloodPressure',
            'desc' => 'Measure auto, it\'s only for the Blood Pressure Monitor. This device can make many measures and computed the best value'
        ],
        7 => [
            'code' => 'confirmedActivity',
            'desc' => 'Measure confirmed. You can get this value if the user confirmed a detected activity'
        ],
    );
    
    public $id;
    public $code;
    public $desc;
    
    public function __construct($attribId)
    {
        $this->id = $attribId;
        $this->code = self::$attribMap[$attribId]['code'];
        $this->desc = self::$attribMap[$attribId]['desc'];
    }
    
    /**
     * Is ambiguous
     *
     * @return bool
     */
    public function isAmbiguous()
    {
        return ($this->id == 1 || $this->id == 4);
    }
}