<?php

namespace App\Enums;

enum ArticleStatus: string
{
    case Published = 'published';
    case Draft = 'draft';
}
