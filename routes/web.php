<?php

Route::get('/{any}', function(){
            return view('start');
    })->where('any', '.*');


