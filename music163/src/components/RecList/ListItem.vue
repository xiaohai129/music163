<template>
  <a class="list-item">
    <div class="cover" @click="playMusic">
      <img :src="cover">
      <div class="mask"></div>
      <div class="play-btn ifont">&#xe60c;</div>
    </div>
    <div class="text-info">
      <a class="title">{{songName}}</a>
      <a class="singer">{{singer}}</a>
    </div>
  </a>
</template>

<script>
  export default {
    props: {
      songName: String,
      singer: String,
      cover: String,
      duration: Number,
      id:Number
    },
    methods: {
      // 播放当前id音乐
      playMusic(){
        this.$store.commit("setPlayId",this.id)
        if(this.$store.state.isMobile){
          this.$store.commit("setIsMPlayer",true)
        }
      }
    },
  }
</script>

<style lang="scss" scoped>
.list-item{
  width: 140px;
  flex-shrink: 0;
  flex-grow: 0;
  margin-right: 42px;
  padding: 20px 0 10px 0;
  display: block;
  color: #000;
  cursor: pointer;
  .cover{
    position: relative;
    width: 140px;
    height: 140px;
    line-height: 140px;
    img{
      width: 100%;
    }
    .mask{
      position: absolute;
      background:url(./images/mask.png) no-repeat; 
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
    }
    .play-btn{
      position: absolute;
      background-color: rgba(00,00,00,0.4);
      font-size: 40px;
      color: #fff;
      display: none;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      text-align: center;
    }
  }
  .cover:hover .play-btn{
    display: block;
  }
  .text-info{
    a{
      display: block;
    }
    a:hover{
      text-decoration: underline;
    }
    .title{
      font-size: 15px;
      line-height: 18px;
      padding-top: 10px;
    }
    .singer{
      color: #666;
    }
  }
}
</style>