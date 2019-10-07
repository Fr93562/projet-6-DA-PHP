<?php

// src/AppBundle/Tools/Slugger.php


namespace AppBundle\Tools;

class Slug
{
    public function slugify($string)
    {
        return preg_replace(
            '/[^a-z0-9]/', '-', strtolower(trim(strip_tags($string)))
        );
    }
}


