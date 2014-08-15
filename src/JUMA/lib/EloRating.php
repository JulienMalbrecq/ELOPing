<?php

namespace JUMA\lib;

use InvalidArgumentException;

class EloRating
{
    const
        INITIAL_SCORE     = 1500,
        COEFF_THRESHOLD   = 2400,
        COEFFICIENT       = 15,
        COEFFICIENT_HIGH  = 10,
        STATUS_WIN        = 'WIN',
        STATUS_LOST       = 'LOST',
        STATUS_DRAW       = 'DRAW',
        VALUE_WIN         = 1,
        VALUE_DRAW        = 0.5,
        VALUE_LOST        = 0;

    protected $status = array(
        self::STATUS_WIN  => self::VALUE_WIN,
        self::STATUS_DRAW => self::VALUE_DRAW,
        self::STATUS_LOST => self::VALUE_LOST,
    );

    /**
     * En+K(W-p(D))
     *
     * @param string $resultOfMatch
     * @param int    $playerElo
     * @param int    $versusElo
     *
     * @return int $elo  New elo
     */
    public function compute($resultOfMatch, $playerElo, $versusElo)
    {
        $delta  = $this->computeEloDifference($playerElo, $versusElo);
        $newElo = $playerElo + $this->getCoefficient($playerElo, $versusElo) * ($this->getStatusValue($resultOfMatch) - $delta);

        return round($newElo, 0, PHP_ROUND_HALF_UP);
    }

    protected function computeEloDifference($playerElo, $versusElo)
    {
        $diff = $playerElo - $versusElo;

        return 1/ ((pow(10, - $diff / 400)) + 1);
    }

    protected function getStatusValue($status)
    {
        if (!array_key_exists($status, $this->status))
        {
            throw new InvalidArgumentException(sprintf('The given status "%s" is invalid', $status));
        }

        return $this->status[$status];
    }

    protected function getCoefficient($elo1, $elo2)
    {
        if (($elo1 > self::COEFF_THRESHOLD) && ($elo2 > self::COEFF_THRESHOLD))
        {
            return self::COEFFICIENT_HIGH;
        }

        return self::COEFFICIENT;
    }
}