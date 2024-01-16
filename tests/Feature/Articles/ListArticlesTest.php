<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase; 
use Tests\TestCase;

class ListArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_a_list_of_all_articles() : void
    {
        $articles = Article::factory()->count(5)->create();

        $response = $this->getJson(route('api.v1.articles.index'));

        foreach ($articles as $article) {
            $data[] =
                [
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
                ];
        } 
        $response->assertExactJson([
            'data' => $data,
            'links' => [
                'self' => route('api.v1.articles.index'),
            ]
        ]);
    }

    /** @test */
    public function can_fetch_an_empty_list_of_articles() : void
    {
        $response = $this->getJson(route('api.v1.articles.index'));
        
        $response->assertExactJson([
            'data' => [],
            'links' => [
                'self' => route('api.v1.articles.index'),
            ]
        ]);
    }

}
