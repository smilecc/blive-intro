<template>
    <div>
        <div v-title>开源说明</div>
        <nav-banner></nav-banner>
        <opensource class="container"></opensource>
        <Footerbar></Footerbar>
    </div>
</template>

<script>
import opensource from '../markdown/opensource.md'
import '../assets/markdown.css'

export default {
    components: {
        opensource
    }
}
</script>