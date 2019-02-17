import Vue from 'vue'
import Vuex from 'vuex';

Vue.use(Vuex)

export default new Vuex.Store({
  state:{
    playId:1,//正在播放音乐id
    isMobile:false,//是否正在手机上访问
    isMPlayer:false,//是否显示手机版播放器
  },
  mutations:{
    setPlayId:function(state,id){
      state.playId=id
    },
    setIsMobile:function(state,value){
      state.isMobile=value
    },
    setIsMPlayer:function(state,value){
      state.isMPlayer=value
    }
  }
})