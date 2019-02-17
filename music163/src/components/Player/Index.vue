<template>
  <div :style="{height:(isMobile&&isMPlayer)?'100%':'auto'}">
    <audio :src="musicInfo.src" ref="player" preload="auto" :autoplay="isPlay"></audio>
    <!-- 手机端样式 -->
    <div class="mPlayer-wrap" v-if="isMobile" :style="{transform:isMPlayer?'translateY(0)':'translateY(-200%)'}">
      <!-- 背景遮罩层 -->
      <div class="mask" >
        <div></div>
        <img :src="musicInfo.cover" style="height:100%">
      </div>
      <div class="topbar">
        <a class="break ifont" @click="goHide">&#xe616;</a>
        <div class="text-info">
          <a class="song" href="#">{{musicInfo.name}}</a>
          <a class="singer" href="#">{{musicInfo.singer}}</a>
        </div>
        <a class="ifont btn">&#xe66e;</a>
      </div>
      <div class="disk-wrap">
        <div class="disk" :style="{animationPlayState:isPlay?'running':'paused'}">
          <img :src="musicInfo.cover" class="cover">
          <img src="./images/disc.png" style="width:100%">
        </div>
      </div>
      <!-- 播放进度条 -->
      <div class="progress-wrap" @touchmove.stop="setProgress" @touchend.stop="endSlide" @mouseleave="slide.is=false">
        <p>{{currentTimeFormat}}</p>
        <div class="progress" ref="progress"  style="width:100%">
          <div class="el cache" :style="{width:bufferedWidth}"></div>
          <div class="el current" :style="{width:currentWidth}"></div>
          <!-- 用户点击后开启拖动进度条 -->
          <div class="dots" :style="{left:currentWidth}" @mousedown.stop="startSlide" @touchstart.stop="startSlide" >
            <i></i>
          </div>
        </div>
        <p>{{musicTimeFormat(musicInfo.duration)}}</p>
      </div>
      <div class="function-wrap">
        <a class="ifont btn" @click="changePlayMode" v-html="playModeIcon[playMode]"></a>
        <a class="ifont btn" @click="prev">&#xe698;</a>
        <a class="ifont paly btn" @click="play">{{isPlay?"&#xe662;":"&#xe60c;"}}</a>
        <a class="ifont btn" @click="next">&#xe6a1;</a>
        <a class="ifont btn">&#xe640;</a>
      </div>
    </div>


    <!-- pc端样式 -->
    <div :style="{bottom:isAutoDown?'0px':'-47px'}" @mouseenter="autoHide(true)" @mouseleave="autoHide(false)" class="player-wrap" v-else>
      <i class="lock ifont" @click="lock">{{isLock?'&#xe657;':'&#xe658;'}}</i>
      <div class="wrap">
        <div class="action-wrap">
          <a class="ifont btn" @click="prev">&#xe698;</a>
          <a class="ifont paly" @click="play">{{isPlay?"&#xe662;":"&#xe60c;"}}</a>
          <a class="ifont btn" @click="next">&#xe6a1;</a>
        </div>
        <div class="info-wrap">
          <img :src="musicInfo.cover" class="cover">
          <div class="box">
            <div class="text-info">
              <a class="song" href="#">{{musicInfo.name}}</a>
              <a class="ifont mv" href="#" title="MV">&#xe650;</a>
              <a class="singer" href="#">{{musicInfo.singer}}</a>
              <a class="ifont share" href="#" title="来自">&#xe7ff;</a>
            </div>
            <div class="play-info">
              <div class="progress-wrap" @mousemove.stop="setProgress" @mouseup.stop="endSlide" @mouseleave="slide.is=false">
                <div class="progress">
                  <div class="el cache" :style="{width:bufferedWidth}"></div>
                  <div class="el current" :style="{width:currentWidth}"></div>
                  <!-- 用户点击后开启拖动进度条 -->
                  <div class="dots" :style="{left:currentWidth}" @mousedown.stop="startSlide">
                    <i></i>
                  </div>
                </div>
              </div>
              <p class="time"><span style="width:34px">{{currentTimeFormat}}</span>/ {{musicTimeFormat(musicInfo.duration)}}</p>
            </div>
          </div>
        </div>
        <div class="function-wrap">
          <a class="ifont btn">&#xe638;</a>
          <a class="ifont btn">&#xe66e;</a>
          <i class="line"></i>
          <a class="ifont btn" @click="setVolume">{{isVolume?"&#xe623;":"&#xe60e;"}}</a>
          <a class="ifont btn" @click="changePlayMode" v-html="playModeIcon[playMode]"></a>
          <a class="ifont btn">&#xe640;</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        isLock: true,//播放器的锁定状态
        isAutoDown:true,//播放器是否自动下滑隐藏
        isPlay:false,//是否正在播放
        musicInfo:{},//歌曲信息
        currentTime:0,
        audio:null,
        buffered:0,//音乐已缓存部分
        playTimer:null,//音乐播放定时器
        hideTimer:null,//隐藏定时器
        //进度条滑动信息
        slide:{
          is:false,
          value:0,
          sp:0
        },
        palyList:[],//音乐播放记录
        nextId:0,//下一曲id
        isVolume:false,//音量图标
        playMode:0,//音乐播放模式
        playModeIcon:["&#xe66c;","&#xe66b;","&#xe66d;"],//音乐播放模式图标
        isMobile:false
      }
    },
    created:function(){
      this.isMobile=this.$store.state.isMobile
      this.getMusicInfo()
    },
    mounted() {
      this.audio=this.$refs["player"]
      this.musicInfo.duration=this.audio.duration
      // 开启音乐缓存监听器
      this.buffereMonitor();
    },
    methods:{
      // 播放器的锁定状态切换
      lock:function(){
        if(this.isLock){
          this.isLock=false
        }else{
          this.isLock=true;
        }
      },
      goHide:function(){
        this.$store.commit("setIsMPlayer",false)
      },
      // 获取音乐信息
      getMusicInfo:function(){
        // 说明：判断音乐id是否有效后获取音乐信息
        if(this.playId==this.musicInfo.id){
          return false
        }
        this.currentTime=0
        this.buffered=0
        this.hasMusicId(this.playId,()=>{
          this.ajax({
            methods:"get",
            url:"music/getMusicInfo",
            data:{
              id:this.playId
            }
          }).then(res=>{
            this.musicInfo=res.data
            this.palyList.push(this.musicInfo.id)
          })
        })
      },
      // 判读音乐id是否存在
      hasMusicId:function(mid,callfn1,callfn2=()=>{}){
        this.ajax({
            methods:"get",
            url:"music/hasId",
            data:{
              id:mid
            }
        }).then(res=>{
          let idInfo=res.data
          if(idInfo.state.includes("ok")){
            callfn1(res)
          }else{
            callfn2(res)
          }
        })
      },
      // 改变音乐切换模式
      changePlayMode:function(){
        this.playMode++;
        if(this.playMode>=3){
          this.playMode=0
        }
      },
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
      // 音乐播放暂停
      play:function(){
        if(this.audio.paused){
          this.audio.play()
          // 开启播放监听
          this.playMonitor()
          // 改变播放状态
          this.isPlay=true
        }else{
          this.audio.pause()
          // 关闭播放监听
          window.clearInterval(this.playTimer)
          this.isPlay=false
        }
      },
      // 下一曲
      next:function(){
        this.currentTime=0
        let id=this.playId+1
        this.hasMusicId(id,(res)=>{
          this.$store.commit("setPlayId",id)
        },(res)=>{
          this.$store.commit("setPlayId",res.data.nextId)
        })
      },
      // 上一曲
      prev:function(){
        let id=this.palyList[this.palyList.length-2]
        if(id){
          var index = this.palyList.indexOf(id); 
          if (index > -1) { 
            this.palyList.splice(index, 2); 
          } 
          this.$store.commit("setPlayId",id)
        }
      },
      // 设置音乐的声音
      setVolume:function(){
        if(this.audio.muted){
          this.audio.muted=false
        }else{
          this.audio.muted=true
        }
        this.isVolume=this.audio.muted
      },
      // 获取音乐缓存信息
      getBuffered:function(){
        var timeRages=this.audio.buffered
        var timeBuffered=0
        if(timeRages.length>0){
          timeBuffered = timeRages.end(timeRages.length - 1)
        }
        return timeBuffered;
      },
      // 音乐缓存监听
      buffereMonitor:function(){
        let timer=window.setInterval(()=>{
          this.buffered=this.getBuffered();
          if(this.buffered+20>=this.musicInfo.duration){
            this.buffered=this.musicInfo.duration
            window.clearInterval(timer)
          }
        },1000);
      },
      // 获取音乐播放进度时间
      getCurrentTime:function(){
        return this.audio.currentTime;
      },
      // 播放监听
      playMonitor:function(){
        this.playTimer=window.setInterval(()=>{
          if(this.slide.is==false){
            this.currentTime=this.getCurrentTime();
          }
          if(this.audio.ended){
            if(this.playMode==2){
              this.currentTime=0
              this.audio.play()
            }else{
              this.next()
            }
          }
        },1000);
      },
      // 音乐播放器自动隐藏显示
      autoHide:function(value){
        if(this.isLock==false){
          this.isAutoDown=value
        }
      },
      // 准备开始滑动
      startSlide:function(e){
        let screenX=e.screenX
        let pw=500
        if(this.isMobile){
          screenX=e.touches[0].screenX
          pw=this.$refs.progress.offsetWidth
        }
        this.slide={
          is:true,
          value:pw/this.musicInfo.duration,
          sp:this.currentTime,
          p:screenX
        }
      },
      endSlide:function(){
        if(this.slide.is){
          this.audio.currentTime=this.currentTime
        }
        this.slide={
          is:false,
          value:0,
          sp:0,
          p:0
        }
      },
      // 设置进度条
      setProgress:function(e){
        if(this.slide.is){
          let screenX=e.screenX
          if(this.isMobile){
            screenX=e.touches[0].screenX
          }
          let p=screenX-this.slide.p
          let ct=parseInt(this.slide.sp+(p/this.slide.value))
          if(ct>0&&ct<this.musicInfo.duration){
            this.currentTime=ct
          }
        }
      }
    },
    computed: {
      currentTimeFormat:function(){
        return this.musicTimeFormat(this.currentTime)
      },
      // 已缓存条宽度
      bufferedWidth:function(){
        return parseInt(this.buffered/this.musicInfo.duration*100) + "%"
      },
      // 当前播放宽度
      currentWidth:function(){
        let c=this.currentTime/this.musicInfo.duration*10000;
        c=parseInt(c);
        return  (c/100) + "%"
      },
      //正在播放音乐id
      playId:function(){
        return this.$store.state.playId;
      },
      isMPlayer(){
        return this.$store.state.isMPlayer;
      }
    },
    watch: {
      // 音乐信息自动获取
      playId:function(oldValue,newValue){
        if(oldValue!=newValue){
          this.getMusicInfo(newValue)
        }
      }
    },
  }
