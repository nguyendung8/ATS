import _omit from 'lodash/omit';

export default {
    props: {
        jobs: {
            type: Array,
            required: true,
        },
        meta: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            name: '',
            jobNames: [],
            query: this.$get(this.$route, 'query', {}),
        };
    },

    methods: {
        onSearchJobs(name) {
            this.query = name
                ? { ...this.query, name }
                : _omit(this.query, 'name');
            this.$router.push({ query: this.query });
        },
        async onSearchName(name) {
            const { data: jobNames } = await this.$axios.$get('jobs/published/get-names', { params: { name } });
            this.jobNames = jobNames;
        },
        onClearFilter() {
            this.$refs.jobFilter.clearFilter();
            this.name = '';
            this.query = {};
            this.$router.push({ path: '/ats' });
        },
        search(query) {
            this.query = query;
            this.$router.push({ query: this.query });
        },
    },
};
