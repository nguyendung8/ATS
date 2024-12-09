<template>
    <el-dialog
        :visible.sync="show"
        :title="$t('disqualification reason')"
        width="700px"
        class="pt-0"
        @close="onClose"
    >
        <el-form
            ref="form"
            :model="form"
            :rules="formRules"
            size="medium"
            label-position="top"
        >
            <el-form-item
                :label="label"
                prop="rejection_id"
            >
                <el-radio-group v-model="form.rejection_id">
                    <ul class="text-lg list-none pl-0">
                        <li v-for="(rejection, index) in rejections" :key="index" class="pb-4">
                            <el-radio :label="$get(rejection, 'id')">
                                {{ $get(rejection, 'reason') }}
                            </el-radio>
                        </li>
                    </ul>
                </el-radio-group>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button plain @click="onClose">
                {{ $t('cancel') }}
            </el-button>
            <el-button
                type="danger"
                @click="submit($refs.form, submitForm)"
            >
                {{ $t('reject') }}
            </el-button>
        </span>
    </el-dialog>
</template>
<script>
    import formMixin from '~/mixins/form';
    import mixin from './mixin';

    export default {
        name: 'RejectionForm',

        mixins: [formMixin, mixin],
    };
</script>
