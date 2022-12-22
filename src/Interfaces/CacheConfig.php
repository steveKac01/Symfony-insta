<?php

namespace App\Interfaces;

/**
 * Config files for the cache.
 */
interface CacheConfig
{
    public const CACHE_POSTS_KEY = "posts_home";
    public const CACHE_POSTS_TIME_EXPIRATION = 60000;
}
