<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 08.11.15
 * Time: 18:13
 */

namespace modules\base\components;


class Helper {

    /*
     * Идентификатор youtube-видео, получаемый из url.
     * */
    public static function getIdentifier($url){
        $urlParams = parse_url($url);
        $identifier = false;
        if(isset($urlParams['query'])){
            $urlParamsArr = explode('=', $urlParams['query']);
            if(isset($urlParamsArr[0]) && isset($urlParamsArr[1]) && $urlParamsArr[0] == 'v'){
                $identifier = $urlParamsArr[1];
            }
        }
        elseif(isset($urlParams['path'])){
            $urlParamsArr = explode('/', $urlParams['path']);
            if($k=array_search('embed', $urlParamsArr)){
                if(isset($urlParamsArr[$k+1]))
                    $identifier = $urlParamsArr[$k+1];
            }
            else{
                if(isset($urlParamsArr[1]))
                    $identifier = $urlParamsArr[1];
            }

        }
        return $identifier;
    }
} 