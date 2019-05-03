<?php

namespace Weather\Api;

use Weather\Model\NullWeather;
use Weather\Model\Weather;

class DbRepository extends AbstractFIleService implements DataProvider
{
    /**
     * @return Weather[]
     */
    public function selectAll(): array
    {
        $result = [];
        $data = json_decode(
            file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Db' . DIRECTORY_SEPARATOR . 'Data.json'),
            true
        );
        foreach ($data as $item) {
            $record = new Weather();
            $record->setDate(new \DateTime($item['date']));
            $record->setDayTemp($item['dayTemp']);
            $record->setNightTemp($item['nightTemp']);
            $record->setSky($item['sky']);
            $result[] = $record;
        }

        return $result;
    }
}
