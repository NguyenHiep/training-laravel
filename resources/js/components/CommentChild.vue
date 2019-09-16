<template>
    <div class="review-comments">
        <div class="comment" v-for="(comment, key) in listComment" :key="key">
            <p class="comment__title" v-if="comment.reaction == 'DELETE'">
                <span class="has-text-weight-bold"> {{ comment.reviewer}} đã đề nghị xóa ❌</span> {{ comment.created_at | showTimeAgo }}
            </p>
            <p class="comment__title" v-if="comment.reaction == 'LIKE'">
                <span class="has-text-weight-bold"> {{ comment.reviewer}} đã <span class="icon-like icon has-text-success"><i class="fas fa-thumbs-up"></i></span></span> {{ comment.created_at | showTimeAgo }}
            </p>
            <p class="comment__title" v-if="comment.reaction == 'HATE'">
                <span class="has-text-weight-bold"> {{ comment.reviewer}} đã <span class="icon-dislike icon has-text-danger"><i class="fas fa-thumbs-down"></i></span></span> {{ comment.created_at | showTimeAgo }}
            </p>
            <p class="comment__content text-500">{{ comment.content }}</p>
        </div>
        <nav class="pagination-list" aria-label="Pagination home" v-if="paginate.last_page > 1">
            <span class="pagination-summary">Trang <b>{{ paginate.current_page}}</b> trên tổng số <b>{{paginate.last_page}}</b></span>
            <Paginate
                v-model="paginate.current_page"
                :page-count=paginate.last_page
                :page-range="3"
                :margin-pages="2"
                :click-handler="getReviewComment"
                :prev-text="''"
                :next-text="''"
                :container-class="'pagination pagination-sm'"
                :page-class="'page-item'"
                :page-link-class = "'page-link'"
            >
            </Paginate>
        </nav>
    </div>
</template>
<style scoped>

</style>
<script>
  import _ from 'lodash';
  import Paginate from 'vuejs-paginate';
  import globalMixin from '../mixins/globalMixin.js';

  export default {
    mixins: [ globalMixin ],
    components: {
      Paginate
    },
    props: {
      apiList: {
        baseUrl: {
          type: String,
          required: true
        }
      },
      comment: {
        type: Object
      }
    },
    data: function () {
      return {
        listComment: [],
        paginate: {
          current_page: 1,
          offset: 4,
          last_page: 0,
          total: 0,
        },
        loading: false,
        errored: false,
      }
    },
    methods: {
      getReviewComment: _.debounce(function (pageNum) {
        let self = this;
        self.loading = true;
        let urlComment = self.apiList.baseUrl + '/api/v1/comments/' + self.comment.id + '/reply';
        if (_.isNumber(pageNum)) {
          urlComment += '?p=' + pageNum;
          self.paginate.current_page = pageNum;
        }
        axios.get(urlComment).then(response => {
          let responseData = response.data;
          if (responseData.success && !_.isEmpty(responseData.data.list_comment)) {
            self.listComment = responseData.data.list_comment;
            self.paginate = responseData.data.paginate;
          }
          self.loading = false;
        }).catch(error => {
          console.log(error);
          self.errored = true;
        }).finally(() => self.loading = false)
      }, 400)
    },
    created() {
      this.listComment = this.comment.childrens.list_comment;
      this.paginate = this.comment.childrens.paginate;
    }
  }
</script>
