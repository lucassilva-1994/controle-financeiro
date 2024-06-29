<?php

if (! function_exists('formatBrazilianDate')) {
    function formatBrazilianDate($date) {
        return date('d/m/Y H:i:s', strtotime($date));
    }
}
