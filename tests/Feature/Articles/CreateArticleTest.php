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

    /** @test */
    public function title_field_is_required(): void
    {
        $response = $this->postJson(
            route('api.v1.articles.create'),
            [
                'data' => [
                    'type' => 'articles',
                    'attributes' => [
                        'slug' => 'Creando-un-nuevo-articulo',
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad obcaecati sed quo quasi eaque aut officiis at ex dolores dolorem, eius mollitia eos totam! Labore laudantium quae porro nobis distinctio.',
                    ],
                ]
            ]
        );
        $response->assertJsonValidationErrors('data.attributes.title');


    }

    /** @test */
    public function slug_field_is_required(): void
    {
        $response = $this->postJson(
            route('api.v1.articles.create'),
            [
                'data' => [
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'Creando un nuevo Articulo',
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad obcaecati sed quo quasi eaque aut officiis at ex dolores dolorem, eius mollitia eos totam! Labore laudantium quae porro nobis distinctio.',
                    ],
                ]
            ]
        );
        $response->assertJsonValidationErrors('data.attributes.slug');


    }

    /** @test */
    public function content_field_is_required(): void
    {
        $response = $this->postJson(
            route('api.v1.articles.create'),
            [
                'data' => [
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'Creando un nuevo Articulo',
                        'slug' => 'Creando-un-nuevo-articulo',

                    ],
                ]
            ]
        );
        $response->assertJsonValidationErrors('data.attributes.content');


    }
}
