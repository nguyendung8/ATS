<template>
    <div class="grid grid-cols-10 gap-10 my-10 mx-10">
        <div class="col-span-3 flex justify-end">
            <div class="w-80">
                <JobFilter
                    ref="jobFilter"
                    :query="query"
                    :search="search"
                />
            </div>
        </div>
        <div class="col-span-7">
            <div class="max-w-4xl">
                <div class="flex items-center mb-5">
                    <el-select
                        v-model="name"
                        class="mr-5 w-full"
                        :placeholder="$t('name')"
                        filterable
                        clearable
                        remote
                        :remote-method="onSearchName"
                        prefix-icon="el-icon-search"
                        @change="onSearchJobs"
                    >
                        <el-option
                            v-for="(name, index) in jobNames"
                            :key="index"
                            :label="name"
                            :value="name"
                        />
                    </el-select>
                    <el-button
                        type="info"
                        class="capitalize"
                        @click="onClearFilter"
                    >
                        {{ $t('clear filter') }}
                    </el-button>
                </div>
                <JobCard
                    v-for="(job, index) in jobs"
                    :key="index"
                    :job="job"
                    @click.native="$router.push(`/ats/jobs/${$get(job, 'id')}`)"
                />
                <Pagination :data="meta" />
            </div>
        </div>
    </div>
</template>
<script>
    import Pagination from '~/components/Shared/Pagination.vue';
    import mixin from './mixin';
    import JobCard from './JobCard.vue';
    import JobFilter from './Filter/index.vue';

    export default {
        name: 'JobLanding',

        components: {
            JobCard,
            JobFilter,
            Pagination,
        },

        mixins: [mixin],
    };
</script>

<style lang="scss">
    .el-loading-mask {
        .el-loading-spinner {
            top: 350px;
        }
    }
</style>
