<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class testFilterTwig extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('read_more', [$this, 'reduceFilter']),
        ];
    }

    /**
     * Filter that split a post content too long and add a link "read more".
     *
     * @param string $values the post content.
     * @param int $id the id of the post.
     * @return string
     */
    public function reduceFilter($values,$id): string
    {
        $limitChars = 120;
        if($values>$limitChars){
        return substr($values,0,$limitChars) . ' <a href="posts/show/'.$id.'" class="text-white"><strong> ... Read More</strong></a>';
        }

        return $values;
    }
}
