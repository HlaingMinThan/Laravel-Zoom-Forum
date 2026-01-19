<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateController extends Controller
{
   

public function translate(Request $request)
{
    //dd($request->all());
    $title = $request->input('title');
        $body = $request->input('body');
        $target = $request->input('lang', 'en');
        $translationTitle =  GoogleTranslate::trans($title, $target);
        $translationBody =  GoogleTranslate::trans($body, $target);
         return response()->json([
            'translatedTitle' => $translationTitle,
            'translatedBody' => $translationBody
        ]);
}
}
