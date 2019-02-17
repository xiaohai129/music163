<template>
  <div class="login-btn-wrap">
    <a href="#" class="login-btn">登录<i class="ifont">&#xe607;</i></a>
    <ul class="down-box">
      <li><a href="#">手机号登录</a></li>
      <li><a href="#">手机号登录</a></li>
      <li><a href="#">手机号登录</a></li>
      <li><a href="#">手机号登录</a></li>
      <li><a href="#">手机号登录</a></li>
    </ul>
  </div>
</template>

<script>
  export default {
    
  }
</script>

<style lang="scss" scoped>
.login-btn-wrap{
  position: relative;
  .login-btn{
    width: 50px;
    display: flex;
    justify-content: space-between;
    color: #787878;
    padding-left:8px; 
    i{
      color: #454545;
    }
  }
  .login-btn:hover{
    color: #ccc;
  }
  ul{
    width: 158px;
    background-color: #2b2b2b;
    border: 1px solid #232323;
    position: absolute;
    top: 58px;
    left: 50%;
    margin-left: -79px;
    overflow: hidden;
    text-align: center;
    border-radius: 4px;
    display: none;
    z-index: 1000;
    li{
      line-height: 40px;
      height: 40px;
      box-sizing: border-box;
      border-bottom: 1px solid #232323;
      a{
         color: #cccccc;
      }
    }
    li:hover{
      background-color: #353535;
    }
    li:last-of-type{
      border: none;
    }
  }
}
.login-btn-wrap:hover > ul{
  display: block;
}
.login-btn-wrap:hover > .login-btn{
  color: #ccc;
}
</style>