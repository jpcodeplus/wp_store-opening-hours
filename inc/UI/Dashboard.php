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

    public function grid()
    {

        $admin_url = get_admin_url();

        $items = [
            [
                'name'=> 'Seiten',
                'url'=> 'edit.php?post_type=page',
                'position' => 100
            ],
            [
                'name'=> 'Blog Posts',
                'url'=> 'edit.php',
                'position' => 110,
            ],
            [
                'name'=> 'Medien',
                'url'=> 'upload.php',
                'position' => 120
            ],            
            [
                'name'=> 'Erweiterungen',
                'url'=> 'plugins.php',
                'position' => 130
            ],
            [
                'name'=> 'Template',
                'url'=> 'themes.php',
                'position' => 140
            ],
        ];

        usort($items, function($a, $b) {
            // Sortiert die einträge nach Position
            return $a['position'] - $b['position'];
        });


        // $links = [
        //     'edit.php', 'edit-comments.php', 'themes.php', 'options-general.php',
        //     'tools.php', 'upload.php', 'users.php', 'edit.php?post_type=page', 'index.php',
        //     'plugins.php', 'about.php'
        // ];

  

        $parts = null;

        foreach ($items as $item) {
            $name = $item["name"];
            $link = $admin_url.$item['url'];
            $parts .= "<div>$name -  <a href='$link'>ansehen</a></div>";
        }

        return "<section class='cpm_grid'>$parts</section>";
    }
}
