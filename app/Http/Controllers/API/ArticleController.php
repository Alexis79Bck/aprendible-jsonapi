<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Article $article) : ArticleResource 
    {
        return ArticleResource::make($article); // Retorna el recurso aplicando la clase Resource


        /** 
          * Retorna el recurso con el formato de especificación JSON API directamente 
          *
          * response()->json([
          *  'data' => [
          *      'type' => 'articles',
          *      'id' => (string) $article->getRouteKey(),
          *      'attributes' => [
          *          'title' => $article->title,
          *          'slug' => $article->slug,
          *          'content ' => $article->content,
          *      ],
          *      'links' => [
          *          'self' => route('api.v1.articles.show', $article),
          *      ]
          *  ]
          * ]); 
        */
        // Retorna el recurso sin el formato de especificacion JSON ----> $article; 
    }
}
