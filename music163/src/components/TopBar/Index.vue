<template>
  <div class="top-bar">
    <div class="wrap clearFix">
      <a href="#" class="logo"></a>
      <!-- 主导航 -->
      <main-nav/>
      <!-- 用户功能区 -->
      <div class="user-action">
        <search-box/>
        <!-- 创作者按钮 -->
        <a href="#" class="creators-btn">创作者中心</a>
        <login-btn-down/>
      </div>
    </div>
    <!-- 主导航下级导航 -->
    <sec-nav/>
  </div>
</template>

<script>
import MainNav from "./MainNav"
import SearchBox from "./SearchBox"
import LoginBtnDown from "./LoginBtnDown"
import SecNav from "./SecNav"
export default {
  data() {
    return {};
  },
  components:{
    "main-nav":MainNav,
    "search-box":SearchBox,
    "login-btn-down":LoginBtnDown,
    "sec-nav":SecNav
  }
};
</script>

<style lang="scss">
.top-bar {
  background-color: $secColor;
  .wrap{
    width: 1100px;
    margin: 0 auto;
    height: 70px;
    line-height: 70px;
  }
  .logo{
    height: 70px;
    width: 178px;
    display: block;
    background: url(./images/logo.png) no-repeat center left;
    float: left;
  }
  .main-nav{
    float: left;
  }
  .user-action{
    float: right;
    display: flex;
    justify-content: right;
    align-items: center;
    .creators-btn{
      width: 90px;
      height: 32px;
      border: 1px solid #4f4f4f;
      box-sizing: border-box;
      color: #c6c6c6;
      font-size: 12px;
      border-radius: 16px;
      margin: 0 12px;
      line-height: 32px;
      text-align: center;
    }
    .creators-btn:hover{
      border-color: #cccccc;
    }
  }
}
</style>