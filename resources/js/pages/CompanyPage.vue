<template>
   <article v-cloak>
       <nav class="container">
           <ul class="breadcrumb list-unstyled">
               <li>
                   <a :href=apiList.baseUrl title="Trang chủ"><i class="fas fa-home" aria-hidden="true"></i>Trang chủ</a>
               </li>
               <li class="active" v-if="company.name"><span>Review Công ty {{ company.name }}</span></li>
           </ul>
       </nav>
       <section class="container block-company">
           <div class="company-info">
               <figure class="company-info__logo" v-if="company.logo">
                   <img class="img-fluid" :src=company.logo :alt=company.name />
               </figure>
               <div class="company-info__detail">
                   <h1 class="company-info__name">
                       <span>{{ company.name }}</span>
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
                            <span class="rating-count">({{ company.total_comment }})</span>
                      </span>
                   </h1>
                   <div class="company-info__other">
                       <span><i class="fas fa-briefcase"></i> {{ company.type }}</span>
                       <span><i class="fas fa-users"></i>  {{ company.size }}</span>
                   </div>
                   <div class="company-info__location">
                       <span><i class="fas fa-building"></i> {{ company.address }}</span>
                   </div>
               </div> <!-- .company-info__detail -->
           </div>
           <button class="btn btn-success btn-review" data-toggle="modal" data-target="#write_comment">
               <span class="icon"><i class="fas fa-pencil-alt"></i></span> &nbsp;&nbsp;Viết review
           </button>
       </section>
       <CommentCompany :api-list="apiList"></CommentCompany>
       <CommentStored :api-list="apiList" :company="company"></CommentStored>
   </article>
</template>
<script>
  import _ from 'lodash';
  import CommentStored from '../components/CommentStored.vue';
  import CommentCompany from '../components/CommentCompany.vue';
  export default {
    components: {
      CommentStored,
      CommentCompany
    },
    props: {
      apiList: {
        getCompanyDetail: {
          type: String,
          required: true
        },
      }
    },
    data: function () {
      return {
        company: {},
        loading: false,
        errored: false
      }
    },
    methods: {
      getCompanyDetail: function () {
        let self = this;
        self.loading = true;
        axios.get(self.apiList.getCompanyDetail).then(response => {
          let responseData = response.data;
          if (responseData.success && !_.isEmpty(responseData.data)) {
            self.company = responseData.data;
          }
          self.loading = false;
        }).catch(error => {
          console.log(error);
          self.errored = true;
        }).finally(() => self.loading = false)
      }
    },
    created() {
      this.getCompanyDetail();
    }
  }
</script>
