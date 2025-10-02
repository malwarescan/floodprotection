<?php

namespace App\Controllers;

use App\Config;
use App\Util;
use App\View;

class FeedController
{
    public function rss()
    {
        $posts = Util::getBlogPosts(20);
        $rss = View::renderRss($posts);
        
        header('Content-Type: application/rss+xml; charset=utf-8');
        echo $rss;
        exit;
    }
}
