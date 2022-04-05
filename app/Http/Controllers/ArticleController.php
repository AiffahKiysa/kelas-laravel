<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(){
        return view('article.article', [
            "name" => "Aiffah Kiysa",
            "title" => "All Article",
            // "articles" => Article::all(),
            "articles" => Article::latest()->get()
        ]);
    }

    public function content(Article $article){
        return view('article.content', [
            "article" => $article
        ]);
        
    }

}

