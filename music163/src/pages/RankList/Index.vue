<template>
  <div class="content-wrap">
    <div class="c-right">
      <div class="list-box">
        <h3>{{rank163.title}}</h3>
        <ul v-for="(item) in rank163.data" :key="item.id">
          <li :class="{'active':id==item.id}" @click="id=item.id">
            <img :src="item.imgSrc">
            <div class="text-box">
              <p>{{item.title}}</p>
              <p class="time">{{item.updataTime}}</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="c-left">
      <div class="c-header">
        <img :src="rank163.data[rId].imgSrc">
        <div class="info">
          <h3>{{rank163.data[rId].title}}</h3>
          <p class="time"><i class="ifont">&#xe62f;</i>最近更新：02月07日 （{{rank163.data[rId].updataTime}}）</p>
          <div class="action-box">
            <a class="play-group">
              <i class="ifont play" >&#xe60c; 播放</i>
              <i class="ifont add" >&#xe643;</i>
            </a>
            <a class="ifont btn">&#xe64b; (0)</a>
            <a class="ifont btn">&#xe66e; (0)</a>
            <a class="ifont btn">&#xe63b; (0)</a>
            <a class="ifont btn">&#xe63e; (0)</a>
          </div>
        </div>
      </div>
      <div class="c-body">
        <div class="title">
          <h5>歌曲列表<span>8首歌</span></h5>
          <p class="num">播放：<span>0</span>次</p>
        </div>
        <music-table/>
      </div>
    </div>
  </div>
</template>

<script>
  import r1 from "./images/r1.jpeg"
  import r2 from "./images/r2.jpeg"
  import r3 from "./images/r3.jpeg"
  import r4 from "./images/r4.jpeg"
  import MusicTable from "../../components/MusicTable"
  export default {
    data() {
      return {
        rank163:{
          title:"云音乐特色榜",
          data:[
            {
              id:1,
              title:"云音乐飙升榜",
              updataTime:"每天更新",
              imgSrc:r1
            },
            {
              id:2,
              title:"云音乐新歌榜",
              updataTime:"每天更新",
              imgSrc:r2
            },
            {
              id:3,
              title:"网易原创歌曲榜",
              updataTime:"每周四更新",
              imgSrc:r3
            },
            {
              id:4,
              title:"云音乐热歌榜",
              updataTime:"每周四更新",
              imgSrc:r4
            }
          ]
        },
        id:1
      }
    },
    computed: {
      rId(){
        let ids=this.id-1;
        if(ids<0){
          ids=0
        }
        return ids;
      }
    },
    components:{
      "music-table":MusicTable
    }
  }
</script>

<style lang="scss" scoped>
.content-wrap{
  // 排行榜列表
  .c-right{
    border-right: 1px solid #d4d4d4;
    width: 240px;
    background-color: #f9f9f9;
    .list-box{
      padding-top: 34px;
      color: #000;
      font-size: 12px;
      h3{
        margin-left: 20px;
        font-size: 14px;
        margin-bottom: 10px;
      }
      li{
        padding: 12px 20px;
        display: flex;
        cursor: pointer;
        img{
          width: 40px;
          height: 40px;
        }
        .text-box{
          margin-left: 10px;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
        }
        .time{
          color: #999;
        }
      }
      li:hover{
        background-color: #eee;
      }
      .active{
        background-color: #e6e6e6;
      }
    }
  }
  // 内容详情
  .c-left{
    border: none;
    padding: 40px;
    color: #333;
    font-size: 12px;
    .c-header{
      display: flex;
      justify-content: left;
      padding-bottom: 30px;
      img{
        display: inline-block;
        padding: 3px;
        border: 1px solid #ccc;
        width: 150px;
        height: 150px;
      }
      .info{
        padding: 18px 30px;
        h3{
          font-size: 18px;
        }
        .time{
          color: #666;
          padding: 18px 0 30px 0;
          i{
            padding-right: 5px;
          }
        }
      }
      .action-box{
        display: flex;
        a{
          height: 30px;
          line-height: 30px;
          border: 1px solid #c4c4c4;
          overflow: hidden;
          border-radius: 4px;
          color: #333;
          display: inline-block;
          background:linear-gradient(to bottom, #fff,#c6c6c6);
          padding: 0 10px;
          margin-right: 5px;
        }
        .play-group{
          display: flex;
          background:linear-gradient(to bottom, #319ee3,#0075c8);
          border: 1px solid #267fd1;
          color: #fff;
          padding: 0;
          justify-content: center;
          i{
            padding: 0 10px;
          }
          i:hover{
            background-color: #1d7ed1;
          }
          .play{
            border-right: 1px solid #165a97;
          }
          .add{
            border-left: 1px solid #54a7ee;
          }
        }
      }
    }
    .c-body{
      .title{
        display: flex;
        justify-content: space-between;
        border-bottom: 2px solid $mainColor;
        align-items: flex-end;
        padding: 10px 0;
        h5{
          font-size: 20px;
          span{
            font-size: 12px;
            color: #666;
            padding-left: 20px;
          }
        }
        .num{
          span{
            color: $mainColor;
          }
        }
      }
    }
  }
}
</style>