<template>
   <main v-cloak>
       <nav class="container">
           <ul class="breadcrumb list-unstyled">
               <li>
                   <a href="/" title="Trang chủ"><i class="fas fa-home" aria-hidden="true"></i>Trang chủ</a>
               </li>
               <li class="active"><span>Review Công ty NFQ Asia (8bit Rockstars)</span></li>
           </ul>
       </nav>
       <section class="container block-company">
           <div class="company-info">
               <figure class="company-info__logo">
                   <img class="img-fluid" src="https://reviewcongty.com/images/companies/mb-bank-logo.png" alt="Image company">
               </figure>
               <div class="company-info__detail">
                   <h1 class="company-info__name">
                       <span>MB Bank</span>
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
                   </h1>
                   <div class="company-info__other">
                       <span><i class="fas fa-briefcase"></i> Sản phẩm</span>
                       <span><i class="fas fa-users"></i>  151-300</span>
                   </div>
                   <div class="company-info__location">
                       <span><i class="fas fa-building"></i> 21 Cat Linh Dong Da Ha Noi</span>
                   </div>
               </div> <!-- .company-info__detail -->
           </div>
           <button class="btn btn-success btn-review" data-toggle="modal" data-target="#write_comment">
               <span class="icon"><i class="fas fa-pencil-alt"></i></span> &nbsp;&nbsp;Viết review
           </button>
       </section>
       <section class="list-review container">
           <div class="review card">
               <header class="card-header">
                   <p class="card-header-title">nguoi di phong van (dev) &nbsp;
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
                   </p>
                   <time class="review__time">17 ngày trước</time>
                   <a class="review__share" href="#"><i class="fas fa-link" style="margin-right: 5px"></i> Share</a>
               </header>
               <div class="card-content">
                   <div class="content text-500">
                       mình xin review công ty phát:<br>1. về phỏng vấn thì anh Trí phỏng vấn ok, nhưng khi phỏng vấn 3 vòng, khi đã pass vòng cuối rồi còn làm bài tập, nhưng tới vòng phỏng vấn PM và team thì lại phỏng vấn technical, rồi làm bài tập, nhưng lương deal lại bèo.<br>2. Công ty đăng tuyển thấy suốt năm cũng một vị trí đó, chak ra vào thường xuyên
                   </div>
               </div>
               <footer class="card-footer">
                   <a href="#"class="link-comment card-footer-item clickable">
                    <span class="icon-reply icon has-text-info">
                        <i class="fas fa-comments"></i>
                    </span>Reply
                   </a>
                   <span class="link-comment card-footer-item clickable">0
                    <span class="icon-like icon has-text-success">
                        <i class="fas fa-thumbs-up"></i>
                    </span>
                </span>
                   <span class="link-comment card-footer-item clickable">0
                    <span class="icon-dislike icon has-text-danger">
                        <i class="fas fa-thumbs-down"></i>
                    </span>
                </span>
                   <span class="link-comment card-footer-item clickable">0
                    <span class="icon-ban icon is-medium">
                        <span class="fa-stack fa-md">
                            <i class="fas fa-comments fa-stack-1x has-text-info"></i>
                            <i class="fas fa-ban fa-stack-2x has-text-danger"></i>
                        </span>
                    </span>
                </span>
               </footer>
           </div>
           <div class="review card">
               <header class="card-header">
                   <p class="card-header-title">nguoi di phong van (dev) &nbsp;
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
                   </p>
                   <time class="review__time">17 ngày trước</time>
                   <a class="review__share" href="#"><i class="fas fa-link" style="margin-right: 5px"></i> Share</a>
               </header>
               <div class="card-content">
                   <div class="content text-500">
                       mình xin review công ty phát:<br>1. về phỏng vấn thì anh Trí phỏng vấn ok, nhưng khi phỏng vấn 3 vòng, khi đã pass vòng cuối rồi còn làm bài tập, nhưng tới vòng phỏng vấn PM và team thì lại phỏng vấn technical, rồi làm bài tập, nhưng lương deal lại bèo.<br>2. Công ty đăng tuyển thấy suốt năm cũng một vị trí đó, chak ra vào thường xuyên
                   </div>
               </div>
               <footer class="card-footer">
                   <a href="#"class="link-comment card-footer-item clickable">
                    <span class="icon-reply icon has-text-info">
                        <i class="fas fa-comments"></i>
                    </span>Reply
                   </a>
                   <span class="link-comment card-footer-item clickable">0
                    <span class="icon-like icon has-text-success">
                        <i class="fas fa-thumbs-up"></i>
                    </span>
                </span>
                   <span class="link-comment card-footer-item clickable">0
                    <span class="icon-dislike icon has-text-danger">
                        <i class="fas fa-thumbs-down"></i>
                    </span>
                </span>
                   <span class="link-comment card-footer-item clickable">0
                    <span class="icon-ban icon is-medium">
                        <span class="fa-stack fa-md">
                            <i class="fas fa-comments fa-stack-1x has-text-info"></i>
                            <i class="fas fa-ban fa-stack-2x has-text-danger"></i>
                        </span>
                    </span>
                </span>
               </footer>
           </div>
           <div class="review card">
               <header class="card-header">
                   <p class="card-header-title">nguoi di phong van (dev) &nbsp;
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
                   </p>
                   <time class="review__time">17 ngày trước</time>
                   <a class="review__share" href="#"><i class="fas fa-link" style="margin-right: 5px"></i> Share</a>
               </header>
               <div class="card-content">
                   <div class="content text-500">
                       mình xin review công ty phát:<br>1. về phỏng vấn thì anh Trí phỏng vấn ok, nhưng khi phỏng vấn 3 vòng, khi đã pass vòng cuối rồi còn làm bài tập, nhưng tới vòng phỏng vấn PM và team thì lại phỏng vấn technical, rồi làm bài tập, nhưng lương deal lại bèo.<br>2. Công ty đăng tuyển thấy suốt năm cũng một vị trí đó, chak ra vào thường xuyên
                   </div>
               </div>
               <footer class="card-footer">
                   <a href="#"class="link-comment card-footer-item clickable">
                    <span class="icon-reply icon has-text-info">
                        <i class="fas fa-comments"></i>
                    </span>Reply
                   </a>
                   <span class="link-comment card-footer-item clickable">0
                    <span class="icon-like icon has-text-success">
                        <i class="fas fa-thumbs-up"></i>
                    </span>
                </span>
                   <span class="link-comment card-footer-item clickable">0
                    <span class="icon-dislike icon has-text-danger">
                        <i class="fas fa-thumbs-down"></i>
                    </span>
                </span>
                   <span class="link-comment card-footer-item clickable">0
                    <span class="icon-ban icon is-medium">
                        <span class="fa-stack fa-md">
                            <i class="fas fa-comments fa-stack-1x has-text-info"></i>
                            <i class="fas fa-ban fa-stack-2x has-text-danger"></i>
                        </span>
                    </span>
                </span>
               </footer>
           </div>
           <nav class="pagination-list" aria-label="Pagination home">
               <span class="pagination-summary">Trang <b>1</b> trên tổng số <b>3</b></span>
               <ul class="pagination pagination-sm">
                   <li class="page-item active" aria-current="page">
              <span class="page-link">
                1
                <span class="sr-only">(current)</span>
              </span>
                   </li>
                   <li class="page-item"><a class="page-link" href="#">2</a></li>
                   <li class="page-item"><a class="page-link" href="#">3</a></li>
               </ul>
           </nav>
       </section>
       <CommentStored :api-list="apiList"></CommentStored>
   </main>
</template>
<script>
  import HomeBanner from '../components/HomeBanner.vue';
  import CommentStored from '../components/CommentStored.vue';

  export default {
    props: {
      apiList: {
        type: Object,
        required: true
      }
    },
    components: {
      CommentStored
    }
  }
</script>
