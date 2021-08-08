# Настройка миграций через Phinx

Для установки Phinx в консоли вводим в папке `/local/`:

```bash
composer require robmorgan/phinx
```

Создаем в папке `/local/` файл `phinx.php`, со следующим содержимым:

```php
<?php
define('NOT_CHECK_PERMISSIONS', true);
define('NO_AGENT_CHECK', true);

$GLOBALS['DBType'] = 'mysql';
$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/..');

include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Application;

global $DB;

try {
    $oApp = Application::getInstance();
    $oCon = $oApp->getConnection();

    $DB->db_Conn = $oCon->getResource();

    $_SESSION['SESS_AUTH']['USER_ID'] = 1;

    $arConfig = include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/.settings.php';
    $arConfigDB = $arConfig['connections']['value']['default'];

    return [
        'paths' => [
            'migrations' => 'migrations'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_database' => 'development',
            'development' => [
                'adapter' => 'mysql',
                'host' => $arConfigDB['host'],
                'name' => $arConfigDB['database'],
                'user' => $arConfigDB['login'],
                'pass' => $arConfigDB['password']
            ]
        ]
    ];
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

Пример создания миграции (метод `up()`) с учетом транзакции:

```php
/**
 * @throws Exception
 * @throws \Bitrix\Main\Db\SqlQueryException
 * @throws \Bitrix\Main\LoaderException
 */
public function up()
{
    \Bitrix\Main\Loader::includeModule('iblock');

    $oDb = \Bitrix\Main\Application::getConnection();
    $oDb->startTransaction();

    $arIBlocks = \CIBlock::GetList([], ['TYPE' => 'common', 'CODE' => 'purchase']);
    if ($arIBlock = $arIBlocks->Fetch()) {
        $oProperties = \CIBlockProperty::GetList([], ['IBLOCK_ID' => $arIBlock['ID'], 'CODE' => 'CREDIT_TERM']);
        if ($arProperties = $oProperties->Fetch()) {
            $oCIBlockProperty = new \CIBlockProperty();
            if (!$oCIBlockProperty->Update($arProperties['ID'], ['NAME' => 'Срок кредита'])) {
                $oDb->rollbackTransaction();
                throw new \Exception('Property update failed.');
            }
        }

        $oDb->commitTransaction();
    } else {
        $oDb->rollbackTransaction();
        throw new \Exception('Error. No iblock found.');
    }
}
```
