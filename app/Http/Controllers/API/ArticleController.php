<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ArticleResource;
use App\Http\Resources\API\ArticleCollection;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

  /**
   * Metodo Index
   * 
   * Obtiene la lista de todos los articulos, 
   *
   * @return ArticleCollection Retorna la lista de todos los articulos mediante la clase ArticleCollection
   */
  public function index(): ArticleCollection
  {
    return ArticleCollection::make(Article::all()); // Retorna una coleccion del recurso aplicando la clase Resource
  }

  /**
   * Obtiene la informacion de un articulo
   *
   * @param Article $article El Modelo Articulo a consultar, mediante el Model Binding.
   * @return ArticleResource Retorna la información del articulo consultado mediante la clase ArticleResource.
   */
  public function create(Request $request): ArticleResource
  {

    $request->validate([
      'data.attributes.title' => ['required'],
      'data.attributes.slug' => ['required'],
      'data.attributes.content' => ['required'],
    ]);
    $article = Article::create([
      'title' => $request->input('data.attributes.title'),
      'slug' => $request->input('data.attributes.slug'),
      'content' => $request->input('data.attributes.content'),
    ]);
    return ArticleResource::make($article);
  }

  /**
   * Obtiene la informacion de un articulo
   *
   * @param Article $article El Modelo Articulo a consultar, mediante el Model Binding.
   * @return ArticleResource Retorna la información del articulo consultado mediante la clase ArticleResource.
   */
  public function show(Article $article): ArticleResource
  {
    return ArticleResource::make($article); // Retorna el recurso aplicando la clase Resource    
  }
}



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