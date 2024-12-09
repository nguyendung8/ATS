<template>
    <div class="exp">
        <div class="title">Experience</div>
        <div class="exp_wrap">
            <ul>
                <li
                    v-for="experience in $get($auth.user, 'candidate.experiences', [])"
                    :key="experience.id"
                >
                    <div class="li_wrap">
                        <div class="date">{{ getDate(experience) }}</div>
                        <div class="info">
                            <p class="info_title">{{ $get(experience, 'company_name') }}</p>
                            <p class="info_cont">{{ $get(experience, 'position') }}</p>
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
        name: 'ExperiencePart',

        methods: {
            getDate(experience) {
                const startDate = moment(this.$get(experience, 'start_date')).format('DD/MM/YYYY');
                const endDate = experience.end_date ? moment(experience.end_date).format('DD/MM/YYYY') : 'now';

                return `${startDate} - ${endDate}`;
            },
        },
    };
</script>