</script>

<style lang="scss" scoped>
// 手机版样式
.mPlayer-wrap{
  width: 100%;
  height: 100%;
  color: #fff;
  font-size: 12px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  position:fixed;
  top: 0;
  left: 0;
  transition: all 1s ease-in;
  z-index: 1000;
  overflow: hidden;
  a{
    color: #fff;
  }
  .mask{
    height: 140%;
    width: 100%;
    position: fixed;
    top: -5%;
    left: 0;
    z-index: -1;
    filter: blur(14px);
    div{
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background-color: rgba(00, 00, 00, 0.4);
      z-index: 2;
    }
    img{
      position: absolute;
      left: 50%;
      top: 0;
      transform: translateX(-50%);
      z-index: 1;
    }
  }
  .topbar{
    height: 0.9rem;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #c1c1c1;
    align-items: center;
    padding: 0 0.35rem;
    font-size: 18px;
    background-color:rgba(00,00,00,0.2);
    .text-info{
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: center;
    }
    .song{
      font-size: 16px;
    }
    .singer{
      font-size: 12px;
    }
  }
  .disk-wrap{
    display: flex;
    justify-content: center;
    .disk{
      position: relative;
      width: 6.12rem;
      height: 6.12rem;
      background: url(./images/disc.png) no-repeat center center;
      margin: 0.2rem 0;
      transform-origin:center center;
      animation:xhRotate linear 4s infinite;
      animation-fill-mode:forwards;
      img{
        position: absolute;
        z-index: 4;
      }
      .cover{
        z-index: 3;
        width: 3.9rem;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%)
      }
    }
  }
  @keyframes xhRotate
  {
    from {
      transform: rotateZ(0deg)
    }
    to {
      transform: rotateZ(360deg)
    }
  }

  .progress-wrap{
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 10px;
    p{
      margin: 0.2rem;;
    }
  }
  .function-wrap{
    font-size: 0.6rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.4rem;
    padding:0 0.2rem;
    .paly{
      font-size: 1rem;
    }
    .btn{
      margin: 0 0.2rem;
    }
  }
}
// pc版样式
.player-wrap{
  height: 47px;
  width: 100%;
  position:fixed;
  bottom: 0;
  left: 0;
  background: url(./images/bg.png) repeat-x 0 5px ;
  transition: bottom 1s ease;
  padding-top: 5px;
  .lock{
    color: #878787;
    text-shadow: 0 0 2px #000;
    background: url(./images/lock-bg.png) no-repeat;
    width:50px;
    height: 18px;
    position:absolute;
    right: 30px;
    top: -12px;
    text-align: center;
    font-size: 12px;
    line-height: 17px;
  }
  .lock:hover{
    color: #fff;
  }
  .wrap{
    width: 980px;
    margin: 0 auto;
    height: 100%;
    color:#999;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  a{
    color:#999;
    display: inline-block;
    cursor: pointer;
  }
  a:hover{
    color: #fff;
    text-shadow: 0 0 2px #fff;
  }
  .action-wrap{
    display: flex;
    flex-direction: row;
    align-items: center;
    .paly{
      height:34px ;
      width: 32px;
      font-size: 32px;
      color: #fff;
      margin: 0 12px;
      transition: all 0.5s ease;
    }
    .btn{
      width: 25px;
      height: 25px;
      font-size: 25px;
    }
  }
  .info-wrap{
    display: flex;
    margin-left: 35px;
    .cover{
      width: 32px;
      height: 32px;
      border-radius: 4px;
      border: 1px solid #000;
      overflow: hidden;
      margin-right: 15px;
      margin-top: 2px;
    }
    // 文本信息
    .text-info{
      line-height: 12px;
      padding-top: 2px;
      a{
        margin-right: 12px;
      }
      a:hover{
        color: unset;
        text-shadow: unset;
        text-decoration: underline;
      }
      .song{
        color: #e2e2e2;
      }
      .song:hover{
        color: #e2e2e2;
      }
      .share{
        font-size: 16px;
      }
    }
    .play-info{
      display: flex;
      align-items: center;
      .time{
        font-size: 12px;
        width: 100px;
        span{
          color: #fff;
          width: 38px;
          display: inline-block;
        }
      }
    }
    .progress-wrap{
      padding: 8px 0;
      margin-right: 14px;
      user-select: none;
    }
  }
  .function-wrap{
    display: flex;
    align-items: center;
    .btn{
      font-size: 18px;
      height: 18px;
      text-shadow: 0 0 1px #000;
      margin-left: 12px;
    }
    .line{
      height: 30px;
      width: 1px;
      margin-left: 14px;
      background: linear-gradient(to top,rgba(00,00,00,0),rgba(00,00,00,1),rgba(00,00,00,0))
    }
  }
}

// 进度条样式
.progress{
  width: 500px;
  height: 8px;
  border-radius: 4px;
  box-shadow: 0 1px 1px 0px #000; 
  background-color: #191919;
  position: relative;
  .el{
    height: 8px;
    border-radius: 4px;
    position: absolute;
  }
  .cache{
    background-color: #535353;
    width: 0;
  }
  .current{
    background-color:$mainColor;
    width: 0;
  }
  .dots{
  height: 16px;
  width: 16px;
  background-color: #eaeaeb;
  border-radius: 50%;
  margin-left: -4px;
  position: absolute;
  top: -4px;
  left: 0px;
  z-index: 20;
  cursor: pointer;
    i{
      display: block;
      background-color: $mainColor;
      width: 6px;
      height: 6px;
      border-radius: 50%;
      margin: 5px 0 0 5px;
    }
  }
  .dots:hover{
    box-shadow: 0 0 4px #fff;
  }
}
</style>