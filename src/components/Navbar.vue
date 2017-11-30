<template>
    <div>
        <div class="layout">
            <Menu mode="horizontal" theme="primary" 
                    :active-name="activeName"
                    @on-select="routerSelect">
                <div class="layout-logo">Bilibili Live 简介卡生成器</div>
                <div class="layout-nav">
                    <Menu-item name="Home">
                        <Icon type="home"></Icon>
                        首页
                    </Menu-item>
                    <Menu-item name="UserProfile">
                        <Icon type="android-person"></Icon>
                        用户
                    </Menu-item>
                    <Menu-item name="FAQ">
                        <Icon type="help-circled"></Icon>
                        问题解答
                    </Menu-item>
                    <Menu-item name="OpenSource">
                        <Icon type="code"></Icon>
                        开源说明
                    </Menu-item>
                </div>
            </Menu>
        </div>
     </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
    computed: {
        ...mapState({
            activeName: state => state.navActiveName
        })
    },
    methods: {
        routerSelect (key) {
            this.$router.push({ name: key })
        }
    }
}    
</script>

<style scoped>
    .layout-nav {
        width: 415px;
        margin: 0 auto;
    }
    .layout-logo {
        color: #fff;
        font-size: 18px;
        float: left;
        position: relative;
        top: 0px;
        left: 60px;
        cursor: pointer;
    }
</style>