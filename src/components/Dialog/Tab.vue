<template>
    <div>
        <Modal
            v-model="isopen"
            title="选项卡编辑"
            width="600"
            :mask-closable="false"
            :closable="false">
            <Form :model="tabFormItem" :label-width="80">
                <Form-item label="选项卡名">
                    <Input v-model="tabFormItem.name" placeholder="选项卡的名称"></Input>
                </Form-item>
                <Form-item label="颜色选择">
                    <ColorButton color="pink" @color-click="colorChoose">粉红</ColorButton>
                    <ColorButton color="green" @color-click="colorChoose">绿色</ColorButton>
                    <ColorButton color="yellow" @color-click="colorChoose">金黄</ColorButton>
                    <ColorButton color="orange" @color-click="colorChoose">橙色</ColorButton>
                    <ColorButton color="blue" @color-click="colorChoose">蓝色</ColorButton>
                    <ColorButton color="gray" @color-click="colorChoose">深灰</ColorButton>
                    <Input v-model="tabFormItem.color" placeholder="选项卡颜色，可点击上方选择，也可以手动输入RGBA值"></Input>                    
                </Form-item>
                <Form-item label="内容介绍">
                    <Input v-model="tabFormItem.intro" type="textarea" :autosize="{minRows: 3,maxRows: 5}" 
                            placeholder="选项卡中所对应的内容，可多行，也可写HTML，长度请自己定夺"></Input>
                </Form-item>
            </Form>
            <div slot="footer">
                <Button type="error" v-show="nowTab!==null" @click="del">删除</Button>
                <Button type="ghost" @click="cancel">取消</Button>
                <Button type="primary" @click="ok">确定</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
import ColorButton from '../ColorButton'
import { mapState } from 'vuex'

export default {
    components: {
        ColorButton
    },
    data () {
        return {
            tabFormItem: {
                    name: '',
                    color: '',
                    intro: '',
                    colorname: ''
                },
            nowTab: null
        }
    },
    computed: {
        ...mapState({
            isopen: state => state.tabDialog
        })
    },
    watch: {
        isopen (newValue) {
            if (newValue) {
                this.nowTab = this.$store.state.tabInfo.nowTab;
                if (this.nowTab !== null) {
                    this.tabFormItem.name = this.nowTab.name;
                    this.tabFormItem.color = this.nowTab.color;
                    this.tabFormItem.intro = this.nowTab.intro;
                    this.tabFormItem.colorname = this.nowTab.colorname;
                }
            }
        }
    },
    methods: {
        ok () {
            let formData = JSON.parse(JSON.stringify(this.tabFormItem));
            if (this.checkForm(formData) === false) {
                return;
            }

            if (this.nowTab !== null) {
               this.$store.commit('modifyTab', {
                   tabid: this.nowTab.id,
                   tab: formData
               });
            } else {
                this.$store.commit('addTab', formData);
            }
            this.close();
        },
        cancel () {
            this.close();
        },
        del () {
            this.$Modal.confirm({
                title: '删除确认',
                content: '<p>是否确认删除这个选项卡？</p>',
                onOk: () => {
                    this.$store.commit('delTab', {
                        tabid: this.nowTab.id
                    });
                    this.$Message.success('删除成功');
                    this.close();
                }
            });
        },
        colorChoose (colorObj) {
            this.tabFormItem.color = colorObj.backgroundColor;
            this.tabFormItem.colorname = colorObj.colorName;
        },
        close () {
            this.$emit('close', this.background);
            this.tabFormItem.name = '';
            this.tabFormItem.color = '';
            this.tabFormItem.intro = '';
            this.tabFormItem.colorname = '';

            // 自动保存
            window.localStorage.setItem('tabs', JSON.stringify(this.$store.state.tabs))
        },
        checkForm (formData) {
            if (formData.name.length == 0) {
                this.$Message.error('请填写选项卡名称');
                return false;
            }
            if (formData.color.length == 0) {
                this.$Message.error('请选择一个颜色');
                return false;
            }
            if (formData.intro.length == 0) {
                this.$Message.error('请填写内容介绍');
                return false;
            }
            if (formData.colorname.length == 0) {
                this.$Message.error('请重新选择一个颜色');
                return false;
            }

            return true;
        }
    }
}
</script>