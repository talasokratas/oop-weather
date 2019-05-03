<?php

namespace Weather\Api;

use DateInterval;
use DatePeriod;
use Weather\Model\NullWeather;
use Weather\Model\Weather;

class GoogleApi implements DataProvider
{
    /**
     * @return Weather
     * @throws \Exception
     */
    public function selectByDate(\DateTime $date): Weather
    {
        $today = $this->load(new NullWeather());
        $today->setDate($date);

        return $today;
    }

    public function selectByRange(\DateTime $from, \DateTime $to): array
    {
        $result  = [];
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($from, $interval, $to);

        foreach ($period as $date) {
            $record = new Weather();
            $record->setDate($date);
            $record->setDayTemp(random_int(5 - $base, 5 + $base));
            $record->setNightTemp(random_int(-5 - abs($base), -5 + abs($base)));
            $record->setSky(random_int(1, 3));
            $result[] = $record;
        }

        return $result;
    }

    /**
     * @param Weather $before
     * @return Weather
     * @throws \Exception
     */
    private function load(Weather $before)
    {
        $now = new Weather();
        $base = $before->getDayTemp();
        $now->setDayTemp(random_int(5 - $base, 5 + $base));

        $base = $before->getNightTemp();
        $now->setNightTemp(random_int(-5 - abs($base), -5 + abs($base)));

        $now->setSky(random_int(1, 3));

        return $now;
    }


}
