<?php
function getDuration($originDate)
{
    $now = time();
    $date_ajout = strtotime($originDate);
    $diff = $now - $date_ajout;

    $jours = floor($diff / (60 * 60 * 24));
    $heures = floor(($diff - ($jours * 60 * 60 * 24)) / (60 * 60));
    $minutes = floor(($diff - ($jours * 60 * 60 * 24) - ($heures * 60 * 60)) / 60);

    if ($jours > 0) {
        return $jours . " jours";
    } elseif ($heures > 0) {
        return $heures . " heures";
    } elseif ($minutes > 0) {
        return $minutes . " minutes";
    } else {
        return "quelques instants";
    }
}
