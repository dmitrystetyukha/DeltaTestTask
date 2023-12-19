<?php

namespace App\Service;

use App\Repository\InfographicRepository;

/**
 * Infographic service class
 */
class InfographicService
{
    /**
     * @param string $date
     * @return array
     */
    public function getInfoByDate(string $date): array
    {
        return InfographicRepository::getInstance()->getInfoByDate($date);
    }
}