<?php

if (! function_exists('formatBrazilianDate')) {
    function formatBrazilianDate($date) {
        return date('d/m/Y H:i:s', strtotime($date));
    }
}

if (! function_exists('generateRandomPassword')) {
    function generateRandomPassword($length = 10) {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?'), 0, $length);
    }
}
