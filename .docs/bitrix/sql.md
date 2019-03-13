# Сгенерированный SQL запрос, D7

Пример:

```php
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;
use \Bitrix\Iblock\SectionTable;

if (Loader::includeModule('iblock')) {
    Application::getConnection()->startTracker();
    
    $oSectionTable = SectionTable::getList([
        'select' => [
            'ID'
        ],
        'filter' => [
            '=IBLOCK_SECTION_ID' => 12,
            '=IBLOCK_ID' => 12
        ]
    ]);
    
    Application::getConnection()->stopTracker();
    
    echo '<pre>' . $oSectionTable->getTrackerQuery()->getSql() . '</pre>';
}
```

```sql
SELECT 
    `iblock_section`.`ID` AS `ID`
FROM `b_iblock_section` `iblock_section` 
 
WHERE `iblock_section`.`IBLOCK_SECTION_ID` = 12
AND `iblock_section`.`IBLOCK_ID` = 12
```