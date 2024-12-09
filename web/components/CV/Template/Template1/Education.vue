<template>
    <div class="education">
        <div class="title">Education</div>
        <div class="education_wrap">
            <ul>
                <li
                    v-for="education in $get($auth.user, 'candidate.education', [])"
                    :key="education.id"
                >
                    <div class="li_wrap">
                        <div class="date">{{ getDate(education) }}</div>
                        <div class="info">
                            <p class="info_title">{{ $get(education, 'field_of_study') }}</p>
                            <p class="info_cont">{{ $get(education, 'school_name') }}</p>
                            <p class="info_com">{{ $get(education, 'grade') }}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        name: 'EducationPart',

        methods: {
            getDate(education) {
                const startDate = moment(this.$get(education, 'start_date')).format('DD/MM/YYYY');
                const endDate = education.end_date ? moment(education.end_date).format('DD/MM/YYYY') : 'Now';

                return `${startDate} - ${endDate}`;
            },
        },
    };
</script>
