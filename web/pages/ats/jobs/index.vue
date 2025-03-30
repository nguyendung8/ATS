<template>
    <div>
        <el-carousel height="300px">
            <el-carousel-item v-for="item in 2" :key="item">
                <el-image
                    style="height: 300px"
                    :src="require(`~/assets/images/banner${item}.png`)"
                    fit="fill"
                />
            </el-carousel-item>
        </el-carousel>
        <JobLanding
            :jobs="jobs"
            :meta="meta"
        />
    </div>
</template>

<script>
    import JobLanding from '~/components/Job/Landing/index.vue';

    export default {
        name: 'AtsLanding',

        components: {
            JobLanding,
        },

        layout: 'candidate',

        async asyncData({ $axios, query }) {
            const { data: jobs, meta } = await $axios.$get('jobs/published', {
                params: query,
            });

            return {
                jobs,
                meta,
            };
        },

        watchQuery: true,
    };
</script>

<style>
    .el-carousel__item,
    .el-image__inner {
        background-color: white;
        height: 300px;
        width: 100vw;
    }
    .el-carousel__indicators {
        display: none;
    }
</style>
