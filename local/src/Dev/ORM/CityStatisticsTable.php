<?php

namespace DEV\ORM;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\Entity;

/**
 * Class CityStatisticsTable
 * Данные о доходах/расходах и жителях по городам
 **/
class CityStatisticsTable extends DataManager
{
    public static function getTableName()
    {
        return "dev_city_statistics";
    }

    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', [
                'title' => Loc::getMessage('CITY_STATISTICS_ID_TITLE'),
                'primary' => true,
                'autocomplete' => true,
            ]),
            new Entity\StringField('NAME', [
                'title' => Loc::getMessage('CITY_STATISTICS_NAME_TITLE'),
            ]),
            new Entity\FloatField('REVENUE', [
                'title' => Loc::getMessage('CITY_STATISTICS_REVENUE_TITLE'),
            ]),
            new Entity\FloatField('EXPENSES', [
                'title' => Loc::getMessage('CITY_STATISTICS_EXPENSES_TITLE'),
            ]),
            new Entity\IntegerField('COUNTS_RESIDENTS', [
                'title' => Loc::getMessage('CITY_STATISTICS_COUNTS_RESIDENTS_TITLE'),
            ]),
        ];
    }
}
