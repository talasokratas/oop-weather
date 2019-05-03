<?php
/**
 * Created by PhpStorm.
 * User: ritmas
 * Date: 03/05/2019
 * Time: 16:54
 */

namespace Weather\Api;

use Weather\Model\NullWeather;
use Weather\Model\Weather;


class JsonApi extends AbstractFIleService implements DataProvider
{

    /**
     * @return Weather[]
     */
    public function selectAll(): array
    {
        $result = [];
        $data = json_decode(
            file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Db' . DIRECTORY_SEPARATOR . 'Weather.json'),
            true
        );
        foreach ($data as $item) {
            $record = new Weather();
            $record->setDate(new \DateTime($item['date']));
            $record->setDayTemp($item['high']);
            $record->setNightTemp($item['low']);
            $record->setSky($this->DescriptionToIcon($item['text']));
            $result[] = $record;
        }
        return $result;
    }

    private function DescriptionToIcon(string $description) :int
    {
        switch (trim($description))
        {
            case 'Partly Cloudy':
            case 'Mostly Cloudy':
            case 'Cloudy':
                $iconKey = 1;
                break;
            case 'Scattered Showers':
                $iconKey = 2;
                break;
            case 'Sunny':
                $iconKey = 3;
                break;
            case 'Breezy':
                $iconKey = 4;
            break;
            default: $iconKey = 1;
                break;
        }
        return $iconKey;
    }


}