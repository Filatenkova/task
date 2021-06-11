<?php

use DEV\ORM\CityStatisticsTable;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Localization\Loc;

/**
 * Класс для работы с данными о доходах/расходах и жителях по городам
 */
class SimpleComponent extends \CBitrixComponent
{
    private $errorCollection = null;

    public function executeComponent()
    {
        if ($this->StartResultCache($this->arParams['CACHE_TIME'])) {
            if (empty($this->errorCollection->toArray())) {
                $this->arResult["ITEMS"] = $this->getData();
            } else {
                $this->arResult["ERRORS"] = $this->errorCollection->toArray();
            }

            $this->IncludeComponentTemplate();
        }
    }

    public function onPrepareComponentParams($arParams)
    {
        $this->errorCollection = new ErrorCollection();

        try {
            if (empty($arParams['CACHE_TIME'])) {
                $arParams['CACHE_TIME'] = 3600;
            }

        } catch (Exception $e) {
            $this->errorCollection->setError(new Error(Loc::getMessage("CMP_SIMPLE_PARAMETERS_ERROR")));
        }

        return $arParams;
    }

    /**
     * Метод получает данные по городам для отображения на странице
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getData(): array
    {
        $arRevenueRating = $this->getRevenueRating();
        $arExpensesRating = $this->getExpensesRating();
        $arResidentsRating = $this->getResidentsRating();

        try {
            $obResult = CityStatisticsTable::getList([
                'select' => [
                    '*'
                ],
                'order' => [
                    'COUNTS_RESIDENTS' => 'DESC'
                ]
            ]);

            while ($arRow = $obResult->fetch()) {
                $arResult[$arRow['ID']] = $arRow;
                $arResult[$arRow['ID']]['REVENUE_RATING'] = $arRevenueRating[$arRow['ID']]['REVENUE_RATING'];
                $arResult[$arRow['ID']]['EXPENSES_RATING'] = $arExpensesRating[$arRow['ID']]['EXPENSES_RATING'];
                $arResult[$arRow['ID']]['RESIDENTS_RATING'] = $arResidentsRating[$arRow['ID']]['RESIDENTS_RATING'];
            }
        } catch(Exception $e) {
            $this->errorCollection->setError(new Error(Loc::getMessage("CMP_SIMPLE_NOT_DATA")));
        }

        return $arResult ?? [];
    }

    /**
     * Метод сортирует данные о городах по полю «Доходы общие» и присваивает место в рейтинге.
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getRevenueRating(): array
    {
        try {
            $obResult = CityStatisticsTable::getList([
                'select' => [
                    'ID',
                    'REVENUE',

                ],
                'order' => [
                    'REVENUE' => 'DESC'
                ]
            ]);

            $counter = 0;
            while ($arRow = $obResult->fetch()) {
                $counter++;
                $arResult[$arRow['ID']]['REVENUE_RATING'] = $counter;
            }
        } catch(Exception $e) {
            $this->errorCollection->setError(new Error(Loc::getMessage("CMP_SIMPLE_NOT_DATA")));
        }

        return $arResult ?? [];
    }

    /**
     * Метод сортирует данные о городах по полю «Расходы общие» и присваивает место в рейтинге.
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getExpensesRating(): array
    {
        try {
            $obResult = CityStatisticsTable::getList([
                'select' => [
                    'ID',
                    'EXPENSES',

                ],
                'order' => [
                    'EXPENSES' => 'DESC'
                ]
            ]);

            $counter = 0;
            while ($arRow = $obResult->fetch()) {
                $counter++;
                $arResult[$arRow['ID']]['EXPENSES_RATING'] = $counter;
            }
        } catch(Exception $e) {
            $this->errorCollection->setError(new Error(Loc::getMessage("CMP_SIMPLE_NOT_DATA")));
        }

        return $arResult ?? [];
    }

    /**
     * Метод сортирует данные о городах по полю «Количество жителей» и присваивает место в рейтинге.
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getResidentsRating(): array
    {
        try {
            $obResult = CityStatisticsTable::getList([
                'select' => [
                    'ID',
                    'COUNTS_RESIDENTS',

                ],
                'order' => [
                    'COUNTS_RESIDENTS' => 'DESC'
                ]
            ]);

            $counter = 0;
            while ($arRow = $obResult->fetch()) {
                $counter++;
                $arResult[$arRow['ID']]['RESIDENTS_RATING'] = $counter;
            }
        } catch(Exception $e) {
            $this->errorCollection->setError(new Error(Loc::getMessage("CMP_SIMPLE_NOT_DATA")));
        }

        return $arResult ?? [];
    }
}
