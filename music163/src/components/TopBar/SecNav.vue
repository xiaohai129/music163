<template>
  <div class="sec-nav">
    <ul class="wrap">
      <router-link :to="item.href" tag="li" v-for="(item, index) in navList" :key="index">{{item.title}}</router-link>
    </ul>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        navList:[
          {
            title:"推荐",
            href:"/index",
          },
          {
            title:"排行榜",
            href:"/ranklist",
          },
          {
            title:"歌单",
            href:"/no1",
          },
          {
            title:"主播电台",
            href:"/no2",
          },
          {
            title:"歌手",
            href:"/no3",
          },
          {
            title:"新碟上架",
            href:"/no4",
          }
        ]
      }
    },
  }
</script>

<style lang="scss" scoped>
  .sec-nav{
    background-color:$mainColor;
    padding: 2px 0;
    .wrap{
      width: 1100px;
      margin: 0 auto;
      padding-left: 178px;
      display: flex;
      box-sizing: border-box;
      color: #fff;
      align-items: center;
      justify-content: left;
      height: 32px;
    }
    li{
      padding: 0 12px;
      margin: 0 20px;
      border-radius: 10px;
      height: 20px;
      line-height: 20px;
      text-align: center;
      box-sizing: border-box;
      cursor: pointer;
      a{
        color: #fff;
      }
    }
    li:hover,.router-link-active{
      background-color: rgba(00, 00, 00, 0.4);
    }

  }
</style>