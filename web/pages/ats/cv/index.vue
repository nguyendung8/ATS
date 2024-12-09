<template>
    <div class="m-10">
        <CVList
            :resumes="resumes"
            :resume-templates="resumeTemplates"
            :delete-resume="deleteResume"
        />
    </div>
</template>

<script>
    import CVList from '~/components/CV/List/index.vue';

    export default {
        name: 'CVListPage',

        components: {
            CVList,
        },

        layout: 'candidate',

        async asyncData({ $axios }) {
            const [
                { data: resumes },
                { data: resumeTemplates },
            ] = await Promise.all([
                $axios.$get('resumes'),
                $axios.$get('resume-templates'),
            ]);

            return {
                resumes,
                resumeTemplates,
            };
        },

        methods: {
            async deleteResume(resumeId) {
                try {
                    this.$confirm(this.$t('do you want to delete?'), this.$t('delete cv'), {
                        confirmButtonText: this.$t('confirm'),
                        cancelButtonText: this.$t('cancel'),
                        type: 'warning',
                    }).then(async () => {
                        await this.$axios.$delete(`resumes/${resumeId}`);
                        this.resumes = this.resumes.filter((item) => item.uuid !== resumeId);
                        this.$message.success(this.$t('delete successfully'));
                    });
                } catch (error) {
                    this.$handleError(error);
                }
            },
        },
    };
</script>
