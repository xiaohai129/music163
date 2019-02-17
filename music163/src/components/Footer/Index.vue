<template>
  <div class="footer-wrap">
    <div class="wrap">
      <ul class="link-nav">
        <li><a href="#">关于网易</a></li>  
        <li><a href="#">客户服务</a></li> 
        <li><a href="#">服务条款</a></li> 
        <li><a href="#">网站导航</a></li> 
        <li><a href="#">意见反馈</a></li> 
      </ul>
      <p class="copyright">
        网易公司版权所有©1997-2019杭州乐读科技有限公司运营：浙网文[2018]3506-263号<br>
        违法和不良信息举报电话：0571-89853516 举报邮箱：ncm5990@163.com
      </p>
    </div>
  </div>
</template>

<script>
  export default {
    
  }
</script>

<style lang="scss" scoped>
.footer-wrap{
  background-color: $footerBg;
  padding:20px 0 66px 0;
  border-top: 1px solid #d3d3d3;
  color: #666;
  .wrap{
    width: 980px;
    margin: 0 auto;
  }
  .link-nav{
    height: 14px;
    display: flex;
    li{
      line-height: 14px;
      border-left: 1px solid #c2c2c2;
      padding: 0 12px;
    }
    li:first-of-type{
      padding-left: 0;
      border-left: none;
    }
    a{
      color: #a2a2a2;
    }
  }
  .copyright{
    margin-top: 10px;
    line-height: 26px;
  }
}
</style>