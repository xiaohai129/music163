<?php
namespace app\index\controller;
use think\Config;

header("Access-Control-Allow-Origin: *");

class Music
{
  // 根据id查询相应音乐信息
  public function getMusicInfo(){
    if(isset($_GET["id"])){
      $id=$_GET["id"];
      if($id){
        $musicInfo=db("songs")->where("id",$id)->find();
        if($musicInfo){
          // 资源路径拼接
          $baseUrl=Config::get("base_url");
          $musicInfo["src"] = $baseUrl.$musicInfo["src"];
          $musicInfo["cover"] = $baseUrl.$musicInfo["cover"];
          $musicInfo["state"]="ok";
        }
      }else{
        $musicInfo=array(
          "state"=>"err",
          "errMsg"=>"参数传递错误"
        );
      }
    }else{
      $musicInfo=array(
        "state"=>"err",
        "errMsg"=>"参数未传递"
      );
    }
    if($musicInfo==null||$musicInfo==""){
      $musicInfo=array(
        "state"=>"err",
        "errMsg"=>"音乐信息不存在"
      );
    }
    return json_encode($musicInfo);
  }
  // 判读当前id是否有效
  public function hasId(){
    $info=array(
      "id"=>0,
      "state"=>"err",
      "nextId"=>0
    );
    if(isset($_GET["id"])){
      $id=$_GET["id"];
      $ids=null;
      if($id){
        $ids=db("songs")->field("id")->where("id",">=",$id)->limit(2)->select();
        // 在下一曲id不存在时使用此数据
        $nextId=db("songs")->field("id")->order("id","asc")->find();
      }
      // 判读是否获取到数据
      if($ids!=null && count($ids)>0){
        if($ids[0]["id"]==$id){
          $info["id"]=$ids[0]["id"];
          // 下一曲id
          if(count($ids)>1){
            $info["nextId"]=$ids[1]["id"];
            $info["state"]="ok";
          }else{
            $info["state"]="ok:end";
            $info["nextId"]=$nextId["id"];
          }
        }else{
          $info["state"]="err:no";
          $info["nextId"]=$ids[0]["id"];
        }
      }else{
        $info["state"]="err:no";
        $info["nextId"]=$nextId["id"];
      }
    }
    return json_encode($info);
  }
  // 获取音乐列表
  public function getMusicList(){
    $list=array(
      "state"=>"ok",
      "data"=>[]
    );
    $category=null;
    $num=0;
    if(isset($_GET["category"])){
      $category=$_GET["category"];
    }
    if(isset($_GET["num"])){
      $num=$_GET["num"];
    }
    if($category){
      $list["data"]=db("songs")->where("classify","like",$category)->select();
      if($num){
        $list["data"]=db("songs")->where("classify","like",$category)->limit($num)->select();
      }
    }
    if($num){
      $list["data"]=db("songs")->limit($num)->select();
    }
    if(!$num&&!$category){
      $list["data"]=db("songs")->select();
    }
    if($list["data"]){
      // 资源路径拼接
      $baseUrl=Config::get("base_url");
      for($i = 0; $i < count($list["data"]); $i++){
        $list["data"][$i]["src"] = $baseUrl.$list["data"][$i]["src"];
        $list["data"][$i]["cover"] = $baseUrl.$list["data"][$i]["cover"];
      }
    }
    return json_encode($list);
  }
  // 获取歌曲名
  public function getSongName(){
    $list=array(
      "state"=>"ok",
      "data"=>[]
    );
    if(isset($_GET["keyword"])){
      $list["data"]=db("songs")->field("id,name,singer")->where("name","like","%".$_GET["keyword"]."%")->select();
    }else{
      $list["data"]=db("songs")->field("id,name,singer")->select();
    }
    return json_encode($list);
  }
  // 获取歌手名
  public function getSingerName(){
    $list=array(
      "state"=>"ok",
      "data"=>[]
    );
    if(isset($_GET["keyword"])){
      $list["data"]=db("songs")->Distinct(true)->field("singer")->where("singer","like","%".$_GET["keyword"]."%")->select();
    }else{
      $list["data"]=db("songs")->Distinct(true)->field("singer")->select();
    }
    return json_encode($list);
  }
}
