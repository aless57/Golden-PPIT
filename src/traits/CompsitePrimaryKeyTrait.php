<?php

namespace goldenppit\traits;

use goldenppit\models\Exception;

/**Cette class est à importer dans les models ayant plusieurs clés primaires, elle permet d'éviter un bug 'illegal offset type'**/
trait CompsitePrimaryKeyTrait
{

    public function getIncrementing()
    {
        return false;
    }

    protected function setKeysForSaveQuery($query)
    {
        foreach ($this->getKeyName() as $key) {
            if (isset($this->$key)) {
                $query->where($key, '=', $this->$key);
            } else
                throw new Exception(__METHOD__ . 'Missing part of the primary key: ' . $key);
        }
        return $query;
    }


    protected function getKeyForSaveQuery($keyName = null)
    {

        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }


    public static function find($ids, $columns = ['*'])
    {
        $me = new self;
        $query = $me->newQuery();

        foreach ($me->getKeyName() as $key) {
            $query->where($key, '=', $ids[$key]);
        }

        return $query->first($columns);
    }
}