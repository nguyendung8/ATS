<template>
    <div class="flex justify-between items-center h-full">
        <div>
            <nuxt-link to="/ats">
                <img
                    src="@/assets/images/logo-2.png"
                    alt="Logo"
                    title="Atlantic Careers"
                    class="logo"
                >
            </nuxt-link>
        </div>

        <!-- Thêm navigation menu ở giữa -->
        <div class="flex items-center space-x-6">
            <nuxt-link
                to="/ats"
                class="text-gray-700 hover:text-primary font-medium"
            >
                Trang chủ
            </nuxt-link>
            <nuxt-link
                to="/ats/about"
                class="text-gray-700 hover:text-primary font-medium"
            >
                Về chúng tôi
            </nuxt-link>
            <nuxt-link
                to="/ats/cv"
                class="text-gray-700 hover:text-primary font-medium"
            >
                Tạo CV
            </nuxt-link>
            <nuxt-link
                to="/ats/jobs"
                class="text-gray-700 hover:text-primary font-medium"
            >
                Tuyển dụng
            </nuxt-link>
        </div>

        <div class="flex items-center">
            <el-dropdown trigger="click" class="mr-3">
                <div class="flex items-center">
                    <img alt="language" :src="require(`~/assets/images/${$i18n.locale}.png`)">
                    <p class="ml-2">{{ $i18n.locale === 'en' ? 'English' : 'Vietnamese' }}</p>
                </div>
                <el-dropdown-menu slot="dropdown">
                    <nuxt-link
                        v-for="locale in locales"
                        :key="locale.value"
                        :to="switchLocalePath(locale.value)"
                    >
                        <el-dropdown-item
                            :class="{ 'el-dropdown-menu__item--active': $i18n.locale === locale.value }"
                        >
                            <div class="flex items-center">
                                <img alt="vi" :src="require(`~/assets/images/${locale.value}.png`)">
                                <p class="ml-2">{{ locale.label }}</p>
                            </div>
                        </el-dropdown-item>
                    </nuxt-link>
                </el-dropdown-menu>
            </el-dropdown>
            <el-dropdown trigger="click">
                <vue-avatar
                    :username="$get($auth.user, 'name', '')"
                    :src="`http://localhost:8000${$get($auth.user, 'profile_photo_url')}`"
                    :size="35"
                />
                <el-dropdown-menu slot="dropdown">
                    <nuxt-link to="/ats/my-profile/edit">
                        <el-dropdown-item class="flex items-center">
                            <span class="material-icons-outlined text-lg mr-1">person</span>
                            {{ $t('manage profile') }}
                        </el-dropdown-item>
                    </nuxt-link>
                    <nuxt-link to="/ats/cv">
                        <el-dropdown-item class="flex items-center">
                            <span class="material-icons-outlined text-lg mr-1">contact_page</span>
                            {{ $t('manage CV') }}
                        </el-dropdown-item>
                    </nuxt-link>
                    <nuxt-link to="/ats/history">
                        <el-dropdown-item class="flex items-center">
                            <span class="material-icons-outlined text-lg mr-1">history</span>
                            {{ $t('applied history') }}
                        </el-dropdown-item>
                    </nuxt-link>
                    <el-dropdown-item class="flex items-center" @click.native="logout">
                        <span class="material-icons-outlined text-lg mr-1">logout</span>
                        {{ $t('sign out') }}
                    </el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    import { LOCALES } from '~/enums/locales';

    export default {
        name: 'AppHeader',

        data() {
            return {
                locales: LOCALES,
            };
        },

        methods: {
            ...mapActions(['toggleSidebar']),
            async logout() {
                try {
                    await this.$auth.logout();
                } catch (error) {
                    this.$handleError(error);
                }
            },
        },
    };
</script>

<style lang="scss" scoped>
    .logo {
        height: 40px;
    }

    .text-primary {
        color: rgb(115 103 240);
    }

    // Thêm active class cho router-link-active
    .router-link-active {
        color: rgb(115 103 240);
    }
</style>
