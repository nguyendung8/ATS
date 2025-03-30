<template>
    <el-container>
        <el-header class="bg-white">
            <CandidateHeader />
        </el-header>
        <div>
            <Nuxt />
        </div>
        <div class="bg-primary mt-10">
            <CandidateFooter />
        </div>
    </el-container>
</template>

<script>
    import CandidateFooter from '~/components/CandidateFooter.vue';

    export default {
        name: 'CandidateLayout',

        components: {
            CandidateFooter,
        },

        middleware: ['auth'],

        auth: 'guest',
    };
</script>
