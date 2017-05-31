<?php
/**
 * Created by PhpStorm.
 * User: hisheng
 * Date: 2017/5/31
 * Time: 18:46
 */
namespace Zimu\Srt;
class Srt implements SrtInterface
{
    const SRT_DIR = 'srts';
    public $sirs = '';
    public $sirs_unsaved = '';
    
    public function __construct()
    {
    
    }
    
    //read srts 里面的字幕
     public function read(){
     
     }
     
     //取出一个字幕文件
    public function get(){
    
    }
    
    //取出unsaved目录的所有文件
    public function gets($root = ''){
        if(empty($root)){
            $root = $this->sirs_unsaved;
        }
        if(is_dir($root)){
            $dh = opendir($root);
            var_dump($dh);
            if($dh){
                while (false !== ($file = readdir($dh))) {
                    if(is_file($root.'./'.$file)){
                        header("Content-type: text/html; charset=utf-8");
                        echo $file."\n";
                    }elseif(is_dir($root.'./'.$file)){
                        echo 'dir';
                        if(($file != '.') && ($file != '..')){
                            echo 'ys';
                            //遍历字幕文件夹
                            $this->gets($root.'./'.$file);
                        }
                    }
                }
                var_dump($file);
            }
            closedir($dh);
           
        }else{
            echo '不是目录';
        }
    }
    
    public function hi(){
        echo 'hi';
        $this->initPaths();
        $this->gets();
    }
    
    public function initPaths(){
        $this->sirs = realpath(__DIR__).'./../../'.self::SRT_DIR;
        echo $this->sirs;
        $this->sirs_unsaved = $this->sirs.'/unsaved';
    }
}