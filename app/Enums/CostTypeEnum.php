<?php



namespace App\Enums;

enum StatusEnum: string
{
    const DirectCost = 'Direct Cost';
    const IndirectCostSKSU = 'Indirect Cost SKSU';
    const IndirectCostDOST = 'Indirect Cost DOST';

    public static function toArray()
    {
        return [
            self::DirectCost => self::DirectCost,
            self::IndirectCostSKSU => self::IndirectCostSKSU,
            self::IndirectCostDOST => self::IndirectCostDOST,
        ];
    }
}
