import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Index from "../pages/Index"
import RankList from "../pages/RankList/Index"
import MRankList from "../pages/RankList/MIndex"
export default new Router({
  // mode: 'history',
  routes: [
    {
      path: '/index',
      name: 'index',
      component: Index
    },
    {
      path: '/rankList',
      name: 'rankList',
      component: RankList
    },
    {
      path: '/',
      redirect:'index'
    },
    {
      path: '/m/index',
      component:MRankList
    }
  ]
})
