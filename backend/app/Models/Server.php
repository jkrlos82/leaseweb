<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    static private $response;
    static private $list = array();

    public static function filters(array $filters)
    {
        self::$response = DB::table('servers')->select();

        if(array_key_exists('Storage', $filters) && 
            array_key_exists('HardDisk_Type', $filters) && 
            $filters['HardDisk_Type'] != null){

            self::getStorage($filters['Storage'], $filters['HardDisk_Type']);

        }else if(array_key_exists('Storage', $filters)){

            self::getStorage($filters['Storage'], '');

        }else if(array_key_exists('HardDisk_Type', $filters)&& 
                $filters['HardDisk_Type'] != null){

            self::getStorage(array(), $filters['HardDisk_Type']);
        }

        if(array_key_exists('RAM', $filters) && $filters['RAM'] != [] && self::$list != []){
            self::getRam($filters['RAM']);
        }

        if(array_key_exists('Location', $filters) && $filters['Location'] != null && self::$list != []){
            self::getLocation($filters['Location']);
        }

        if(!empty(self::$list)){
            return self::$response->whereIn('id', self::$list)->get();
        }
        return array();
    }


    public static function getStorage(array $filter,$harddisk):array
    {
        $response = array();
        $query = self::$response->where('HDD', 'LIKE','%'.$harddisk.'%')->get();
        if(!empty($filter)){
            $start = str_contains($filter["start"], 'GB') ? intval(substr($filter["start"], 0,strpos($filter["start"], 'GB'))) : substr($filter["start"], 0,strpos($filter["start"], 'TB'));
            $start = $start == '' ? 0 : $start;
            $end = str_contains($filter["end"], 'GB') ? intval(substr($filter["end"], 0,strpos($filter["end"], 'GB'))) : substr($filter["end"], 0,strpos($filter["end"], 'TB'));
            $end = $end == '' ? 0 : $end;
            
            foreach($query as $disk){
                if(strpos($disk->HDD, 'GB')){
                    $size_data = substr($disk->HDD, 0,strpos($disk->HDD, 'GB'));
                    $measure = 'GB';
                }else{
                    $size_data = substr($disk->HDD, 0,strpos($disk->HDD, 'TB'));
                    $measure = 'TB';
                }
                $size_data = explode('x', $size_data);
                $size = $size_data[0] * $size_data[1];

                if($measure != 'TB'){
                    
                    $size = $size/1000;
                    $measure = 'TB';
                }
                if($size >= $start && $size <= $end){
                    array_push($response, $disk->id);
                }
            }
        }
        self::$list = $response;
        return $response;
    } 

    public static function getRam(array $filter):array 
    {
        $response = array();
        if(!empty(self::$list)){
            $query = DB::table('servers')->select('id')->WhereIn('id', self::$list);
        }else{
            $query = DB::table('servers')->select('id');
        }
        $first = true;
        foreach($filter as $key=>$value){
            if($first){
                $query = $query->Where('RAM','LIKE',$value.'%');
                $first = false;
            }else{
                $query = $query->orWhere('RAM','LIKE',$value.'%');
            }
        }
        $data = $query->get();       
        $response = self::getIds($data);
        self::$list = $response;

        return $response;
    }

    public static function getLocation(string $filter):array 
    {
        $response = array();
        
        if(!empty(self::$list)){
            $query = DB::table('servers')->select('id')->Where('Location',$filter)->WhereIn('id', self::$list);
        }else{
            $query = DB::table('servers')->select('id')->Where('Location',$filter);
        }
        $data = $query->get();
        $response = self::getIds($data);

        self::$list = $response;
        return $response;
    }

    public static function getLocations():array 
    {
        $response = array();

        $query = DB::table('servers')->select('location')->get()->unique('location');

        foreach($query as $item){
            array_push($response, $item->location);
        }

        return $response; 
    }

    private static function getIds($data){
        $response = array();

        foreach($data as $item){
            array_push($response, $item->id);
        }

        return $response;
    }
}
