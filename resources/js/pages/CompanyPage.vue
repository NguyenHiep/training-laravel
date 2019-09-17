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
                       <span class="company-info__rating" :title="company.avg_star">
                            <span class="icon has-text-warning" v-for="star in 5" :key="star">
                                <template v-if="company.avg_star >= star">
                                    <i class="fas fa-star"></i>
                                </template>
                                <template v-else-if="isFloatNumber(company.avg_star) && Math.round(company.avg_star) == star">
                                    <i class="fas fa-star-half-alt"></i>
                                </template>
                                <template v-else>
                                    <i class="far fa-star"></i>
                                </template>
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
       <CommentCompany
           :api-list="apiList"
           :comment="comment"
           @getCommentParent="getCommentParent"
           :comment_reply="comment_reaction"
       >
       </CommentCompany>
       <CommentStored
           :api-list="apiList"
           :company="company"
           @storedComment="getStoredComment"
       >
       </CommentStored>
       <CommentPopupStored
           :api-list="apiList"
           :company="company"
           @storedReaction="getStoredReaction"
           :comment_parent="comment_parent"
       >
       </CommentPopupStored>
   </article>
</template>
<script>
  import _ from 'lodash';
  import CommentStored from '../components/CommentStored.vue';
  import CommentCompany from '../components/CommentCompany.vue';
  import CommentPopupStored from '../components/CommentPopupStored';
  export default {
    components: {
      CommentPopupStored,
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
        comment: {},
        comment_reaction: {},
        comment_parent: {},
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
      },
      getStoredComment: function (comment) {
        this.comment = comment;
      },
      getStoredReaction: function (reaction) {
        this.comment_reaction = reaction;
      },
      getCommentParent: function (comment) {
        this.comment_parent = comment; // Get data for $emit
      },
      isFloatNumber: function (num) {
        let numberic = parseInt(num);
        if (!isNaN(numberic) && num.indexOf('.') != -1) {
          return true;
        }
        return false;
      }
    },
    created() {
      this.getCompanyDetail();
    }
  }
</script>
