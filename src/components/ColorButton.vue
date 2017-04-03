<template>
    <a href="javascript:;" target="_self" 
        :style="{ backgroundColor: background, color: '#FFF' }"
        @click="onClick"><slot></slot></a>
</template>

<script>
    export default {
        props: {
            color: {
                type: String,
                default: 'pink'
            }
        },
        computed: {
            background () {
                switch (this.color) {
                    case 'pink':    return 'rgba(255, 89, 153, 0.901961)';
                    case 'green':   return 'rgba(102, 205, 170, 0.901961)';
                    case 'yellow':  return 'rgba(238, 201, 0, 0.901961)';
                    case 'orange':  return 'rgba(255, 165, 0, 0.901961)';
                    case 'blue':    return 'rgba(72, 118, 255, 0.901961)';
                    case 'gray':    return 'rgba(105, 105, 105, 0.901961)';
                    default:        return this.color;
                }
            }
        },
        methods: {
            onClick () {
                this.$emit('color-click', {
                    backgroundColor: this.background,
                    colorName: this.color
                });
            }
        }
    }
</script>

<style scoped>
    a {
        text-decoration:none;
        color: #FFF;
        border-radius: 2px;
        box-shadow: 1px 1px 15px rgba(51, 51, 51, 0.5);
        font-size: 16px;
        margin: 0px 15px 0px 0px;
        padding: 3px 5px;
    }
</style>