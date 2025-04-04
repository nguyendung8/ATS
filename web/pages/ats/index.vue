<template>
    <div>
        <!-- Hero Section with Carousel -->
        <el-carousel height="500px">
            <el-carousel-item v-for="item in 2" :key="item">
                <div class="hero-content text-center text-white">
                    <h1 class="text-4xl font-bold mb-4">HƠN 56.000 ỨNG VIÊN ĐÃ THAM GIA</h1>
                    <div class="stats-grid grid grid-cols-3 gap-8 max-w-4xl mx-auto mt-8">
                        <div class="stat-item">
                            <h3 class="text-2xl font-bold">250</h3>
                            <p>Ứng viên đang giảng dạy các chương trình</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="text-2xl font-bold">100+</h3>
                            <p>chương trình được triển khai tại hơn 100 trường học</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="text-2xl font-bold">5000+</h3>
                            <p>học viên đã thi đỗ các chứng chỉ quốc tế</p>
                        </div>
                    </div>
                </div>
            </el-carousel-item>
        </el-carousel>

        <!-- About Section -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-8">ATLANTIC FIVE-STAR ENGLISH</h2>
                <div class="max-w-3xl mx-auto text-center">
                    <p class="mb-6">
                        Tại Atlantic, chúng tôi tin tưởng mạnh mẽ vào việc sử dụng các phương pháp giảng dạy hiệu quả cho các chương trình học.
                        Chúng tôi cam kết hỗ trợ sự phát triển chuyên môn của tất cả giáo viên, bất kể trình độ hay kinh nghiệm của họ.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        <div class="feature-item">
                            <h4 class="font-semibold mb-2">Ưu tiên giao tiếp và phương pháp lấy học sinh làm trung tâm</h4>
                        </div>
                        <div class="feature-item">
                            <h4 class="font-semibold mb-2">Tập trung vào học tập tích cực và kết hợp</h4>
                        </div>
                        <div class="feature-item">
                            <h4 class="font-semibold mb-2">Tích hợp kỹ năng và đánh giá theo tiến trình</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Jobs Section -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-8">Vị Trí Tuyển Dụng Mới</h2>
                <JobLanding
                    :jobs="jobs"
                    :meta="meta"
                />
            </div>
        </section>

        <!-- Why AG Section -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-8">Tại Sao Chọn AG?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <div class="benefit-item text-center">
                        <span class="material-icons text-4xl text-primary mb-4">card_travel</span>
                        <h4 class="font-semibold mb-2">Hỗ Trợ Visa</h4>
                        <p>Hỗ trợ visa và giấy phép lao động cho tất cả giáo viên</p>
                    </div>
                    <div class="benefit-item text-center">
                        <span class="material-icons text-4xl text-primary mb-4">health_and_safety</span>
                        <h4 class="font-semibold mb-2">Bảo Hiểm Y Tế</h4>
                        <p>Được cung cấp cả bảo hiểm tư nhân và nhà nước</p>
                    </div>
                    <div class="benefit-item text-center">
                        <span class="material-icons text-4xl text-primary mb-4">paid</span>
                        <h4 class="font-semibold mb-2">Nghỉ Phép Có Lương</h4>
                        <p>Nghỉ phép năm và nghỉ lễ có lương</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import JobLanding from '~/components/Job/Landing/index.vue';

    export default {
        name: 'AtsLanding',

        components: {
            JobLanding,
        },

        layout: 'candidate',

        async asyncData({ $axios, query }) {
            const { data: jobs, meta } = await $axios.$get('jobs/published', {
                params: query,
            });

            return {
                jobs,
                meta,
            };
        },

        watchQuery: true,
    };
</script>

<style scoped>
.hero-content {
    background: rgba(0, 0, 0, 0.5);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0 20px;
}

.el-carousel__item {
    background-size: cover;
    background-position: center;
}

.text-primary {
    color: #28497c;
}

.feature-item, .benefit-item {
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.feature-item:hover, .benefit-item:hover {
    transform: translateY(-5px);
}

.stat-item {
    background: rgba(255, 255, 255, 0.1);
    padding: 1.5rem;
    border-radius: 8px;
}
</style>
