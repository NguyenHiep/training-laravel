@extends('layouts.app')

@section('title', 'Giải đáp thắc mắc - Yêu cầu xóa review')
@section('description', 'Review công ty - Giải đáp thắc mắc - Yêu cầu xóa review')

@section('content')
    <section class="container main-content">
        <div class="row">
            <div class="col-12 col-lg-12">
                <article class="message is-info">
                    <div class="message-header">
                        <h1 class="title is-size-4 has-text-white">Giải đáp thắc mắc</h1>
                    </div>
                    <div class="message-body is-size-5 help-section">
                        <p class="question">
                            1. Có công ty tôi muốn review nhưng không thấy trên trang này?
                        </p>
                        <p class="answer">
                            Bạn vui lòng gửi mail tới <a href="mailto:company@review.giadinhit.com?Subject=Thêm%20công%20ty">company@review.giadinhit.com</a>
                            với tiêu đề "Thêm công ty".
                            Nội dung email gồm thông tin thêm về công ty như về tên công ty, địa điểm, website nhé.
                        </p>
                        <p class="question">
                            2. Tôi muốn xóa comment/ban user nào đó?
                        </p>
                        <p class="answer">
                            Quý vị vui lòng sử dụng <b>email của công ty</b> để gửi mail
                            tới <a href="mailto:deletecomment@review.giadinhit.com?Subject=Yêu%20cầu%20xóa%20comment">deletecomment@review.giadinhit.com</a>
                            với tiêu đề "Yêu cầu xóa comment"<br>
                            Việc xóa comment sẽ được thực hiện tùy thuộc vào nội dung comment và thái độ của quí vị/quí công ty.<br>
                            Chúng tôi không lưu trữ bất kì thông tin nào của người dùng nên không thể ban bất kì người dùng
                            nào.
                        </p>
                        <p class="question">
                            3. Nội dung đăng tải trên trang này có chính xác không?
                        </p>
                        <p class="answer">
                            Người đăng review chịu trách nhiệm về tính xác thực của nội dung mình đăng lên.<br>
                            Nói đơn giản là bạn tin thì tin, không tin thì thôi. Chúng tôi không thể kiểm chứng tính xác thực
                            của toàn bộ review do người dùng được.
                        </p>
                        <p class="question">
                            4. Trang này được tạo ra nhằm mục đích gì vậy? Có kiếm được tiền không?
                        </p>
                        <p class="answer">
                            Review công ty là website để người dùng chia sẻ kinh nghiệm, trải nghiệm làm việc ở các công ty
                            IT/Media/Creative. <br>
                            Mục tiêu của website là để anh em có chỗ chia sẻ, giúp nhau vào được công ty
                            ngon, tẩy chay công ty dỏm.
                            Hiện tại, chúng tôi hoạt động hoàn toàn phi lợi nhuận.
                        </p>
                        <p class="question">
                            5. Thông tin của tôi có bị bán cho sếp/HR/nhà tuyển dụng nào không?
                        </p>
                        <p class="answer">
                            Chúng tôi không yêu cầu hay lưu trữ <b>bất kì thông tin nào</b> của người dùng (cookie, địa chỉ IP,
                            số điện thoại) nên không có gì để bán.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
