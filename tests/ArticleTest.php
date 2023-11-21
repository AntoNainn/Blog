<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\Slugger;

class ArticleTest extends TestCase
{
    public function testSlugGoodDelimiter(): void
    {
        $titre = "Mon article PHP";
        $slug = new Slugger();
        $titreslug = $slug->slugify($titre);
        $this->assertEquals($titreslug, "mon-article-php");
    }
    public function testSlugBadDelimiter(): void
    {
        $titre = "Mon article PHP";
        $slug = new Slugger();
        $titreslug = $slug->slugify($titre, '$');
        $this->assertNotEquals($titreslug, "mon-article-php");
    }
}
