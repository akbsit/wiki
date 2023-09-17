<?php
/**
 * Script is intended for authorization as an administrator
 */
define('ENV_DEBUG', true);
define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('NEED_AUTH', false);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

global $USER;

$USER->Authorize(1);

LocalRedirect('/bitrix/admin/');
