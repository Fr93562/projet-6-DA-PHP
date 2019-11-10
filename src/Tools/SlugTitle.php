<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/*
 * Méthode personnalisée pour Twig
 * Transforme le String en argument en Slug
 * S'utilise avec Slugger.php pour retirer le slug
 */
/*
class SlugTitle extends \Twig_Extension
{
    public function getFunctions() {
          return array(
               'slug' => new \Twig_Function_Method($this, 'slugify'),
          );
    }

    public function slugify($string)
    {
        return preg_replace(
            '/[^a-z0-9]/', '-', strtolower(trim(strip_tags($string)))
        );
    }
}
