<template>
    <div class="px-10">
        <h4 class="mb-4 text-2xl font-semibold">Đăng ký tài khoản</h4>
        <p class="mb-10">Đăng ký tài khoản để sử dụng hệ thống</p>
        <el-form
            ref="form"
            :model="form"
            :rules="rules"
            label-position="top"
            class="mb-10"
        >
            <el-form-item
                :label="$t('name')"
                prop="name"
                :error="serverErrors.name"
                class="form-input"
            >
                <el-input v-model="form.name" placeholder="Nhập tên của bạn" />
            </el-form-item>

            <el-form-item
                :label="$t('email')"
                prop="email"
                :error="serverErrors.email"
                class="form-input"
            >
                <el-input v-model="form.email" placeholder="Nhập email của bạn" />
            </el-form-item>

            <el-form-item
                :label="$t('phone number')"
                prop="phone_number"
                :error="serverErrors.phone_number"
                class="form-input"
            >
                <el-input v-model="form.phone_number" placeholder="Nhập số điện thoại của bạn" />
            </el-form-item>

            <el-form-item :label="$t('password')" prop="password" :error="serverErrors.password">
                <el-input
                    v-model="form.password"
                    placeholder="..................."
                    show-password
                />
            </el-form-item>

            <el-form-item class="mt-8">
                <el-button
                    class="w-full"
                    type="primary"
                    @click="submitForm"
                >
                    Đăng ký
                </el-button>
            </el-form-item>
        </el-form>
        <div class="text-center mt-4">
            <span>Đã có tài khoản, </span>
            <router-link to="/login" class="text-blue-500 hover:text-blue-700">
                Đăng nhập ngay?
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'RegisterForm',

    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                phone_number: ''
            },
            rules: {
                name: [
                    { required: true, message: 'Tên là bắt buộc', trigger: 'blur' }
                ],
                email: [
                    { required: true, message: 'Email là bắt buộc', trigger: 'blur' },
                    { type: 'email', message: 'Định dạng email không hợp lệ', trigger: 'blur' }
                ],
                password: [
                    { required: true, message: 'Mật khẩu là bắt buộc', trigger: 'blur' },
                    { min: 6, message: 'Mật khẩu phải có ít nhất 6 ký tự', trigger: 'blur' }
                ],
                phone_number: [
                    { required: true, message: 'Số điện thoại là bắt buộc', trigger: 'blur' }
                ]
            },
            serverErrors: {}
        };
    },

    methods: {
        async submitForm() {
            try {
                await this.$refs.form.validate();

                await this.$axios.$post('/users/register', this.form);

                this.$message.success('Đăng ký thành công!');
                this.$router.push('/login');

            } catch (error) {
                if (error.response && error.response.data) {
                    this.serverErrors = error.response.data.errors || {};
                }
                this.$message.error('Có lỗi xảy ra khi đăng ký!');
            }
        }
    }
};
</script>

<style lang="scss" scoped>
    .form-input {
        margin-bottom: theme('spacing.4') !important;
    }

    .social-icon {
        height: 35px;
        width: 35px;
    }
</style>