<template>
  <ul class="main-nav">
    <li class="active">发现音乐</li>
    <li>我的音乐</li>
    <li>朋友</li>
    <li>商城</li>
    <li>音乐人</li>
    <li>下载客户端</li>
  </ul>
</template>

<script>
  export default {
    data() {
      return {
      }
    },
  }
</script>

<style lang="scss" scoped>
  .main-nav{
    display: flex;
    justify-content: left;
    align-items: center;
    font-size: 14px;
    color: #ccc;
    li{
      padding: 0 20px;
      height: 100%;
    }
    .active{
      background: url(./images/san.png) no-repeat center bottom;
    }
    li:hover,.active{
      color: #fff;
      background-color: #000;
    }
  }
</style>