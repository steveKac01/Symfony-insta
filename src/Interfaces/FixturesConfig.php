<?php

namespace App\Interfaces;

/**
 * Config files for datafixtures.
 */
interface FixturesConfig
{
    public const NUMBER_USER = 10;
    public const NUMBER_POST = 20;
    public const NUMBER_COMMENTS = 70;
    public const CATEGORIES_LABEL = ["SCREENSHOT", "ARTWORK", "WORK IN PROGRESS", "PHOTO"];
    public const CATEGORIES_COLOR = ["danger", "info", "success", "warning"];
    public const AVATAR_LABEL = ['Dracofeu','Bulbizarre','Rondoudou','Salameche','Evoli','Pikachu','Carapuce'];
}
