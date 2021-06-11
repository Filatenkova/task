<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Данные по городам");

$APPLICATION->IncludeComponent(
    'developer:simplecomponent',
    'simple',
    [
        'CACHE_TIME' => 3600
    ],
    false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
