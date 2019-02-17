<template>
  <div id="mapp">
    <router-view></router-view>
    <xh-player/>
  </div>
</template>

<script>
// css样式重置文件
import './common/reset.css'
import Player from "./components/Player"
export default {
  name: 'MApp',
  components:{
    'xh-player':Player
  },
  created:function(){
    this.$store.commit("setIsMobile",true)
    this.$router.push({path:'/m/index'})
  },
  computed: {
   
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
  html,body{
    height: 100%;
  }
  #mapp{
    height: 100%;
  }
</style>
