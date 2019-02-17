// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import MApp from './MApp'
import router from './router'
import store from './state'
import axios from 'axios'

Vue.config.productionTip = false
// 自定义请求函数
Vue.prototype.ajax=function(obj){
  let result=null
  let baseUrl="http://148.70.57.157:8809/public/index/"
  if(obj.methods=="get"){
    let param=""
    Object.keys(obj.data).forEach(function(key){
      param+=key+"="
      param+=obj.data[key]+"&"
    })
    result=axios({
      methods:"post",
      url:baseUrl+obj.url+"?"+param,
    })
  }else{
    result=axios({
      methods:"post",
      url:baseUrl+obj.url,
      data:obj.data
    })
  }
  return result;
}

// 判断访问设备是否为pc端
let ispc=true
function isPc(){
  var system={win:!1,mac:!1,xll:!1},p=navigator.platform;
  system.win=0==p.indexOf("Win"),system.mac=0==p.indexOf("Mac"),system.x11="X11"==p||0==p.indexOf("Linux");
  var ua=navigator.userAgent,isMobile=ua.indexOf("iPad")>-1||ua.indexOf("iPhone")>-1||ua.indexOf("Android")>-1;
  if((system.win||system.mac||system.xll)&&(!isMobile)){
    return true
  }
  return false
}
function samResize(){
  var e=document.documentElement,
      i=e.clientWidth;
  i&&(e.style.fontSize=i/750*100+"px")
}

// 页面大小改变时自动重新加载网页
window.onresize=function(){
  if(isPc()!=ispc){
    window.location.reload()
  }
}

/* eslint-disable no-new */
if(ispc=isPc()){
  new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App/>'
  })
}else{
  samResize();
  new Vue({
    el: '#app',
    router,
    store,
    components: { MApp },
    template: '<MApp/>'
  })
}