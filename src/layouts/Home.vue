<template>
  <div>
    <div v-title>首页</div>
    <nav-banner></nav-banner>
    <div class="container">
      <demo></demo>
      <maker></maker>
    </div>
    <Footerbar></Footerbar>
  </div>
</template>

<script>
import Demo from '@/components/Demo'
import Maker from '@/components/Maker'

export default {
  components: {
    Demo,
    Maker
  },
  name: 'app'
}
</script>