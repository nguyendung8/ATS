<template>
    <div class="stage-action">
        <el-dialog
            :visible.sync="show"
            width="30%"
            @close="onClose"
        >
            <span slot="title">
                <h4 class="capitalize">{{ $t('update actions for the stage') }} {{ stageName }}</h4>
            </span>
            <el-form
                ref="form"
                size="medium"
            >
                <div class="font-bold mb-2">{{ $t('actions') }}</div>
                <div v-if="actionsAdded.length">
                    <el-tag
                        v-for="(item, index) in actionsAdded"
                        :key="index"
                        closable
                        type="success"
                        :disable-transitions="false"
                        @close="handleClose(item)"
                    >
                        {{ item.name }}
                    </el-tag>
                </div>
                <div v-else>
                    {{ $t('no action has been added to this stage') }}
                </div>

                <div class="font-bold mb-2 mt-2">{{ $t('action setting') }}</div>
                <el-form-item>
                    <el-select
                        v-model="actionId"
                        class="w-full"
                        :placeholder="$t('action')"
                        filterable
                        clearable
                        :loading="loading"
                        @change="changeAction"
                    >
                        <el-option
                            v-for="(item, index) in actions"
                            :key="index"
                            :label="$get(item, 'name')"
                            :value="$get(item, 'id')"
                        />
                    </el-select>
                </el-form-item>
                <component
                    :is="actionComponent()"
                    v-if="actionId"
                    :action="action"
                    :pipeline-stage-id="pipelineStageId"
                    :add-action="addAction"
                    :clear-action="clearAction"
                />
            </el-form>
        </el-dialog>
    </div>
</template>
<script>
    import _find from 'lodash/find';
    import RejectCandidate from '~/components/Action/RejectCandidate.vue';

    export default {
        components: {
            RejectCandidate,
        },

        props: {
            actions: {
                type: Array,
                required: true,
            },
            actionsAdded: {
                type: Array,
                required: true,
            },
            addAction: {
                type: Function,
                required: true,
            },
            removeAction: {
                type: Function,
                required: true,
            },
        },
        data() {
            return {
                isEdit: false,
                show: false,
                loading: false,
                action: null,
                actionId: null,
                stageName: null,
                pipelineStageId: null,
            };
        },

        methods: {
            open(stage) {
                this.clearAction();
                this.show = true;
                this.stageName = this.$get(stage, 'name', null);
                this.pipelineStageId = this.$get(stage, 'pipelineStageId', null);
            },
            onClose() {
                this.loading = false;
                this.isEdit = false;
                this.show = false;
                this.clearAction();
            },
            async changeAction(actionId) {
                if (actionId) {
                    this.loading = true;
                    const action = _find(this.actions, ['id', actionId]);
                    this.action = action;
                    this.loading = false;
                    this.actionId = actionId;
                    const { data: ac } = await this.$axios.$get(`pipeline-stages/${this.pipelineStageId}/actions/${actionId}`);
                    this.action.options = ac.options;
                }
            },
            clearAction() {
                this.actionId = null;
            },
            actionComponent() {
                return this.action.fileName;
            },
            handleClose(action) {
                this.clearAction();
                this.removeAction(action.id, this.pipelineStageId);
            },
        },
    };
</script>

<style lang="scss">
    .stage-action {
        .el-tag + .el-tag {
            margin-left: 10px;
        }
    }
    .button-new-tag {
        margin-left: 10px;
        height: 32px;
        line-height: 30px;
        padding-top: 0;
        padding-bottom: 0;
    }
    .input-new-tag {
        width: 90px;
        margin-left: 10px;
        vertical-align: bottom;
    }
</style>
