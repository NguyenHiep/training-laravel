@extends('layouts.app')

@section('content')
    <section class="container-fuild bg-banner">
        <div class="bg-banner-gradient"></div>
        <img class="bg-banner-img img-fluid" src="{{ asset('images/banner.jpg') }}" alt="banner image" />
    </section>
    <section class="container section-search">
        <div class="bg-description">
            <h2>Review lương bổng, đãi ngộ, HR, sếp và công việc,... gì cũng có</h2>
            <div class="form-search">
                <form>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Tìm công ty" />
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="container main-content">
        <div class="row">
            <div class="col-12 col-lg-8">
                <!-- End navigation -->
                <div class="companies">
                    <!-- Begin navigation -->
                    <nav class="pagination-list" aria-label="Pagination home">
                        <span class="pagination-summary">Trang <b>1</b> trên tổng số <b>271</b></span>
                        <ul class="pagination pagination-sm">
                            <li class="page-item active" aria-current="page">
                    <span class="page-link">
                      1
                      <span class="sr-only">(current)</span>
                    </span>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><a class="page-link" href="#">6</a></li>
                            <li class="page-item"><a class="page-link" href="#">7</a></li>
                            <li class="page-item"><a class="page-link" href="#">8</a></li>
                            <li class="page-item"><a class="page-link" href="#">9</a></li>
                        </ul>
                    </nav>
                    <!-- Begin .company-item -->
                    <div data-href="/companies/mb-bank" class="company-item">
                        <div class="company-info">
                            <figure class="company-info__logo">
                                <img  class="img-fluid" src="https://reviewcongty.com/images/companies/mb-bank-logo.png" alt="Image company" />
                            </figure>
                            <div class="company-info__detail">
                                <h2 class="company-info__name">
                                    <a href="/companies/mb-bank">MB Bank</a>
                                    <span class="company-info__rating">
                        <span>
                          <span class="icon text-warning">
                            <i class="fas fa-star"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="fas fa-star"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="fas fa-star-half-alt"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="far fa-star"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="far fa-star"></i>
                          </span>
                        </span>
                        <span class="rating-count">(2)</span>
                      </span>
                                </h2>
                                <div class="company-info__other">
                                    <span><i class="fas fa-briefcase"></i> Sản phẩm</span>
                                    <span><i class="fas fa-users"></i>  151-300</span>
                                </div>
                                <div class="company-info__location">
                                    <span><i class="fas fa-building"></i> 21 Cat Linh Dong Da Ha Noi</span>
                                </div>
                            </div> <!-- .company-info__detail -->
                        </div>
                    </div>
                    <!-- End .company-item -->
                    <!-- Begin .company-item -->
                    <div data-href="/companies/evolable-asia" class="company-item">
                        <div class="company-info">
                            <figure class="company-info__logo">
                                <img  class="img-fluid" src="https://reviewcongty.com/images/companies/evolable-asia-logo.png" alt="Image company" />
                            </figure>
                            <div class="company-info__detail">
                                <h2 class="company-info__name">
                                    <a href="/companies/evolable-asia">Evolable Asia</a>
                                    <span class="company-info__rating">
                        <span>
                          <span class="icon text-warning">
                            <i class="fas fa-star"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="fas fa-star"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="fas fa-star"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="far fa-star"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="far fa-star"></i>
                          </span>
                        </span>
                        <span class="rating-count">(46)</span>
                      </span>
                                </h2>
                                <div class="company-info__other">
                                    <span><i class="fas fa-briefcase"></i> Dịch vụ</span>
                                    <span><i class="fas fa-users"></i>  501-1000</span>
                                </div>
                                <div class="company-info__location">
                                    <span><i class="fas fa-building"></i> 90 Nguyen Dinh Chieu District 1 Ho Chi Minh</span>
                                </div>
                            </div> <!-- .company-info__detail -->
                        </div>
                    </div>
                    <!-- End .company-item -->
                    <!-- Begin .company-item -->
                    <div data-href="/companies/cybozu-vietnam" class="company-item">
                        <div class="company-info">
                            <figure class="company-info__logo">
                                <img  class="img-fluid" src="https://reviewcongty.com/images/companies/cybozu-logo.jpg" alt="Image company" />
                            </figure>
                            <div class="company-info__detail">
                                <h2 class="company-info__name">
                                    <a href="/companies/cybozu-vietnam">Cybozu Vietnam</a>
                                    <span class="company-info__rating">
                        <span>
                          <span class="icon text-warning">
                            <i class="fas fa-star"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="fas fa-star"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="fas fa-star-half-alt"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="far fa-star"></i>
                          </span>
                          <span class="icon text-warning">
                            <i class="far fa-star"></i>
                          </span>
                        </span>
                        <span class="rating-count">(2)</span>
                      </span>
                                </h2>
                                <div class="company-info__other">
                                    <span><i class="fas fa-briefcase"></i> Sản phẩm</span>
                                    <span><i class="fas fa-users"></i>  51-150</span>
                                </div>
                                <div class="company-info__location">
                                    <span><i class="fas fa-building"></i> 106 Nguyen Van Troi Phu Nhuan Ho Chi Minh</span>
                                </div>
                            </div> <!-- .company-info__detail -->
                        </div>
                    </div>
                    <!-- End .company-item -->
                    <!-- Begin navigation -->
                    <nav class="pagination-list" aria-label="Pagination home">
                        <span class="pagination-summary">Trang <b>1</b> trên tổng số <b>271</b></span>
                        <ul class="pagination pagination-sm">
                            <li class="page-item active" aria-current="page">
                    <span class="page-link">
                      1
                      <span class="sr-only">(current)</span>
                    </span>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><a class="page-link" href="#">6</a></li>
                            <li class="page-item"><a class="page-link" href="#">7</a></li>
                            <li class="page-item"><a class="page-link" href="#">8</a></li>
                            <li class="page-item"><a class="page-link" href="#">9</a></li>
                        </ul>
                    </nav>
                    <!-- End navigation -->
                </div>

            </div>
            <div class="col-12 col-lg-4">
                <section class="summary-reviews">
                    <h2>Review gần đây</h2>
                    <div class="list-reviews">
                        <div class="review">
                            <h3><span class="font-weight-bold">Ẩn danh</span> đã review <a href="/companies/cybozu-vietnam">
                                    Cybozu Vietnam
                                </a> </h3>
                            <p>2 giờ trước <span><span class="icon text-warning">
                      <i class="fas fa-star"></i>
                    </span><span class="icon text-warning">
                      <i class="fas fa-star"></i>
                    </span><span class="icon text-warning">
                      <i class="far fa-star"></i>
                    </span><span class="icon text-warning">
                      <i class="far fa-star"></i>
                    </span><span class="icon text-warning">
                      <i class="far fa-star"></i>
                    </span></span> </p>
                            <p>Không biết mọi người nghĩ sao, chứ trường hợp của em vô pv xin intern mà hai ông pv cứ tưởng là senior, nói ra câu nào bắt bẻ câu đó, nói chung là max…</p>
                        </div>
                        <div class="review">
                            <h3><span class="font-weight-bold">Da phong van xong</span> đã review <a href="/companies/vinid-member-of-vingroup">
                                    VinID (Member of VinGroup)
                                </a> </h3>
                            <p>2 giờ trước <span><span class="icon text-warning">
                      <i class="fas fa-star"></i>
                    </span><span class="icon text-warning">
                      <i class="fas fa-star"></i>
                    </span><span class="icon text-warning">
                      <i class="fas fa-star"></i>
                    </span><span class="icon text-warning">
                      <i class="fas fa-star"></i>
                    </span><span class="icon text-warning">
                      <i class="far fa-star"></i>
                    </span></span> </p>
                            <p>Văn phòng đẹp, máy lạnh ngon, tuyển dụng ko chuyên nghiệp, đm phỏng vấn lâu không mời được cốc nước, interviewer đúng người ko phải gặp em khanh hr, l…</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
