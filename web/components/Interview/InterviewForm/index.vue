<template>
    <el-dialog
        :visible.sync="show"
        width="75%"
        @close="close"
    >
        <span slot="title">
            <h4 class="text-xl font-medium">
                {{ isEdit ? $t('edit interview schedule') : $t('schedule interview') }}
            </h4>
        </span>
        <el-form
            ref="form"
            :model="form"
            :rules="formRules"
            label-position="left"
        >
            <div class="bg-gray-50 p-8 pb-2 border">
                <p class="text-xl font-semibold mb-5">{{ $t('interview information') }}</p>
                <el-form-item prop="name" :error="serverErrors.name">
                    <el-input v-model="form.name" clearable :placeholder="$t('interview name')" />
                </el-form-item>
                <el-form-item>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <el-form-item prop="date" class="w-full">
                                <el-date-picker
                                    v-model="form.date"
                                    type="date"
                                    class="w-full"
                                    value-format="yyyy-MM-dd"
                                    :placeholder="$t('date')"
                                />
                            </el-form-item>
                        </div>
                        <div class="col-span-1">
                            <el-form-item prop="startTime" :error="serverErrors.startTime">
                                <el-time-picker
                                    v-model="form.startTime"
                                    format="HH:mm"
                                    value-format="yyyy-MM-dd HH:mm:ss"
                                    :placeholder="$t('start time')"
                                />
                            </el-form-item>
                        </div>
                        <div class="col-span-1">
                            <el-form-item prop="endTime" :error="serverErrors.endTime">
                                <el-time-picker
                                    v-model="form.endTime"
                                    format="HH:mm"
                                    value-format="yyyy-MM-dd HH:mm:ss"
                                    :placeholder="$t('end time')"
                                />
                            </el-form-item>
                        </div>
                    </div>
                </el-form-item>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-1">
                        <el-form-item prop="note" :error="serverErrors.note">
                            <el-input
                                v-model="form.note"
                                type="textarea"
                                :rows="7"
                                :placeholder="$t('note')"
                            />
                        </el-form-item>
                    </div>
                    <div class="col-span-1">
                        <el-form-item prop="staffs" class="w-full" :error="serverErrors.staffs">
                            <el-select
                                v-model="form.staffs"
                                multiple
                                class="w-full"
                                filterable
                                :placeholder="$t('interviewers')"
                            >
                                <el-option
                                    v-for="interview in staffs"
                                    :key="$get(interview, 'id')"
                                    :label="$get(interview, 'user.name')"
                                    :value="$get(interview, 'id')"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item prop="room" class="w-full" :error="serverErrors.roomId">
                            <el-select
                                v-model="form.roomId"
                                class="w-full"
                                filterable
                                clearable
                                :placeholder="$t('meeting room')"
                            >
                                <el-option
                                    v-for="room in rooms"
                                    :key="$get(room, 'id')"
                                    :label="$get(room, 'name')"
                                    :value="$get(room, 'id')"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item :label="$t('online meeting')" prop="isOnline" :error="serverErrors.isOnline">
                            <el-switch v-model="form.isOnline" />
                        </el-form-item>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-8 pb-2 mt-8 border">
                <p class="text-xl font-semibold mb-5">{{ $t('interview notification') }}</p>
                <el-form-item :label="$t('send mail to candidate')" prop="isSendMail" :error="serverErrors.isSendMail">
                    <el-switch v-model="form.isSendMail" />
                </el-form-item>
                <div v-if="form.isSendMail">
                    <el-form-item prop="mailTemplateId" :error="serverErrors.mailTemplateId">
                        <el-select
                            v-model="form.mailTemplateId"
                            class="w-full"
                            filterable
                            :placeholder="$t('mail template')"
                            @change="onChangeMailTemplate"
                        >
                            <el-option
                                v-for="template in mailTemplates"
                                :key="$get(template, 'id')"
                                :label="$get(template, 'name')"
                                :value="$get(template, 'id')"
                            />
                        </el-select>
                    </el-form-item>
                    <el-form-item prop="mailTitle" :error="serverErrors.mailTitle">
                        <el-input v-model="form.mailTitle" :placeholder="$t('mail title')" />
                    </el-form-item>
                    <TextEditor
                        :text="form.mailContent"
                        :placeholder="$t('mail content')"
                        @onChangeText="onChangeMailContent"
                    />
                </div>
            </div>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button type="info" plain @click="close">{{ $t('cancel') }}</el-button>
            <el-button type="info" @click="resetForm">{{ $t('reset') }}</el-button>
            <el-button
                type="primary"
                :loading="processing"
                @click="submit($refs.form, submitForm)"
            >
                {{ $t('submit') }}
            </el-button>
        </span>
    </el-dialog>
</template>
<script>
    import formMixin from '~/mixins/form';
    import TextEditor from '~/components/Shared/TextEditor.vue';
    import mixin from './mixin';

    export default {
        name: 'InterviewForm',

        components: {
            TextEditor,
        },

        mixins: [formMixin, mixin],
    };
</script>
