<template>
    <div>
        <tutorial id="tutorial"></tutorial>
        <hr />
        <faq id="faq"></faq>
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