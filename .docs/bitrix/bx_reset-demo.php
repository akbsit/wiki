<?php
function echoBr()
{
    echo('<br />');
    echo('<br />');
}

/**
 * @param $sDate
 * @param $sSol
 *
 * @return string
 */
function getBitrixExpireDate($sDate, $sSol)
{
    $sResult = '';

    $iExpire = 0;
    for ($iIteration = 0; $iIteration < strlen($sDate); $iIteration++) {
        $sResult .= chr(ord($sDate[$iIteration]) ^ ord($sSol[$iExpire]));
        if ($iExpire == strlen($sSol) - 1) {
            $iExpire = 0;
        } else {
            $iExpire = $iExpire + 1;
        }
    }

    return $sResult;
}

/**
 * @param $sMessage
 *
 * @return string
 */
function showSuccessMessage($sMessage)
{
    return '<span style="color:green">' . $sMessage . '</span>';
}

/**
 * @param $sMessage
 *
 * @return string
 */
function showErrorMessage($sMessage)
{
    return '<span style="color:red">' . $sMessage . '</span>';
}

/**
 * @param $sDir
 */
function rmDirRecursive($sDir)
{
    foreach (scandir($sDir) as $sFile) {
        if ('.' === $sFile || '..' === $sFile) {
            continue;
        }

        if (is_dir("$sDir/$sFile")) {
            rmDirRecursive("$sDir/$sFile");
        } else {
            unlink("$sDir/$sFile");
        }
    }

    rmdir($sDir);
}

/**
 * Script is intended to extend the demo version of the site
 */
$sRequestUri = $_SERVER['REQUEST_URI'];
if ($sRequestUri !== strtolower($sRequestUri)) {
    header('Location: ' . strtolower($sRequestUri));
}

/**
 * 1. Prepare new keys
 */
$sSolForFile = 'DO_NOT_STEAL_OUR_BUS';
$sSolForDB = 'thRH4u67fhw87V7Hyr12Hwy0rFr';

$iNowDate = date('mdY', time() + 60 * 60 * 24 * 30);

$sCodeDateForFile = 'XX' . $iNowDate[3] . $iNowDate[7] . 'XX' . $iNowDate[0] . $iNowDate[5] . 'X' . $iNowDate[2] . 'XX' . $iNowDate[4] . 'X' . $iNowDate[6] . 'X' . $iNowDate[1] . 'X';
$sCodeDateForDB = 'X' . $iNowDate[2] . 'X' . $iNowDate[1] . 'XX' . $iNowDate[0] . $iNowDate[6] . 'XX' . $iNowDate[4] . 'X' . $iNowDate[7] . 'X' . $iNowDate[3] . 'XXX' . $iNowDate[5];

$sKeyForFile = base64_encode(getBitrixExpireDate($sCodeDateForFile, $sSolForFile));
$sKeyForDB = base64_encode(getBitrixExpireDate($sCodeDateForDB, $sSolForDB));

/**
 * 2. Update TEMPORARY_CACHE
 * in file /bitrix/modules/main/admin/define.php
 */
$sPathDefine = '/bitrix/modules/main/admin/define.php';
if (file_put_contents($_SERVER['DOCUMENT_ROOT'] . $sPathDefine, '<?define("TEMPORARY_CACHE", "' . $sKeyForFile . '");?>')) {
    echo(showSuccessMessage('File ' . $sPathDefine . ' updated: TEMPORARY_CACHE=' . $sKeyForFile));
    echoBr();
} else {
    die(showErrorMessage('Failed to update ' . $sPathDefine . ' file'));
}

/**
 * 3. Update field admin_passwordh
 * in table b_option
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/dbconn.php';

$oConnection = new mysqli($DBHost, $DBLogin, $DBPassword, $DBName);
if ($oConnection->connect_error) {
    die(showErrorMessage('An error occurred while connecting to the database: ' . $oConnection->connect_error));
}

if ($oConnection->query("UPDATE `b_option` SET `VALUE`='" . $sKeyForDB . "' WHERE `NAME`='admin_passwordh'")) {
    echo(showSuccessMessage('Updated field admin_passwordh in table b_option: admin_passwordh=' . $sKeyForDB));
    echoBr();
} else {
    die(showErrorMessage('When updating a field admin_passwordh error has occurred: ' . $oConnection->error));
}

$oConnection->close();

/**
 * 4. Clearing the cache
 */
$sPathCache = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/cache/';
$sPathManagedCache = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/managed_cache/';

if (file_exists($sPathCache) && is_dir($sPathCache)) {
    rmDirRecursive($sPathCache);
    echo(showSuccessMessage('Cache folder ' . $sPathCache . ' cleared'));
    echoBr();
}

if (file_exists($sPathManagedCache) && is_dir($sPathManagedCache)) {
    rmDirRecursive($sPathManagedCache);
    echo(showSuccessMessage('Cache folder ' . $sPathManagedCache . ' cleared'));
    echoBr();
}
?>

<a href="/">
    Go back to the main page
</a>
