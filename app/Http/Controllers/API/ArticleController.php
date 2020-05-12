<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    
    public function __construct(){

        $this->middleware('auth:api')->except(['index','show']);
    }

    public function index()
    {
        return ArticleResource::collection(Article::all());
    }


    public function store(ArticleRequest $request)
    {
        $request->merge(['user_id' => auth()->user()->id ]);
        $article = Article::create($request->all());
        return response()->json(['data'=> new ArticleResource($article), 'status' => 200 ,'message' => 'Article is created'],200);
    }


    public function show($id)
    {
        $article = Article::find($id);

        if(!$article)
        {
            return $this->notFound();
        }
        return response()->json(['data'=> new ArticleResource($article), 'status' => 200 ,'message' => 'Article Data'],200);
    }

    public function update(ArticleRequest $request, $id){

        $article = auth()->user()->articles()->find($id);

        if(!$article)
        {
            return $this->notFound();
        }

        $article->update($request->all());
        return response()->json(['data'=> new ArticleResource($article), 'status' => 200 ,'message' => 'Article is updated'],200);
    }



    public function destroy($id)
    {

        $article = auth()->user()->articles()->find($id);
        if(!$article)
        {
            return $this->notFound();
        }

        if($article->delete()){

            return response()->json(['data'=> [], 'status' => 200 ,'message' => 'Article is deleted'],200);
        }else{
            return response()->errorResponse();

        }
    }

    public function logout(){

        auth()->user()->token()->revoke();
        auth()->user()->token()->delete();
    }

    public function notFound()
    {
        $data = [
            'data' => [],
            'status' => false,
            'status_code' => 404,
            'message' => 'Article is Not Found!'
        ];

        return response()->json($data,404);
    }

    public function errorResponse()
    {
        $data = [
            'data' => [],
            'status' => false,
            'status_code' => 500,
            'message' => 'Somthing went wrong, Operation Failed!'
        ];

        return response()->json($data,500);
    }
}
