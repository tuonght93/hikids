<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Excel,Cache, Auth;
use Carbon\Carbon;
use App\Models\City, App\Models\Distric, App\Models\Commune;
use DOMDocument;
use App\Libraries\Xonlib;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.index', $this->data);
    }

    public function test()
    {
        
     }

    public function test2()
    {

        $results = Excel::selectSheets('Sheet1')->load('data2.xlsx')->all();
        $j = 0;
        foreach ($results as $row) {
                      
            $city_name = '';
            $distric_name = '';
            $commune_name = '';

            $city_slug = '';
            $distric_slug = '';
            $commune_slug = '';
            $i = 0;
            foreach ($row as $key => $value) {
                $i++;
                switch ($i) {
                    case 1:
                        $city_name = $value;
                        $city_slug = str_slug($value);
                        break;
                    case 2:
                        $distric_name = $value;
                        $distric_slug = str_slug($value);
                        break;
                    case 3:
                        $commune_name = $value;
                        $commune_slug = str_slug($value);
                        break;
                }
            }
            $city = City::where('slug', '=', $city_slug)->first();;
            if (!$city) {
                $city = new City;
                $city->name = $city_name;
                $city->slug = str_slug($city_slug);
                $city->save();
            }
            $distric = Distric::where('slug', '=', $distric_slug)->where('city_code', '=', $city_slug)->first();
            if (!$distric) {
                $distric = new Distric;
                $distric->name = $distric_name;
                $distric->slug = str_slug($distric_slug);
                $distric->city_code = $city->slug;
                $distric->save();
            }
            $commune = Commune::where('slug', '=', $commune_slug)->where('distric_id', '=', $distric->_id)->first();
            if (!$commune) {
                $commune = new Commune;
                $commune->name = $commune_name;
                $commune->slug = str_slug($commune_slug);
                $commune->distric_id = $distric->_id;
                $commune->save();
            }
             $j++;
            echo $j.'<br/>';
        }
        echo 'done';
        // Excel::selectSheets('sheet1')->load('data.xlsx', function($reader) {
        //     $cacheKey = "data";
        //     if (Cache::has($cacheKey)){
        //         $results = Cache::get($cacheKey);
        //     }else{
        //         $results = $reader->all();
        //         Cache::put($cacheKey, $results, Carbon::now()->addMinutes(240));         
        //     }
        //     $results = $results->toArray();
        //     foreach ($results as $row) {
        //         echo $row[1];die;
        //     }

        // });echo 'a2';die;
    }
}
