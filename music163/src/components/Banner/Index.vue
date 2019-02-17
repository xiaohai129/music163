<template>
  <div class="banner" :style="bannerBg">
    <div class="content-wrap">
      <div class="img-box">
        <a href="#" :style="ImgSrc" @mouseenter="imgEnter" @mouseleave="imgLeave"></a>
        <ul class="action-dots">
          <li v-for="(item,index) in imgArr" :key="item.src" :class="{'active':index==imgIndex}"></li>
        </ul>
      </div>
      <div class="download">
        <a href="#" class="d-btn"></a>
      </div>
      <a href="javascript:void(0)" class="action-btn prev ifont" @click="imgChange('prev')">&#xe659;</a>
      <a href="javascript:void(0)" class="action-btn next ifont" @click="imgChange('next')">&#xe667;</a>
    </div>
  </div>
</template>

<script>
  import b1 from './images/b1.jpg'
  import b2 from './images/b2.jpg'
  import b3 from './images/b3.jpg'
  export default {
    data() {
      return {
        imgIndex:0,//当前显示图片索引
        imgTimer:null,//图片自动播放定时器
        imgArr: [
          {
            src:b1,
            bgColor:"#ff0000",
            href:"www.baidu.com"
          },
          {
            src:b2,
            bgColor:"#cdeaf2",
            href:"www.baidu.com"
          },
          {
            src:b3,
            bgColor:"#0000ff",
            href:"www.baidu.com"
          }
        ]
      }
    },
    created:function(){
      // 开启图片自动播放
      this.imgAutoPlay();
    },
    methods:{
      // banner图片切换
      imgChange:function(action){
        if(action){
          window.clearInterval(this.imgTimer);
          this.imgAutoPlay();
        }
        if(action=="prev"){
          this.imgIndex--;
          if(this.imgIndex<0){
            this.imgIndex=this.imgArr.length-1;
          }
        }else{
          this.imgIndex++;
          if(this.imgIndex>=this.imgArr.length){
            this.imgIndex=0
          }
        }
      },
      // 图片自动循环播放
      imgAutoPlay:function(){
        this.imgTimer=window.setInterval(()=>{
          this.imgChange();
        },4000);
      },
      // 用户悬停
      imgEnter:function(){
        window.clearInterval(this.imgTimer);
      },
      imgLeave:function(){
        this.imgAutoPlay();
      }
      
    },
    computed:{
      // banner图片
      ImgSrc:function(){
        return {
          backgroundImage:"url("+this.imgArr[this.imgIndex].src+")",
        }
      },
      // banner背景色
      bannerBg:function(){
        return {
          backgroundColor:this.imgArr[this.imgIndex].bgColor
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
.banner{
  .content-wrap{
    border: none;
    display: flex;
    position: relative;
  }
  .img-box{
    position: relative;
    justify-content: space-between;
    a{
      display: inline-block;
      transition:background 0.5s ease;
      width: 730px; 
      height: 336px;
      background-repeat: no-repeat;
      vertical-align: middle;
    }
    .action-dots{
      display: flex;
      position: absolute;
      bottom: 0;
      margin-bottom: 12px;
      justify-content: center;
      width: 100%;
      li{
        width: 6px;
        height: 6px;
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 0 2px #333;
        margin: 0 9px;
        cursor: pointer;
      }
      li:hover,.active{
        background-color: $mainColor;
      }
    }
  }
  // 上下切换按钮
  .action-btn{
    position: absolute;
    top: 50%;
    height: 64px;
    width: 36px;
    color: #fff;
    text-align: center;
    line-height: 64px;
    margin-top: -32px;
    font-size: 36px;
  }
  .action-btn:hover{
    background-color: rgba(00,00,00,0.4);
  }
  .prev{
    left: -58px;
  }
  .next{
    right: -58px;
  }
  // 桌面版软件下载
  .download{
    background: url(./images/download.png) no-repeat;
    width: 254px;
    height: 336px;
    .d-btn{
      width: 215px;
      height: 56px;
      display: block;
      margin: 212px 0 0 19px;
    }
    .d-btn:hover{
      background: url(./images/download.png) no-repeat bottom left;
    }
  }
}
</style>