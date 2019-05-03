<?php
/**
 * Created by PhpStorm.
 * User: ritmas
 * Date: 03/05/2019
 * Time: 19:25
 */

namespace Weather\Api;


use Weather\Model\NullWeather;
use Weather\Model\Weather;

abstract class AbstractFIleService
{
    /**
     * @param \DateTime $date
     * @return Weather
     */
    public function selectByDate(\DateTime $date): Weather
    {
        $items = $this->selectAll();
        $result = new NullWeather();

        foreach ($items as $item) {
            if ($item->getDate()->format('Y-m-d') === $date->format('Y-m-d')) {
                $result = $item;
            }
        }

        return $result;
    }

    public function selectByRange(\DateTime $from, \DateTime $to): array
    {
        $items = $this->selectAll();
        $result = [];

        foreach ($items as $item) {
            if ($item->getDate() >= $from && $item->getDate() <= $to) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @return Weather[]
     */
    abstract public function selectAll(): array;

}