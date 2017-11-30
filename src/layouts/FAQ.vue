<template>
    <div>
        <div v-title>常见问题</div>
        <nav-banner></nav-banner>
        <div class="container">
            <tutorial id="tutorial"></tutorial>
            <hr />
            <faq id="faq"></faq>
        </div>
        <Footerbar></Footerbar>
    </div>
</template>

<script>
import tutorial from '../markdown/tutorial.md'
import faq from '../markdown/faq.md'
import '../assets/markdown.css'

export default {
    components: {
        tutorial,
        faq
    }
}
</script>