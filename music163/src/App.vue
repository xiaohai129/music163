<template>
  <div id="app">
    <xh-topbar/>
    <div class="c-wrap">
      <router-view></router-view>
    </div>
    <xh-footer/>
    <xh-player/>
  </div>
</template>

<script>
import TopBar from "./components/TopBar"
import Footer from "./components/Footer"
import Player from "./components/Player"
// css样式重置文件
import './common/reset.css'
export default {
  name: 'App',
  components:{
    "xh-topbar":TopBar,
    "xh-footer":Footer,
    "xh-player":Player
  },
  created() {
    this.$store.commit("setIsMobile",false)
    this.$router.push({path:'/index'})
  },
}
</script>

<style lang="scss">
  // 字体图标
@font-face {
  font-family: 'iconfont';  /* project id 1039190 */
  src: url('//at.alicdn.com/t/font_1039190_88v6babdonw.eot');
  src: url('//at.alicdn.com/t/font_1039190_88v6babdonw.eot?#iefix') format('embedded-opentype'),
  url('//at.alicdn.com/t/font_1039190_88v6babdonw.woff2') format('woff2'),
  url('//at.alicdn.com/t/font_1039190_88v6babdonw.woff') format('woff'),
  url('//at.alicdn.com/t/font_1039190_88v6babdonw.ttf') format('truetype'),
  url('//at.alicdn.com/t/font_1039190_88v6babdonw.svg#iconfont') format('svg');
}
  .ifont{
    font-family:"iconfont" !important;
    font-style:normal;
    -webkit-font-smoothing: antialiased;
    -webkit-text-stroke-width: 0.2px;
    -moz-osx-font-smoothing: grayscale;
    user-select:none;
  }
  body{
    background-color:#f5f5f5;
  }
  .c-wrap{
    min-height: 500px;
  }
  .content-wrap{
    width: 984px;
    margin: 0 auto;
    display: flex;
    box-sizing: border-box;
    border:solid #d3d3d3;
    border-width: 0 1px;
    background-color: #fff;
    .c-left{
      width: 730px;
      border-right: 1px solid #d4d4d4;
      padding: 20px;
      box-sizing: border-box;
    }
    .c-right{
      width: 250px;
      box-sizing: border-box;
    }
  }

</style>
