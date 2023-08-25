<?php

function parseUrl($url) {
    if  ($urls = parse_url($url)) {
        if (!isset($urls["scheme"])) {
            $url = "https://{$url}";
        }
    }
    return $url;
}