<template>
    <div class="flex-auto">
        <div class="flex justify-between items-center mb-8">
            <h5 class="text-xl font-semibold uppercase">{{ $t("working experience") }}</h5>
            <el-button
                type="primary"
                size="mini"
                class="capitalize"
                @click="openExperienceForm(null)"
            >
                <span class="material-icons-outlined">add</span>
                {{ $t("experience") }}
            </el-button>
        </div>
        <el-row :gutter="40">
            <el-col
                v-for="item in $get($auth.user, 'candidate.experiences')"
                :key="$get(item, 'id')"
                :span="12"
                :xl="8"
                class="mb-10"
            >
                <el-card :body-style="{ padding: '0px' }">
                    <div class="flex justify-center">
                        <img class="h-40 mt-5" :src="require('~/assets/images/suitcase.png')">
                    </div>
                    <div class="p-5">
                        <div class="text-lg text-text font-semibold">{{ $get(item, 'company_name') }}</div>
                        <div class="text-base">{{ getDate(item) }}</div>
                        <div class="text-base">{{ $get(item, 'location') }}</div>
                    </div>
                    <div class="flex justify-between">
                        <el-button
                            plain
                            size="small"
                            icon="el-icon-edit"
                            class="editBtn"
                            @click="openExperienceForm(item)"
                        >
                            {{ $t('edit') }}
                        </el-button>
                        <el-button
                            type="primary"
                            size="small"
                            icon="el-icon-delete"
                            class="deleteBtn"
                            @click="deleteExperience($get(item, 'id'))"
                        >
                            {{ $t('delete') }}
                        </el-button>
                    </div>
                </el-card>
            </el-col>
        </el-row>
        <ExperienceForm ref="experienceForm" />
    </div>
</template>

<script>
    import moment from 'moment';
    import ExperienceForm from './ExperienceForm.vue';

    export default {
        name: 'ExperienceList',

        components: {
            ExperienceForm,
        },

        methods: {
            openExperienceForm(experience) {
                this.$refs.experienceForm.open(experience);
            },
            getDate(experience) {
                const startDate = moment(this.$get(experience, 'start_date')).format('DD/MM/YYYY');
                const endDate = experience.end_date ? moment(experience.end_date).format('DD/MM/YYYY') : 'now';

                return `${startDate} - ${endDate}`;
            },
            async deleteExperience(experienceId) {
                try {
                    this.$confirm(this.$t('do you want to delete?'), this.$t('delete experience'), {
                        confirmButtonText: this.$t('confirm'),
                        cancelButtonText: this.$t('cancel'),
                        type: 'warning',
                    }).then(async () => {
                        await this.$axios.$delete(`experiences/${experienceId}`);
                        const user = await this.$axios.$get('user');
                        this.$auth.setUser(user);
                        this.$message.success(this.$t('delete successfully'));
                    });
                } catch (error) {
                    this.$handleError(error);
                }
            },
        },
    };
</script>

<style lang="scss" scoped>
    .deleteBtn {
        width: 50%;
        margin: unset !important;
        border: unset !important;
    }
    .editBtn {
        width: 50%;
        margin: unset !important;
        border: unset !important;
        background-color: theme('colors.light') !important;
    }
</style>
