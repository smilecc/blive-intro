<template>
    <div>
        <div class="tag-title">制作与生成 <small>这些数据将会被自动保存，无须担心刷新页面</small></div>
        <Alert type="success" show-icon v-if="false">
            提示
            <template slot="desc">如果遇到任何的问题，可以加Q群 610085689 询问，没事也欢迎进群吹逼。</template>
        </Alert>
        <!--基础信息-->
        <Card>
            <p class="tag-subtitle" slot="title">基本信息</p>
            <Form :model="formItem" label-position="right" :label-width="120">
                <Form-item label="直播间地址">
                    <Input v-model="formItem.liveurl" placeholder="直播间地址，如 http://live.bilibili.com/35724"
                            @on-blur="autoSave"></Input>
                </Form-item>
                <Form-item label="背景图片地址">
                    <Input v-model="formItem.bgimg" placeholder="背景图片地址"
                            @on-blur="autoSave"></Input>
                </Form-item>
                <Form-item label="头像图片地址">
                    <Input v-model="formItem.displayimg" placeholder="头像图片地址（推荐大小 140×140像素）"
                            @on-blur="autoSave"></Input>
                </Form-item>
                <Form-item label="二维码地址">
                    <Input v-model="formItem.qrimg" placeholder="二维码图片地址（推荐大小 140×140像素）"
                            @on-blur="autoSave"></Input>
                </Form-item>
                <Form-item label="二维码下方说明">
                    <Input v-model="formItem.qrintro" placeholder="二维码下方说明内容，可写HTML"
                            @on-blur="autoSave"></Input>
                </Form-item>
            </Form>
        </Card>

        <!--选项卡对话框-->
        <TabDialog @close="tabDialog(2)"></TabDialog>
        <CodeDialog @close="codeDialog(false)" v-model="buildResult"></CodeDialog>

        <!--选项卡管理-->
        <div class="tag-subtitle tab">选项卡设置 <small>最少需要创建一个选项卡</small></div>
        <hr />
        <div>
            <div class="tab-group">
                <ColorButton v-for="(tab, index) in tabs" 
                                @color-click="tabDialog(3, tab.id)"
                                :color="tab.colorname"
                                :key="tab.id">{{ tab.name }}</ColorButton>
            </div>
            <Button type="primary" size="large" icon="plus-round" @click="tabDialog(1)">增加一个选项卡</Button>
            <Button type="success" size="large" icon="log-in" @click="startBuild">开始生成</Button>
        </div>

        <!--生成结果展示-->
        <div class="result-display" v-show="buildResult !== ''">
            <hr />
            <div class="tag-subtitle tab">生成结果 <small>只做一个初步展示，点击选项卡会跳转，请复制到直播间查看完整功能</small></div>
            <div v-html="buildResult"></div>
            
            <div class="result-buttons">
                <Poptip :content="copyButton.tipInfo" placement="top">
                    <Button type="primary" size="large" icon="clipboard"
                            v-clipboard="buildResult" 
                            @click="codeCopied">复制代码</Button>
                </Poptip>

                <Button type="success" size="large" icon="help" @click="toLink('/faq')">使用教程</Button>
                <Button type="success" size="large" icon="alert" @click="codeDialog(true)">无法复制成功</Button>
            </div>
        </div>
    </div>
</template>

<script>
    import ColorButton from './ColorButton'
    import TabDialog from './Dialog/Tab'
    import CodeDialog from './Dialog/Code'
    import { mapState } from 'vuex'

    export default {
        components: {
            ColorButton,
            TabDialog,
            CodeDialog
        },
        data () {
            return {
                formItem: {
                    liveurl: '',
                    bgimg: '',
                    displayimg: '',
                    qrimg: '',
                    qrintro: ''
                },
                tabDialogModel: false,
                buildResult: '',
                copyButton: {
                    tipInfo: '复制完毕',
                    tipDisabled: true
                }
            }
        },
        methods: {
            tabDialog (option, id) {
                if (option === 1) {
                    this.$store.commit('tabDialog', true)
                } else if (option === 2) {
                    this.$store.commit('tabDialog', false)
                } else if (option === 3) {
                    this.$store.commit('tabDialog', {
                        status: true,
                        tabid: id
                    })
                }
            },
            codeDialog (option) {
                this.$store.commit('codeDialog', option)
            },
            autoSave () {
                window.localStorage.setItem('baseConf', JSON.stringify(this.formItem))
            },
            startBuild () {
                if (this.checkForm() === false) {
                    return;
                }

                let postObj = JSON.parse(JSON.stringify(this.formItem))
                postObj.tabs = JSON.stringify(this.$store.state.tabs)
                this.$http.post('/process/process.php', postObj, { emulateJSON: true }).then((response) => {
					var body = response.body;
                    this.buildResult = body
				});
            },
            checkForm () {
                if (this.formItem.liveurl.length === 0) {
                    this.$Notice.error({
                        title: '请填写直播间地址',
                        desc: '直播间地址不能为空'
                    });
                    return false;
                }
                if (this.formItem.bgimg.length === 0) {
                    this.$Notice.error({
                        title: '请填写背景图片地址',
                        desc: '背景图片地址不能为空'
                    });
                    return false;
                }
                if (this.formItem.displayimg.length === 0) {
                    this.$Notice.error({
                        title: '请填写头像图片地址',
                        desc: '头像图片地址不能为空'
                    });
                    return false;
                }
                if (this.formItem.qrimg.length === 0) {
                    this.$Notice.error({
                        title: '请填写二维码地址',
                        desc: '二维码地址不能为空'
                    });
                    return false;
                }
                if (this.formItem.qrintro.length === 0) {
                    this.$Notice.error({
                        title: '请填写二维码下方说明',
                        desc: '二维码下方说明不能为空'
                    });
                    return false;
                }
                if (this.$store.state.tabs.length === 0) {
                    this.$Notice.error({
                        title: '请最少创建一个选项卡',
                        desc: '不能生成不包含任何选项卡的简介卡'
                    });
                    return false;
                }

                return true;
            },
            codeCopied () {
                this.copyButton.tipDisabled = false
                setTimeout(() => {
                    this.copyButton.tipDisabled = true
                }, 1000);
            },
            toLink (option) {
                this.$router.push(option)
            }
        },
        computed: mapState({
            tabs: state => state.tabs
        }),
        mounted () {
            // 加载存储的数据
            this.formItem = JSON.parse(window.localStorage['baseConf'])
            this.$store.commit('loadTab')
        }
    }
</script>

<style scoped>
    .result-display {
        font-size: 12px;
        box-sizing: border-box;
        max-height: 310px;
        position: relative;
        line-height: 1.5;
        color: rgb(100, 108, 122);
        width: 1153px;
        transform: translate(0px, 0px);
    }
    .tab-group {
        margin-bottom: 20px;
    }
    .tag-subtitle.tab {
        margin-top: 30px;
    }
    .result-buttons {
        margin-top: 30px;
    }
</style>