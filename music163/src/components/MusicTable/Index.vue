<template>
  <div class="music-table">
    <table>
      <tr class="title">
        <th class="t1"></th>
        <th class="t2">标题</th>
        <th style="width:90px">时长</th>
        <th style="width:90px">歌手</th>
      </tr>
      <tbody>
        <tr v-for="(item, index) in musicList" :key="index">
          <td class="t1">{{index+1}}</td>
          <td class="t2">
            <img :src="item.cover" v-if="index<3">
            <a class="ifont paly" @click="playMusic(item.id)">&#xe60c;</a>
            {{item.name}}
          </td>
          <td>
            <div class="t3">
              {{musicTimeFormat(item.duration)}}
            </div>
          </td>
          <td class="t3">
            <div class="t3">{{item.singer}}</div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        musicList:null,
      }
    },
    created() {
      this.getMusicList();
    },
    methods: {
      // 音乐时间转换
      musicTimeFormat:function(time){
        let h=parseInt(time/360);
        if(h<10){
          h="0"+h
        }
        let m=parseInt(time/60);
        if(m<10){
          m="0"+m
        }
        let s=parseInt(time%60);
        if(s<10){
          s="0"+s
        }
        if(h>=10){
          return h+":"+m+":"+s;
        }else{
          return m+":"+s;
        }
      },
      // 获取音乐信息
      getMusicList:function(){
        this.ajax({
          methods:"get",
          url:"music/getMusicList",
          data:{}
        }).then(res=>{
          this.musicList=res.data.data
        })
      },
      playMusic(id){
        this.$store.commit("setPlayId",id)
      }
    },
  }
</script>

<style lang="scss" scoped>
  .music-table{
    border: 1px solid #d9d9d9;
    border-top: none;
    table{
      border: none;
      width: 100%;
      overflow: hidden;
      tr{
        padding: 0;
        margin: 0;
      }
      tbody{
        tr{
          height: 30px;
          line-height: 30px;
        }
        td{
          padding:0 8px;
          text-align: left;
          flex-grow: 1;
          flex-shrink: 0;
        }
        img{
          width: 50px;
          height: 50px;
          margin-right: 10px;
        }
        .paly{
          font-size: 18px;
          color: #b3b3b3;
          margin-right: 8px;
          vertical-align: middle;
          cursor: pointer;
        }
        .paly:hover{
          color: #666;
        }
        tr:nth-of-type(2n){
          background-color: #f7f7f7;
        }
        tr:nth-of-type(-n+3){
          height: 70px;
          line-height: 70px;
        }
      }
      .title{
        background:linear-gradient(to bottom, #fff,#c6c6c6); 
        height: 34px;
        line-height: 34px;
        border-bottom: 1px solid #d9d9d9;
        overflow: hidden;
        box-shadow: 0 0 2px #333;
        th{
          padding:0 8px;
          margin: 0;
          text-align: left;
          border-right: 1px solid #ccc;
          border-left: 1px solid #fff;
          flex-grow: 1;
          flex-shrink: 0;
        }
        th:first-of-type{
          border-left: none;
        }
        th:last-of-type{
          border-right: none;
        }
      }
    }
  }
  .t1{
    width: 78px;
    text-align: center !important;
  }
  .t2{
    max-width: 400px;
  }
  .t3{
    max-width: 90px;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
    margin: 0;
  }
</style>