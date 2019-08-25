<template>
    <section class="list-review container" :class="loading ? 'loading' : ''">
        <div class="loading-block text-center" v-show="loading">
            <i class="fa fa-spin fa-spinner fa-3x"></i>
        </div>
        <nav class="pagination-list" aria-label="Pagination home" v-if="paginate.last_page > 1">
            <span class="pagination-summary">Trang <b>{{ paginate.current_page}}</b> trên tổng số <b>{{paginate.last_page}}</b></span>
            <Paginate
                v-model="paginate.current_page"
                :page-count=paginate.last_page
                :page-range="3"
                :margin-pages="2"
                :click-handler="getCommentDetail"
                :prev-text="''"
                :next-text="''"
                :container-class="'pagination pagination-sm'"
                :page-class="'page-item'"
                :page-link-class = "'page-link'"
            >
            </Paginate>
        </nav>
        <template v-if="listComment && listComment.length > 0">
            <div class="review card" v-for="(comment, key) in listComment" :key="key">
                <header class="card-header">
                    <p class="card-header-title"> {{ comment.reviewer }} <template v-if="comment.position">({{ comment.position }})</template>
                        <span class="icon has-text-warning" v-for="star in 5" :key="star">
                            <i class="fa-star" :class="star <= comment.star ? 'fas' : 'far'"></i>
                        </span>
                    </p>
                    <time class="review__time">{{ comment.created_at | showTimeAgo }}</time>
                    <a class="review__share" href="#"><i class="fas fa-link mr-2"></i> Share</a>
                </header>
                <div class="card-content">
                    <div class="content text-500" v-html="comment.content"></div>
                </div>
                <footer class="card-footer">
                    <span @click="getReaction('COMMENT', comment.id)" class="link-comment card-footer-item clickable" data-toggle="modal" data-target="#reaction_comment">
                        <span class="icon-reply icon has-text-info">
                            <i class="fas fa-comments"></i>
                        </span>Reply
                    </span>
                    <span @click="getReaction('LIKE', comment.id)" class="link-comment card-footer-item clickable" data-toggle="modal" data-target="#reaction_comment">0
                        <span class="icon-like icon has-text-success">
                            <i class="fas fa-thumbs-up"></i>
                        </span>
                    </span>
                    <span @click="getReaction('HATE', comment.id)" class="link-comment card-footer-item clickable" data-toggle="modal" data-target="#reaction_comment">0
                        <span class="icon-dislike icon has-text-danger">
                            <i class="fas fa-thumbs-down"></i>
                        </span>
                    </span>
                    <span @click="getReaction('DELETE', comment.id)" class="link-comment card-footer-item clickable" data-toggle="modal" data-target="#reaction_comment">0
                        <span class="icon-ban icon is-medium">
                            <span class="fa-stack fa-md">
                                <i class="fas fa-comments fa-stack-1x has-text-info"></i>
                                <i class="fas fa-ban fa-stack-2x has-text-danger"></i>
                            </span>
                        </span>
                    </span>
                </footer>
            </div>
        </template>
        <h3 v-else class="text-center p-3">Chưa có review nào hết, bạn viết review đi nào hihi!</h3>
        <nav class="pagination-list" aria-label="Pagination home" v-if="paginate.last_page > 1">
            <span class="pagination-summary">Trang <b>{{ paginate.current_page}}</b> trên tổng số <b>{{paginate.last_page}}</b></span>
            <Paginate
                v-model="paginate.current_page"
                :page-count=paginate.last_page
                :page-range="3"
                :margin-pages="2"
                :click-handler="getCommentDetail"
                :prev-text="''"
                :next-text="''"
                :container-class="'pagination pagination-sm'"
                :page-class="'page-item'"
                :page-link-class = "'page-link'"
            >
            </Paginate>
        </nav>
    </section>
</template>
<script>
  import _ from 'lodash';
  import Paginate from 'vuejs-paginate'
  export default {
    components: {
      Paginate
    },
    props: {
      apiList: {
        getCommentDetail: {
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
      getCommentDetail: _.debounce(function (pageNum) {
        let self = this;
        self.loading = true;
        let urlComment = self.apiList.getCommentDetail;
        if (_.isNumber(pageNum)) {
          urlComment += '?page=' + pageNum;
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
      }, 400),
      getReaction: function (action = 'LIKE', comment_id = 0) {
        if (comment_id) {
          let commentParent = {
            reaction: action,
            comment_id: comment_id
          };
          this.$emit('getCommentParent', commentParent);
        }
      }
    },
    created() {
      this.getCommentDetail();
    },
    watch: {
      comment: function (newComment) {
        if (!_.isEmpty(newComment)) {
          this.listComment.unshift(newComment);
        }
      }
    },
    filters: {
      showTimeAgo: function (dateTime) {
        return moment(dateTime).fromNow();
      }
    }
  }
</script>
