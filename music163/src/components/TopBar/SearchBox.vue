<template>
  <div class="search-box">
    <div class="input-box">
      <input type="text" v-model="userInput" placeholder="音乐/视频/电台/用户" @blur="hideBox(false)" @focus="hideBox(true)">
      <i class="ifont">&#xe6aa;</i>
    </div>
    <div class="content" v-show="(userInput && isEnter)">
      <p class="title">以下是关于“{{userInput}}”的相关内容</p>
      <div class="list-box" v-if="songList">
        <p><i class="ifont">&#xe77e;</i>单曲</p>
        <ul>
          <li v-for="(item, index) in songList" :key="index" @click="playMusic(item.id)">
            {{item.name}}-{{item.singer}}
          </li>
        </ul>
      </div>
      <div class="list-box" v-if="singerList">
        <p><i class="ifont">&#xe61b;</i>歌手</p>
        <ul>
          <li v-for="(item, index) in singerList" :key="index">
            {{item.singer}}
          </li>
        </ul>
      </div>
      <div class="tips" v-if="(!singerList && !songList)">暂无相关信息</div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        userInput:"",//用户输入内容
        requestTimer:null,//用户输入请求定时器
        outTimer:null,//内容框退出定时器
        isEnter:false,//是否进入搜索区
        songList:null,
        singerList:null,
      }
    },
    methods: {
      playMusic:function(id){
        this.$store.commit("setPlayId",id)
      },
      hideBox:function(value){
        if(value){
          this.isEnter=true
          window.clearTimeout(this.outTimer)
        }else{
          this.outTimer=window.setTimeout(()=>{
            this.isEnter=false
            window.clearTimeout(this.outTimer)
          },200)
        }
      }
    },
    watch: {
      // 用户输入改变时请求数据
      userInput:function(){
        window.clearTimeout(this.requestTimer)
        if(!this.userInput){
          return false
        }
        this.requestTimer=window.setTimeout(()=>{
          // 发送请求获取用户搜索信息
          this.ajax({
            methods:"get",
            url:"music/getSongName",
            data:{
              keyword:this.userInput
            }
          }).then(res=>{
            let data=res.data.data
            if(data.length>0){
              this.songList=data
            }else{
              this.songList=null
            }
          })

          this.ajax({
            methods:"get",
            url:"music/getSingerName",
            data:{
              keyword:this.userInput
            }
          }).then(res=>{
            let data=res.data.data
            if(data.length>0){
              this.singerList=data
            }else{
              this.singerList=null
            }
          })
        },1000)
      }
    },
  }
</script>

<style lang="scss" scoped>
  .search-box{
    position: relative;
    .input-box{
      input{
        width: 158px;
        height: 32px;
        background-color: #fff;
        color: #484848;
        border-radius: 16px;
        padding:0 10px 0 24px;
        box-sizing: border-box;
      }
      i{
        height: 100%;
        position: absolute;
        top: 0;
        width: 18px;
        height: 18px;
        top: 50%;
        line-height: 18px;
        margin-top: -9px;
        padding-left: 8px;
      }
    }
    // 设置输入框提示字体颜色
    input::placeholder,input::-webkit-input-placeholder{
      color: #9b9b9b;
    }
    .content{
      position: absolute;
      top: 60px;
      left: 0;
      line-height: 32px;
      width: 240px;
      background-color: #fff;
      box-sizing: border-box;
      border: 1px solid #bebebe;
      border-radius: 4px;
      overflow: hidden;
      z-index: 999;
      box-shadow: 0 0 4px #333;
      .title{
        color: #676767;
        border-bottom: 1px solid #bebebe;
        padding:5px 10px;
        line-height: 20px;
      }
      .list-box{
        display: flex;
        line-height: 24px;
        p{
          width: 62px;
          text-align: center;
          padding-top: 5px;
          flex-shrink: 0;
          line-height: 18px;
          i{
            font-size: 18px;
          }
        }
        ul{
          border-left: 1px solid #bebebe;
          width: 100%;
          padding: 5px 0;
          border-bottom: 1px solid #bebebe;
        }
        li{
          height: 24px;
          overflow: hidden;
          padding-left: 10px;
          cursor: pointer;
        }
        li:hover{
          background-color: #e3e5e7;
        }
      }
      .tips{
        padding-left: 10px;
      }
      .list-box:nth-of-type(2n) ul{
        background-color: #f9f8f8;
      }
      .list-box:last-of-type ul{
        border-bottom: none;
      }
    }
  }
</style>