<?php

namespace Service\Tools;

/*
 * Classe utilisée par TrickController
 * Prend un String en argument
 * Transforme l'élément slug en String normal
 */
 /*
class NoSlugger
{
    public static function noSlugify($string)
    {
        return preg_replace(
            '/-/', ' ', $string
        );
    }
}
