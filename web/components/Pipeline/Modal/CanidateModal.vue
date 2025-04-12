<template>
    <el-dialog :visible.sync="visible" :title="$t('add candidate')">
        <el-form ref="form" :model="form" :rules="rules" label-position="top">
            <el-form-item :label="$t('name')" prop="name">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item :label="$t('email')" prop="email">
                <el-input v-model="form.email"></el-input>
            </el-form-item>
            <el-form-item :label="$t('phone number')" prop="phoneNumber">
                <el-input v-model="form.phoneNumber"></el-input>
            </el-form-item>
            <el-form-item :label="$t('resume')" prop="resume">
                <el-upload
                    ref="upload"
                    drag
                    :multiple="false"
                    :limit="1"
                    action="#"
                    :file-list="fileList"
                    :on-change="changeFileList"
                    :auto-upload="false"
                    :on-remove="removeFile"
                >
                    <i class="el-icon-upload" />
                    <div class="el-upload__text">
                        {{ $t('drop file here or') }} <em>{{ $t('click to upload') }}</em>
                    </div>
                </el-upload>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button @click="visible = false">{{ $t('cancel') }}</el-button>
            <el-button type="primary" @click="submit($refs.form)">{{ $t('submit') }}</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    data() {
        return {
            visible: false,
            form: {
                name: '',
                email: '',
                phoneNumber: '',
                resume: null,
            },
            fileList: [],
            rules: {
                name: [{ required: true, message: this.$t('validation.required', { field: this.$t('name') }), trigger: 'blur' }],
                email: [{ required: true, message: this.$t('validation.required', { field: this.$t('email') }), trigger: 'blur' }],
                phoneNumber: [{ required: true, message: this.$t('validation.required', { field: this.$t('phone number') }), trigger: 'blur' }],
                resume: [{ required: true, message: this.$t('validation.required', { field: this.$t('resume') }), trigger: 'change' }],
            },
        };
    },
    props: {
        jobId: {
            type: Number,
            required: true,
        },
    },
    methods: {
        changeFileList(file, fileList) {
            this.fileList = fileList;
            this.form.resume = file.raw;
        },
        removeFile() {
            this.form.resume = null;
        },
        async submit(formRef) {
            formRef.validate(async (valid) => {
                if (valid) {
                    try {
                        const formData = new FormData();
                        formData.append('name', this.form.name);
                        formData.append('email', this.form.email);
                        formData.append('phoneNumber', this.form.phoneNumber);
                        formData.append('resume', this.form.resume, this.form.resume.name);

                        await this.$axios.$post(`jobs/${this.jobId}/admin/candidates`, formData);

                        this.visible = false;
                        this.$emit('candidate-added');
                        
                        this.$message({
                            type: 'success',
                            message: this.$t('add candidate successfully')
                        });
                        
                        this.form = {
                            name: '',
                            email: '',
                            phoneNumber: '',
                            resume: null,
                        };
                        this.fileList = [];
                    } catch (error) {
                        this.$handleError(error);
                    }
                }
            });
        },
    },
};
</script>

<style scoped>
.el-select {
    width: 100%;
}
</style>
