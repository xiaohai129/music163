<template>
  <div class="rec-list">
    <div  v-if="isMobile" class="m-box">
      <div class="list">
        <!-- 歌曲条目绑定 -->
        <list-item class="item" v-for="(item, index) in musicList" :key="index" 
          :songName="item.name"
          :singer="item.singer"
          :cover="item.cover"
          :duration="item.duration"
          :id="item.id"
        />
      </div>
    </div>
    <div v-else class="pc-box">
      <div class="title">
        <div class="left">
          <div class="dots"><i></i></div>
          热门推荐
          <ul>
            <li>华语</li>
            <li>流行</li>
            <li>摇滚</li>
            <li>民谣</li>
            <li>电子</li>
          </ul>
        </div>
        <a href="#" class="more">更多<i class="ifont">&#xe600;</i></a>
      </div>
      <div class="list">
        <!-- 歌曲条目绑定 -->
        <list-item class="item" v-for="(item, index) in musicList" :key="index" 
          :songName="item.name"
          :singer="item.singer"
          :cover="item.cover"
          :duration="item.duration"
          :id="item.id"
        />
      </div>
    </div>
  </div>
</template>

<script>
  import ListItem from "./listItem"
  export default {
    data() {
      return {
        musicList:[],//音乐列表
      }
    },
    components:{
      "list-item":ListItem
    },
    created() {
      this.getMusicList()
    },
    methods: {
      // 获取十条音乐信息
      getMusicList:function(v="",n=10){
        this.ajax({
          methods:"get",
          url:"music/getMusicList",
          data:{
            category:v,
            mum:n
          }
        }).then(res=>{
          this.musicList=res.data.data
        })
      }
    },
    computed: {
      isMobile(){
        return this.$store.state.isMobile;
      }
    },
  }
</script>

<style lang="scss" scoped>
.m-box{
  .list{
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    .item{
      flex-shrink: 1;
      margin: 20px;
      padding: 0;
    }
  }
}
.pc-box{
  width: 100%;
  .title{
    font-size: 20px;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 2px solid $mainColor;
    padding: 10px 0;
    .left{
      display: flex;
      align-items: center;
    }
    .dots{
      height: 14px;
      width: 14px;
      background-color: $mainColor;
      border-radius: 50%;
      margin-right: 10px;
      i{
        display: block;
        background-color: #fff;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        margin: 4px 0 0 4px;
      }
    }
    ul{
      display: flex;
      margin-left: 10px;
    }
    li{
      width: 52px;
      color: #666;
      border-right: 1px solid #ccc;
      font-size: 12px;
      height: 12px;
      line-height: 12px;
      text-align: center;
    }
    .more{
      color: #666;
      font-size: 12px;
      i{
        color:$mainColor;
        margin-left: 8px;
        font-weight: bold;
      }
    }
  }
  .list{
    display: flex;
    justify-content: left;
    flex-wrap: wrap;
    .item:nth-of-type(4n){
      margin-right: 0 !important;
    }
  }
}
</style>