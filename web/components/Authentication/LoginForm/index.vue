<template>
    <div class="px-10">
        <h4 class="mb-4 text-2xl font-semibold">{{ $t('welcome') }}</h4>
        <p class="mb-10">{{ $t('sign in title') }}</p>
        <el-form
            ref="form"
            :model="form"
            :rules="formRules"
            label-position="top"
            class="mb-10"
        >
            <el-form-item
                :label="$t('email')"
                prop="email"
                :error="serverErrors.email"
                class="form-input"
            >
                <el-input v-model="form.email" placeholder="john@example.com" />
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
                    @click="submit($refs.form, submitForm)"
                >
                    {{ $t('sign in') }}
                </el-button>
            </el-form-item>
        </el-form>
        <el-divider>{{ $t('or') }}</el-divider>
        <div class="flex justify-center">
            <img
                src="~/assets/images/google.png"
                alt="google"
                class="social-icon cursor-pointer mr-8"
                @click="loginWithGoogle"
            >
            <img
                src="~/assets/images/facebook.png"
                alt="facebook"
                class="social-icon cursor-pointer"
                @click="loginWithFacebook"
            >
        </div>
        <div class="text-center mt-4">
            <span>
                Bạn chưa có tài khoản,
            </span>
            <router-link to="/register" class="text-blue-500 hover:text-blue-700">
                Đăng ký ngay?
            </router-link>
        </div>
    </div>
</template>

<script>
    import formMixin from '~/mixins/form';
    import mixin from './mixin';

    export default {
        name: 'LoginForm',

        mixins: [formMixin, mixin],
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
