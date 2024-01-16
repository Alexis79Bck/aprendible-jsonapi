<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_an_article(): void
    {
        $response = $this->postJson(
            route('api.v1.articles.create'),
            [
                'data' => [
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'Creando un nuevo Articulo',
                        'slug' => 'Creando-un-nuevo-articulo',
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad obcaecati sed quo quasi eaque aut officiis at ex dolores dolorem, eius mollitia eos totam! Labore laudantium quae porro nobis distinctio.',
                    ],
                ]
            ]
        );
        $response->assertCreated();

        $article = Article::first();

        $response->assertHeader('Location', route('api.v1.articles.show', $article));

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => 'Creando un nuevo Articulo',
                    'slug' => 'Creando-un-nuevo-articulo',
                    'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad obcaecati sed quo quasi eaque aut officiis at ex dolores dolorem, eius mollitia eos totam! Labore laudantium quae porro nobis distinctio.',
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article),
                ]
            ]
        ]);
    }
}
