<?php

namespace App\Queries;

use DB;

class queryBuilder {

    public function union($value)
    {

        $cms = DB::table('cms_translations')
                    ->select('cms_id as id', 'name', DB::raw("'cms' as model") )
                    ->where('name', 'like', '%'.$value.'%');
        $news = DB::table('news_translations')
                    ->select('new_id as id', 'name', DB::raw("'news' as model") )
                    ->where('name', 'like', '%'.$value.'%');
        $maps = DB::table('map_translations')
                    ->select('map_id as id', 'name', DB::raw("'maps' as model") )
                    ->where('name', 'like', '%'.$value.'%');
        $countries = DB::table('country_translations')
                    ->select('country_id as id', 'name', DB::raw("'countries' as model") )
                    ->where('name', 'like', '%'.$value.'%');
        $imams = DB::table('imams_translations')
                    ->select('imam_id as id', 'name', DB::raw("'imams' as model") )
                    ->where('name', 'like', '%'.$value.'%');
        $data = DB::table('coins_translations')
                    ->select('coin_id as id', 'name', DB::raw("'coins' as model"))
                    ->where('name', 'like', '%'.$value.'%')
                    ->union($cms)
                    ->union($news)
                    ->union($maps)
                    ->union($countries)
                    ->union($imams)
                    ->get();

        //
        $data =  DB::select(DB::raw(
            "SELECT coin_id as id, name,'coins' as model FROM coins_translations
            WHERE name LIKE '%test%'
            UNION
            SELECT new_id as id, name,'news' as model FROM news_translations
            WHERE name LIKE '%test%'
            UNION
            SELECT country_id as id, name,'countries' as model FROM country_translations
            WHERE name LIKE '%test%'
            UNION
            SELECT imam_id as id, name,'imams' as model FROM imams_translations
            WHERE name LIKE '%test%'
            UNION
            SELECT map_id as id, name,'maps' as model FROM map_translations
            WHERE name LIKE '%test%'
            UNION
            SELECT cms_id as id, name,'cms' as model FROM cms_translations
            WHERE name LIKE '% ? %'"
        ))->setBindings([$value])->get();
        return $data;
    }
}