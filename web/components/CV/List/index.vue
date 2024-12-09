<template>
    <div>
        <h1 class="text-xl font-semibold mb-5 capitalize">{{ $t('your cv') }}</h1>
        <el-row :gutter="40">
            <el-col
                v-for="resume in resumes"
                :key="$get(resume, 'id')"
                :span="6"
                class="mb-10"
            >
                <el-card :body-style="{ padding: '0px' }">
                    <nuxt-link :to="`/ats/cv/${resume.uuid}/edit`">
                        <img :src="$get(resume, 'template.imageUrl')">
                    </nuxt-link>
                    <div>
                        <div class="w-full">
                            <nuxt-link :to="`/ats/cv/${resume.uuid}/edit`">
                                <el-button
                                    plain
                                    size="small"
                                    class="editBtn"
                                    icon="el-icon-edit"
                                >
                                    {{ $t('edit') }}
                                </el-button>
                            </nuxt-link>
                            <el-button
                                type="primary"
                                size="small"
                                class="deleteBtn"
                                icon="el-icon-delete"
                                @click="deleteResume(resume.uuid)"
                            >
                                {{ $t('delete') }}
                            </el-button>
                        </div>
                    </div>
                </el-card>
                <div class="pt-5">
                    <span class="text-base italic">
                        {{ $t('last edit') }} {{ lastActivityDate($get(resume, 'updatedAt')) }}
                    </span>
                </div>
            </el-col>
        </el-row>
        <div class="border-t pt-5">
            <h1 class="text-xl font-semibold mb-5 capitalize">{{ $t('cv templates') }}</h1>
            <el-row :gutter="40">
                <el-col
                    v-for="resume in resumeTemplates"
                    :key="$get(resume, 'id')"
                    :span="6"
                    class="mb-10"
                >
                    <el-card :body-style="{ padding: '0px' }">
                        <img
                            :src="$get(resume, 'imageUrl')"
                            @click="createResume($get(resume, 'id'))"
                        >
                        <div class="w-full">
                            <el-button
                                type="primary"
                                size="small"
                                class="deleteBtn"
                                @click="createResume($get(resume, 'id'))"
                            >
                                {{ $t('use this template') }}
                            </el-button>
                        </div>
                    </el-card>
                </el-col>
            </el-row>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        name: 'CVList',

        components: {
        },

        props: {
            resumes: {
                type: Array,
                required: true,
            },
            resumeTemplates: {
                type: Array,
                required: true,
            },
            deleteResume: {
                type: Function,
                required: true,
            },
        },

        methods: {
            lastActivityDate(date) {
                return moment(date).fromNow();
            },
            async createResume(resumeTemplateId) {
                try {
                    const { data: resume } = await this.$axios.$post('resumes', {
                        resumeTemplateId,
                    });

                    this.$router.push(`/ats/cv/${resume.uuid}/edit`);
                } catch (error) {
                    this.$handleError(error);
                }
            },
        },
    };
</script>

<style lang="scss" scoped>
    .deleteBtn {
        width: 100%;
        margin: unset !important;
        border: unset !important;
        border-radius: 0px !important;
    }
    .editBtn {
        width: 100%;
        margin: unset !important;
        border: unset !important;
        background-color: theme('colors.light') !important;
    }
</style>
