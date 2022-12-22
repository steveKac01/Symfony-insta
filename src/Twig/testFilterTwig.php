<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class testFilterTwig extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('read_more', [$this, 'reduceFilter']),
        ];
    }

    public function reduceFilter($values,$id): string
    {
        $limitChars = 120;
        if($values>$limitChars){
        return substr($values,0,$limitChars) . ' <a href="posts/show/'.$id.'" class="text-white"><strong> ... Read More</strong></a>';
        }

        return $values;
    }


}
