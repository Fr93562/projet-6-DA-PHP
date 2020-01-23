<?php

namespace Service\Tools;

/*
 * Classe utilisée par TrickController, l'entité User et Trick
 * Permet de slug ou déslug l'élément passé en en argumenr (String)
 */
class Slugger
{
    public static function slugify($string)
    {
        return preg_replace(
          '/[^a-z0-9]/',
          '-',
          strtolower(trim(strip_tags($string)))
      );
    }

    public static function noSlugify(String $string)
    {
        return preg_replace(
          '/-/',
          ' ',
          $string
      );
    }
}
