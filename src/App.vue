<template>
  <div id="app">
    <Navbar></Navbar>
    <div>
      <router-view></router-view>    
    </div>
    <Back-top></Back-top>
  </div>
</template>

<script>
import Navbar from '@/components/Navbar'

export default {
  components: {
    Navbar
  },
  name: 'app'
}
</script>

<style>
  .tag-title {
    margin-top: 20px;
    margin-bottom: 10px;
    font-size: 24px;
    color: #000;
  }

  .tag-subtitle {
    font-size: 18px;
    margin-top: 10px;
    margin-bottom: 10px;
    color: #000;
  }

  .tag-title small{
    color: #777;
    font-size: 60%;
  }
  .tag-subtitle small{
    color: #777;
    font-size: 75%;
  }

  @media (min-width: 768px) {
      .container {
          width:750px
      }
  }

  @media (min-width: 992px) {
      .container {
          width:970px
      }
  }

  @media (min-width: 1200px) {
      .container {
          width:1170px
      }
  }

  .container {
    margin-top: 30px;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto
  }

  hr {
    margin-top: 20px !important;
    margin-bottom: 20px !important;
    border: 0;
    border-top: 1px solid #eee;
  }
</style>