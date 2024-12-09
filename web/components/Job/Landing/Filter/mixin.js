import { ALL_TYPE } from '~/enums/job/employment-type';

export default {
    props: {
        query: {
            type: Object,
            required: true,
        },
        search: {
            type: Function,
            required: true,
        },
    },

    data() {
        return {
            location: '',
            tag: '',
            locations: [],
            jobTags: [],
            jobTypes: ALL_TYPE,
            checkedLocations: [],
            checkedTags: [],
            checkedTypes: [],
        };
    },

    async fetch() {
        const [
            { data: locations },
            { data: tags },
        ] = await Promise.all([
            this.$axios.$get('jobs/locations'),
            this.$axios.$get('jobs/tags'),
        ]);

        this.locations = locations;
        this.jobTags = tags;
    },

    methods: {
        async onChangeLocation(keyword) {
            try {
                const { data: locations } = await this.$axios.$get('jobs/locations', { params: { keyword } });
                this.locations = locations;
            } catch (error) {
                this.$handleError(error);
            }
        },
        async onChangeTag(keyword) {
            try {
                const { data: tags } = await this.$axios.$get('jobs/tags', { params: { keyword } });
                this.jobTags = tags;
            } catch (error) {
                this.$handleError(error);
            }
        },
        onChangeValue(key, val) {
            this.search({
                ...this.query,
                [key]: val,
            });
        },
        clearFilter() {
            this.checkedLocations = [];
            this.checkedTags = [];
            this.checkedTypes = [];
        },
    },
};
