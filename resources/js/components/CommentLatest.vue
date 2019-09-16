<template>
    <section class="summary-reviews">
        <h2>Review gần đây</h2>
        <div class="list-reviews" v-if="listComment && listComment.length > 0">
            <div class="review" v-for="comment in listComment" :key="comment.id">
                <h3>
                    <span class="font-weight-bold">{{ comment.reviewer }}</span> đã review
                    <a :href=comment.company_url>{{ comment.company_name }}</a>
                </h3>
                <p>{{ comment.created_at | showTimeAgo}}
                    <span class="icon has-text-warning" v-for="star in 5" :key="star">
                       <i class="fa-star" :class="star <= comment.star ? 'fas' : 'far'"></i>
                   </span>
                </p>
                <p>{{ comment.content }}</p>
            </div>
        </div>
    </section>
</template>
<script>
  import globalMixin from '../mixins/globalMixin.js';

  export default {
    mixins: [ globalMixin ],
    props: {
      apiList: {
        getCommentLatest: {
          type: String,
          required: true
        }
      }
    },
    data: function () {
        return {
          listComment: [],
          loading: false,
          errored: false
        }
    },
    methods: {
      getCommentLatest: function () {
        let self = this;
        self.loading = true;
        axios.get(self.apiList.getCommentLatest).then(response => {
          let responseData = response.data;
          if (responseData.success) {
            self.listComment = responseData.data;
          }
          self.loading = false;
        }).catch(error => {
          console.log(error);
          self.errored = true;
        }).finally(() => self.loading = false)
      }
    },
    created() {
        this.getCommentLatest();
    }
  }
</script>
