<template>
    <div>
        <!-- Hero Section -->
        <div class="bg-primary py-20">
            <div class="container mx-auto px-4">
                <h1 class="text-4xl font-bold text-white text-center">GIỚI THIỆU</h1>
            </div>
        </div>

        <!-- Introduction Section -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-3xl font-bold mb-8">GIỚI THIỆU CHUNG</h2>
                    <p class="mb-6 text-lg leading-relaxed">
                        Được thành lập từ năm 2020, chúng tôi là nền tảng tuyển dụng hàng đầu tại Việt Nam, kết nối
                        hàng nghìn doanh nghiệp với các ứng viên tiềm năng. Với sứ mệnh đem đến những cơ hội việc làm
                        chất lượng, chúng tôi không ngừng đổi mới và phát triển để mang lại trải nghiệm tốt nhất cho
                        cả nhà tuyển dụng và người tìm việc.
                    </p>
                    <p class="mb-6 text-lg leading-relaxed">
                        Trong suốt quá trình hoạt động, chúng tôi đã giúp hơn 10,000 ứng viên tìm được công việc phù hợp
                        và hợp tác với hơn 500 doanh nghiệp uy tín trên toàn quốc.
                    </p>
                </div>
            </div>
        </section>

        <!-- Mission, Vision, Values Section -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="mb-16">
                        <h2 class="text-3xl font-bold mb-8">SỨ MỆNH</h2>
                        <p class="text-lg leading-relaxed">
                            Chúng tôi cam kết trở thành cầu nối tin cậy giữa người tìm việc và nhà tuyển dụng,
                            mang đến những cơ hội việc làm chất lượng và góp phần phát triển nguồn nhân lực cho
                            thị trường lao động Việt Nam.
                        </p>
                    </div>

                    <div class="mb-16">
                        <h2 class="text-3xl font-bold mb-8">TẦM NHÌN</h2>
                        <p class="text-lg leading-relaxed">
                            Trở thành nền tảng tuyển dụng số 1 tại Việt Nam, nơi mà mọi ứng viên đều có thể tìm
                            thấy công việc phù hợp với năng lực và đam mê của mình.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-3xl font-bold mb-8">GIÁ TRỊ CỐT LÕI</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="value-item text-center p-6 bg-white rounded-lg shadow-sm">
                                <span class="material-icons text-4xl text-primary mb-4">verified_user</span>
                                <h3 class="font-bold mb-2">Uy Tín</h3>
                                <p>Cam kết mang đến những thông tin tuyển dụng chính xác và đáng tin cậy</p>
                            </div>
                            <div class="value-item text-center p-6 bg-white rounded-lg shadow-sm">
                                <span class="material-icons text-4xl text-primary mb-4">psychology</span>
                                <h3 class="font-bold mb-2">Chuyên Nghiệp</h3>
                                <p>Quy trình tuyển dụng chuyên nghiệp, minh bạch và hiệu quả</p>
                            </div>
                            <div class="value-item text-center p-6 bg-white rounded-lg shadow-sm">
                                <span class="material-icons text-4xl text-primary mb-4">diversity_3</span>
                                <h3 class="font-bold mb-2">Đồng Hành</h3>
                                <p>Luôn đồng hành và hỗ trợ ứng viên trong suốt quá trình tìm việc</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Achievement Section -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">THÀNH TỰU CỦA CHÚNG TÔI</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                    <div class="achievement-item text-center">
                        <h3 class="text-4xl font-bold text-primary mb-2">10,000+</h3>
                        <p>Ứng viên thành công</p>
                    </div>
                    <div class="achievement-item text-center">
                        <h3 class="text-4xl font-bold text-primary mb-2">500+</h3>
                        <p>Doanh nghiệp đối tác</p>
                    </div>
                    <div class="achievement-item text-center">
                        <h3 class="text-4xl font-bold text-primary mb-2">1,000+</h3>
                        <p>Việc làm mỗi tháng</p>
                    </div>
                    <div class="achievement-item text-center">
                        <h3 class="text-4xl font-bold text-primary mb-2">95%</h3>
                        <p>Khách hàng hài lòng</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: 'AboutUs',
    layout: 'candidate'
}
</script>

<style scoped>
.bg-primary {
    background-color: #28497c;
}

.text-primary {
    color: #28497c;
}

.value-item, .achievement-item {
    transition: transform 0.3s ease;
}

.value-item:hover {
    transform: translateY(-5px);
}

.achievement-item h3 {
    font-size: 2.5rem;
}
</style>