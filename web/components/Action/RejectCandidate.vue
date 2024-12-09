<template>
    <el-form
        ref="formSetting"
        :model="formSetting"
        :rules="formRules"
        size="medium"
    >
        <el-form-item :label="$t('send rejection mail to candidate')">
            <el-switch v-model="formSetting.is_send_mail" />
        </el-form-item>

        <el-button
            type="primary"
            :loading="processing"
            @click="submit($refs.formSetting, submitForm)"
        >
            {{ $t('save') }}
        </el-button>
    </el-form>
</template>

<script>
    import get from 'lodash/get';
    import _cloneDeep from 'lodash/cloneDeep';
    import formMixin from '~/mixins/form';

    export default {
        mixins: [formMixin],

        props: {
            action: {
                type: Object,
                required: true,
            },
            pipelineStageId: {
                type: Number,
                required: true,
            },
            addAction: {
                type: Function,
                required: true,
            },
            clearAction: {
                type: Function,
                required: true,
            },
        },
        data() {
            return {
                formSetting: {
                    is_send_mail: _cloneDeep(get(this.action, 'options.is_send_mail', false)),
                },
            };
        },
        watch: {
            // eslint-disable-next-line func-names
            'action.options': function (val) {
                this.formSetting.is_send_mail = get(val, 'is_send_mail', false);
            },
        },

        methods: {
            submitForm(data) {
                this.addAction(this.action.id, this.pipelineStageId, data);
                this.clearAction();
            },
        },
    };
</script>
