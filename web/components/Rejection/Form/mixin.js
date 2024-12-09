export default {
    props: {
        updateCandidate: {
            type: Function,
            default() {},
        },
    },
    data() {
        return {
            show: false,
            candidate: null,
            pipelineId: null,
            stagedId: null,
            rejections: [],
            form: {
                rejection_id: null,
            },
            rules: {
                rejection_id: 'name: reason|required',
            },
        };
    },
    computed: {
        label() {
            const nameCandidate = this.$get(this.candidate, 'user.name', null);
            return `${this.$t('why are you disqualifying')} ${nameCandidate}?`;
        },
    },
    async fetch() {
        const { data: rejections } = await this.$axios.$get('rejections');
        this.rejections = rejections;
    },
    methods: {
        open(candidate, pipelineId, stagedId) {
            this.show = true;
            this.candidate = candidate;
            this.pipelineId = pipelineId;
            this.stagedId = stagedId;
        },
        onClose() {
            this.resetForm();
            this.show = false;
        },
        resetForm() {
            this.$refs.form.resetFields();
        },
        async submitForm(formData) {
            try {
                await this.$axios.$post(`candidates/${this.candidate.id}/pipelines/${this.pipelineId}/stages/${this.stagedId}/reject`, formData);
                this.$message.success(this.$t('update successfully'));
                this.onClose();
            } catch (error) {
                this.$handleError(error);
            }
        },
    },
};
