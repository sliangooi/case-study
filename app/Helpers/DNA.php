<?php

namespace App\Helpers;

use App\User;
use stdClass;
use Exception;
use Carbon\Carbon;

class DNA
{
    public static function getStateList():array
    {
        return [
            'kuala_lumpur' => 'Kuala Lumpur',
            'selangor' => 'Selangor',
            'ipoh' => 'Ipoh',
            'penang' => 'Penang',
            'malacca' => 'Malacca',
            'pahang' => 'Pahang',
            'johor' => 'Johor',
            'negeri_sembilan' => 'Negeri Sembilan',
            'kelantan' => 'Kelantan',
            'kuantan' => 'Kuantan',
            'terengganu' => 'Terengganu',
            'kedah' => 'Kedah',
            'perlis' => 'Perlis',
            'sabah' => 'Sabah',
            'sarawak' => 'Sarawak',
        ];
    }

    public static function getCountryList():array
    {
        return [
            'malaysia' => 'Malaysia',
        ];
    }
    
    public static function getActionList():array
    {
        return [
            'index' => 'View',
            'add' => 'Add',
            'edit' => 'Edit',
            'delete' => 'Delete',
        ];
    }

    const STRING_ACTIVE = 'active';
    const STRING_DELETED = 'deleted';

    public static function getUserStatusList():array
    {
        return [
            self::STRING_ACTIVE => 'Active',
            self::STRING_DELETED => 'Deleted',
        ];
    }

}

