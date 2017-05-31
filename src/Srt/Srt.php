<?php
/**
 * Created by PhpStorm.
 * User: hisheng
 * Date: 2017/5/31
 * Time: 18:46
 */
namespace Zimu\Srt;

use Elasticsearch\ClientBuilder;

class Srt implements SrtInterface
{
    const SRT_DIR = 'srts';
    public $sirs = '';
    public $sirs_unsaved = '';
    public $esClient;
    
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
        $this->init();
        $this->gets();
        $this->addIndex();
    }
    
    //保存进 es
    public function save(){
    
    }
    
    public function init(){
        $this->initPaths();
        $this->initEs();
    }
    
    public function initPaths(){
        $this->sirs = realpath(__DIR__).'./../../'.self::SRT_DIR;
        echo $this->sirs;
        $this->sirs_unsaved = $this->sirs.'/unsaved';
    }
    public function initEs(){
        $this->esClient = ClientBuilder::create()->build();
    }
    
    //建立索引 http://localhost:9200/zimu/subhd/335407
    public function addIndex(){
        $params = [
            'index' => 'zimu',
            'type' => 'subhd',
            'id' => '335407',
            'body' => [
                'z_id' => 'subhd_335407',
                'name'=>'求婚大作战',
                'role'=>'山下智久,长泽雅美,藤木直人,荣仓奈奈,平冈佑太,滨田岳,松重丰',
                'category' =>'剧情,爱情,奇幻 ',
                'title'=>'[ドラマ][プロポーズ大作戦 第01話]「甲子園行けたら結婚できる！？」',
                'srts'=>[
                    [
                        't'=>'00:00:03,937 --> 00:00:11,444',
                        'words'=>'说出你的愿望吧'
                    ],
                    [
                        't'=>'00:00:03,937 --> 00:00:11,444',
                        'words'=>"努力试着去改变过去
                                那个懦弱的自己"
                    ]
                ]
            ]
        ];
        
        $response = $this->esClient->index($params);
        return $response;
    }
    
}