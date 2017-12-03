<template>
    <div>
        <div class="tag-title">制作与生成 <small>这些数据将会被自动保存，无须担心刷新页面</small></div>
        <Alert type="success" show-icon>
            新功能发布！不再烦恼图片不知如何上传、简介卡错位！
            <template slot="desc">
                <span>本工具新推出 <strong>自动获取直播间地址、免费图片上传、一键把简介发布到直播间</strong> 等功能！好用疯了！注册后即可使用！<router-link to="/user/register">点此立即注册</router-link></span>
            </template>
        </Alert>
        <Alert type="info" show-icon>
            提示
            <template slot="desc">
                <span>B站直播近期进行了页面改版，导致之前生成的代码无法自动适应，现在已经修复，重新生成即可适应新版页面。</span>
                <span>在此感谢<a href="https://github.com/CDog34" target="_blank">PeterCao</a>同学提交的PR。</span>
            </template>
        </Alert>
        <!--基础信息-->
        <Card>
            <p class="tag-subtitle" slot="title">基本信息</p>
            <Form :model="formItem" label-position="right" :label-width="120">
                <Form-item label="直播间地址">
                    <Input v-model="formItem.liveurl" placeholder="直播间地址，如 live.bilibili.com/35724，不要带http" @on-blur="autoSave">
                        <Button icon="search" slot="append" @click="getRoomId" v-if="isLogin">自动获取</Button>
                        <Button icon="search" slot="append" @click="$router.push('/user/login')" v-else>自动获取</Button>                        
                    </Input>
                </Form-item>
                <Form-item label="背景图片地址">
                    <Input v-model="formItem.bgimg" placeholder="背景图片地址" @on-blur="autoSave">
                        <Upload v-if="isLogin" action="http://api.bintro.smilec.cc/v1/image/upload" slot="append" name="image" :data="{ user_token: userToken, filename: '背景图片' }" :show-upload-list="false" :on-success="onUploadSuccess" :on-error="onUploadError" :before-upload="beforeUpload">
                            <Button icon="upload" @click="onUploadClick('bg')">上传图片</Button>
                        </Upload>
                        <Button icon="upload" slot="append" @click="$router.push('/user/login')" v-else>上传图片</Button>
                    </Input>
                </Form-item>
                <Form-item label="头像图片地址">
                    <Input v-model="formItem.displayimg" placeholder="头像图片地址（推荐大小 140×140像素）" @on-blur="autoSave">
                        <Upload v-if="isLogin" action="http://api.bintro.smilec.cc/v1/image/upload" slot="append" name="image" :data="{ user_token: userToken, filename: '头像' }" :show-upload-list="false" :on-success="onUploadSuccess" :on-error="onUploadError" :before-upload="beforeUpload">
                            <Button icon="upload" @click="onUploadClick('face')">上传图片</Button>
                        </Upload>
                        <Button icon="upload" slot="append" @click="$router.push('/user/login')" v-else>上传图片</Button>                        
                    </Input>
                </Form-item>
                <Form-item label="二维码地址">
                    <Input v-model="formItem.qrimg" placeholder="二维码图片地址（推荐大小 140×140像素）" @on-blur="autoSave">
                        <Upload v-if="isLogin" action="http://api.bintro.smilec.cc/v1/image/upload" slot="append" name="image" :data="{ user_token: userToken, filename: '二维码' }" :show-upload-list="false" :on-success="onUploadSuccess" :on-error="onUploadError" :before-upload="beforeUpload">
                            <Button icon="upload" @click="onUploadClick('qr')">上传图片</Button>
                        </Upload>
                        <Button icon="upload" slot="append" @click="$router.push('/user/login')" v-else>上传图片</Button>                        
                    </Input>
                </Form-item>
                <Form-item label="二维码下方说明">
                    <Input v-model="formItem.qrintro" placeholder="二维码下方说明内容，可写HTML"
                            @on-blur="autoSave"></Input>
                </Form-item>
                <Spin size="large" fix v-if="loading"></Spin>
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
                
                <Button type="error" size="large" icon="checkmark" @click="setIntroduce" v-if="isLogin">一键发布到直播间</Button>
                <Button type="error" size="large" icon="checkmark" @click="$router.push('/user/login')" v-else>立即登录，一键发布到直播间，不出差错！</Button>

                <Poptip :content="copyButton.tipInfo" placement="top">
                    <Button type="primary" size="large" icon="clipboard"
                            v-clipboard="buildResult" 
                            @click="codeCopied">复制代码</Button>
                </Poptip>

                <Button type="success" size="large" icon="help" @click="toLink('/faq')">使用教程</Button>
                <Button type="success" size="large" icon="alert" @click="codeDialog(true)">无法复制成功</Button>
                
                <p style="margin-top: 5px; font-size: 14px">在提交Cookie之后，一键发布到直播间功能能帮助你把生成出的简介直接发布到你的直播间，不会发生错位、文字丢失等问题，简单方便，不出丝毫差错！</p>
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
                loading: false,
                buildResult: '',
                copyButton: {
                    tipInfo: '复制完毕',
                    tipDisabled: true
                },
                uploadType: ''
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
                this.$http.post('http://bintro.smilec.cc/process/process.php', postObj, { emulateJSON: true }).then((response) => {
					var body = response.body;
                    this.buildResult = body
				});
                this.$http.post('http://api.bintro.smilec.cc/v1/bilibili/record_room', {
                    user_token: this.userToken,
                    room: this.formItem.liveurl
                }, { emulateJSON: true }).then((response) => {});
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
            },
            onUploadClick (type) {
                this.uploadType = type
            },
            beforeUpload () {
                this.loading = true
            },
            onUploadSuccess (response, file, fileList) {
                if (response.code === 1) {
                    switch (this.uploadType) {
                        case 'bg':
                            this.formItem.bgimg = response.url
                            break;
                        case 'face':
                            this.formItem.displayimg = response.url
                            break;
                        case 'qr':
                            this.formItem.qrimg = response.url
                            break;
                        default:
                            break;
                    }
                } else {
                    this.$Modal.error({
                        title: '上传失败',
                        content: response.msg
                    })
                }
                this.loading = false
            },
            onUploadError (error, file, fileList) {
                this.$Modal.error({
                    title: '上传失败',
                    content: '上传失败，请联系站长或稍后再试'
                })
                this.loading = false                
            },
            setIntroduce () {
                this.$Spin.show()
                this.$http.post('http://api.bintro.smilec.cc/v1/bilibili/set_introduce', {
                    user_token: this.userToken,
                    content: this.buildResult
                }, { emulateJSON: true }).then(response => {
                    let body = response.body
                    if (body.code === 1) {
                        this.$Notice.success({
                            title: 'Success',
                            desc: body.msg
                        })
                    } else {
                        this.$Modal.error({
                            title: 'Error',
                            content: body.msg
                        })
                    }
                    this.$Spin.hide()
                })
            },
            getRoomId () {
                this.loading = true
                this.$http.post('http://api.bintro.smilec.cc/v1/bilibili/get_roomid', {
                    user_token: this.userToken
                }, { emulateJSON: true }).then(response => {
                    let body = response.body
                    if (body.code === 1) {
                        this.formItem.liveurl = body.url
                        this.autoSave()
                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: body.msg
                        })
                    }
                    this.loading = false                    
                })
            }
        },
        computed: {
            ...mapState({
                tabs: state => state.tabs,
                userToken: state => state.user.userToken
            }),
            isLogin () {
                return (this.userToken && this.userToken.length > 0)
            }
        },
        mounted () {
            // 加载存储的数据
            let storage = JSON.parse(window.localStorage['baseConf'])
            if (storage.liveurl) this.formItem.liveurl = storage.liveurl
            if (storage.bgimg) this.formItem.bgimg = storage.bgimg
            if (storage.displayimg) this.formItem.displayimg = storage.displayimg
            if (storage.qrimg) this.formItem.qrimg = storage.qrimg
            if (storage.qrintro) this.formItem.qrintro = storage.qrintro

            if (this.formItem.liveurl === undefined || this.formItem.liveurl.length === 0) {
                if (this.isLogin) {
                    this.getRoomId()
                }
            }
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