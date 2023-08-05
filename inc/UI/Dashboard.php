<?php

namespace CPM_Plugin\UI;

class Dashboard
{
    public function __construct()
    {
    }

    public function link($name, $url, $classname = "link link_website")
    {
        return "<a title='$name' class='$classname' href='$url'>$name</a>";
    }

    public function datetime()
    {
        $days = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');
        $months = array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');

        $timestamp = time();

        return $days[date('w', $timestamp)] . ", der " . date('d', $timestamp) . ". " . $months[date('n', $timestamp) - 1] . " " . date('Y', $timestamp) . ", " . date('H:i', $timestamp) . " Uhr";
    }
}
