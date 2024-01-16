<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_a_single_article(): void
    {

        $article = Article::factory()->create();

        $response = $this->getJson(route('api.v1.articles.show', $article));

        $response->assertSee($article->title);

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content,
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article),
                ]
            ]
        ]);
    }
   
}
