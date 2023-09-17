<?php
/**
 * Script for viewing SQL queries
 */
use Illuminate\Support\Facades\DB;

DB::listen(function ($oQuery) {
    echo $oQuery->sql;
});
