<?php
/**
 * Скрипт для просмотра SQL запросов
 */
use Illuminate\Support\Facades\DB;

DB::listen(function ($oQuery) {
    echo $oQuery->sql;
});
