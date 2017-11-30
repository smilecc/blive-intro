<template>
  <div class="intro">
    <div class="intro-title">简介卡生成器</div>
    <div class="intro-sub">一键生成出一个好看的简介卡</div>
  </div>
</template>

<script>
export default {
  name: 'banner'
}
</script>

<style>
  .intro {
    height: 205px;
    color: #fff;
    text-align: center;
    text-shadow: 0 1px 3px rgba(0,0,0,.4), 0 0 30px rgba(0,0,0,.075);
    background: #020031;
    background: -moz-linear-gradient(45deg,#020031 0,#6d3353 100%);
    background: -webkit-gradient(linear,left bottom,right top,color-stop(0%,#020031),color-stop(100%,#6d3353));
    background: -webkit-linear-gradient(45deg,#020031 0,#6d3353 100%);
    background: -o-linear-gradient(45deg,#020031 0,#6d3353 100%);
    background: -ms-linear-gradient(45deg,#020031 0,#6d3353 100%);
    background: linear-gradient(45deg,#020031 0,#6d3353 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#020031', endColorstr='#6d3353', GradientType=1);
    -webkit-box-shadow: inset 0 3px 7px rgba(0,0,0,.2), inset 0 -3px 7px rgba(0,0,0,.2);
    -moz-box-shadow: inset 0 3px 7px rgba(0,0,0,.2),inset 0 -3px 7px rgba(0,0,0,.2);
    box-shadow: inset 0 3px 7px rgba(0,0,0,.2), inset 0 -3px 7px rgba(0,0,0,.2);
  }
  .intro-title {
    padding-top: 30px;
    padding-bottom: 10px;
    font-size: 63px;
  }
  .intro-sub {
    font-size: 21px;
    padding-bottom: 25px;
  }
</style>
