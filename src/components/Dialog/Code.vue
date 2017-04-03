<template>
    <Modal
        v-model="isopen"
        width="800"
        :mask-closable="false"
        :closable="false">
        <Alert show-icon>
            请手动复制
            <template slot="desc">如果你无法通过点击复制按钮自动复制，那么可能是因为<strong>浏览器不兼容</strong>，所以请您手动全选下方的文本框中的内容，并复制。</template>
        </Alert>
        <Input v-model="value" type="textarea" :autosize="{maxRows: 20}"
                        ></Input>
        <div slot="footer">
            <Button type="primary" @click="ok">关闭</Button>
        </div>
    </Modal>
</template>

<script>
import { mapState } from 'vuex'

export default {
    props: {
        value: {
            type: String
        }
    },
    computed: {
        ...mapState({
            isopen: state => state.codeDialog
        })
    },
    methods: {
        ok () {
            this.$emit('close');
        }
    }
}
</script>