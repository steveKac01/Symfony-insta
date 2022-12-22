<?php

namespace App\EntityListener;

use App\Interfaces\CacheConfig;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class PostListener implements CacheConfig
{

    private $cache;

    public function __construct()
    {
        $this->cache = new FilesystemAdapter();
    }

    /**
     * Delete the cache after a new post insert in the database.
     *
     * @return void
     */
    public function postUpdate(): void
    {
        $this->deleteCache();
    }

    /**
     * Delete the cache after a post update in the database.
     *
     * @return void
     */
    public function postPersist(): void
    {
        $this->deleteCache();
    }

    /**
     * Delete the cache.
     *
     * @return void
     */
    private function deleteCache(): void
    {
        $this->cache->delete($this::CACHE_POSTS_KEY);
    }
}
