<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\UI\Extension;
use Bitrix\Main\Localization\Loc;

Extension::load("ui.alerts");

if (!empty($arResult['ERRORS'])) {
    foreach ($arResult['ERRORS'] as $errorMessage) {
        ?>
        <div class="ui-alert ui-alert-danger">
            <span class="ui-alert-message">
                <?= $errorMessage ?>
            </span>
        </div>
        <?php
    } return;
} else {
    echo '<table cellpadding="5" cellspacing="0" border="1">';
    ?>
    <tr>
        <th><?= Loc::getMessage("SIMPLE_TABLE_FIELD_NAME_TITLE") ?></th>
        <th><?= Loc::getMessage("SIMPLE_TABLE_FIELD_REVENUE_TITLE") ?></th>
        <th><?= Loc::getMessage("SIMPLE_TABLE_FIELD_EXPENSES_TITLE") ?></th>
        <th><?= Loc::getMessage("SIMPLE_TABLE_FIELD_COUNTS_RESIDENTS_TITLE") ?></th>
        <th><?= Loc::getMessage("SIMPLE_TABLE_FIELD_REVENUE_RATING_TITLE") ?></th>
        <th><?= Loc::getMessage("SIMPLE_TABLE_FIELD_EXPENSES_RATING_TITLE") ?></th>
        <th><?= Loc::getMessage("SIMPLE_TABLE_FIELD_RESIDENTS_RATING_TITLE") ?></th>
    </tr>
    <?php
    foreach ($arResult['ITEMS'] as $key => $value) {
        echo '<tr><td>'
            . $value['NAME'] . "</td><td>"
            . $value['REVENUE'] . '</td><td>'
            . $value['EXPENSES'] . '</td><td>'
            . $value['COUNTS_RESIDENTS'] . '</td><td>'
            . $value['RESIDENTS_RATING'] . '</td><td>'
            . $value['REVENUE_RATING'] . '</td><td>'
            . $value['EXPENSES_RATING']
            . '</td></tr>';
    }
    echo '</table>';
}
