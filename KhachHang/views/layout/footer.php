</main>
<footer class="footer-main mt-auto">
    <div class="container-lg">

        <div class="row footer-grid-custom pb-4 mb-3">

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0">
                <h3 class="footer-title">Về Bee Green</h3>
                <ul class="list-unstyled">
                    <li><a href="/about" class="footer-link">Giới thiệu</a></li>
                    <li><a href="/policy" class="footer-link">Chính sách Bảo mật</a></li>
                    <li><a href="/terms" class="footer-link">Điều khoản Sử dụng</a></li>
                    <li><a href="/careers" class="footer-link">Cơ hội Nghề nghiệp</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0">
                <h3 class="footer-title">Hỗ Trợ</h3>
                <ul class="list-unstyled">
                    <li><a href="/faq" class="footer-link">FAQ</a></li>
                    <li><a href="/help" class="footer-link">Trung tâm Trợ giúp</a></li>
                    <li><a href="/contact" class="footer-link">Liên hệ chúng tôi</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0">
                <h3 class="footer-title">Kết Nối Với Chúng Tôi</h3>
                <div class="social-links mb-3">
                    <a href="#" class="social-icon me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                </div>
                <p class="mb-0">Email: support@beegreen.vn</p>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <h3 class="footer-title">Bee Green</h3>
                <p>Du lịch Xanh vì một tương lai bền vững.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center pt-3 border-top border-secondary">
                <p class="footer-copyright mb-0">&copy; <?php echo date('Y'); ?> Bee Green. All rights reserved.</p>
            </div>
        </div>

    </div>
</footer>

</body>

</html>

<style>
    /* Sử dụng lại các biến màu từ Header */
    :root {
        --bee-green-primary: #4CAF50;
        /* Xanh lá chính */
        --bee-green-dark: #2E7D32;
        /* Xanh lá đậm */
    }

    .footer-main {
        background-color: var(--bee-green-dark);
        /* Nền Xanh lá đậm */
        color: #ffffff;
        padding: 40px 0 20px;
        margin-top: 50px;
        /* Tăng margin top để tách khỏi nội dung */
    }

    /* Tiêu đề cột */
    .footer-title {
        color: var(--bee-green-primary);
        /* Tiêu đề màu Xanh lá chính */
        font-size: 18px;
        margin-bottom: 15px;
        font-weight: 500;
    }

    /* Liên kết */
    .footer-link {
        color: #cccccc;
        text-decoration: none;
        line-height: 2.2;
        /* Tăng khoảng cách dòng */
        display: block;
    }

    .footer-link:hover {
        color: #ffffff;
    }

    /* Bản quyền */
    .footer-copyright {
        font-size: 14px;
        color: #cccccc;
    }

    /* Liên kết Mạng xã hội */
    .social-links .social-icon {
        color: #cccccc;
        font-size: 18px;
        transition: color 0.3s;
    }

    .social-links .social-icon:hover {
        color: var(--bee-green-primary);
    }

    /* Tùy chỉnh căn giữa nội dung (đã có trong Header, nhưng nên nhắc lại) */
    .container-content {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 15px;
    }

    /* Đảm bảo Footer Grid có đường kẻ phân cách */
    .footer-grid-custom {
        max-width: 1200px;
        margin: 0 auto;
        /* Bootstrap border-bottom được thay bằng border-top của footer-bottom */
    }
</style>