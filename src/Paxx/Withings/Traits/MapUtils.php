<?php

namespace Paxx\Withings\Traits;

trait MapUtils
{
    
    public static function mapNotFound($type, $key)
    {
        return [
            'code' => '_unk'.$key,
            'name' => 'Unknow '.$type.' (id '.$key.')',
            'desc' => 'Unknow '.$type.' (id '.$key.')',
        ];
    }
    
    public static function getFromMap(&$map, $type, $key) {
        try {
            return $map[$key];
        } catch (\Exception $e) {
            return self::mapNotFound($type, $key);
        }
    }

}