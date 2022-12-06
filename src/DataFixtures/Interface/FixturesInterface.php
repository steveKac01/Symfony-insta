<?php

namespace App\DataFixtures\Interface;

interface FixturesInterface
{
    public const NUMBER_USER=10;
    public const NUMBER_POST=20;
    public const NUMBER_COMMENTS=70;
    public const NUMBER_AVATAR=10;
    public const CATEGORIES_LABEL=[
    "SCREENSHOT","ARTWORK","WORK IN PROGRESS"
    ];
    public const CATEGORIES_COLOR=[
        "danger","info","success"
    ];
}