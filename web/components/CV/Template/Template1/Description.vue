<template>
    <div class="education">
        <div class="title">About me</div>
        <div class="education_wrap">
            <p class="info_title text-right">{{ $get($auth.user, 'candidate.description') }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'DescriptionPart',
    };
</script>
