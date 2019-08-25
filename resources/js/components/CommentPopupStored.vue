<template>
    <div ref="formReactionComment" class="modal fade" id="reaction_comment" tabindex="-1" role="dialog" aria-labelledby="write reaction comment modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form @submit.prevent="storedComment" method="post" action="" class="w-100 mx-auto">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label for="reviewer" class="col-form-label">Tên họ</label>
                            <input id="reviewer" v-model.trim="comment.reviewer" type="text" name="reviewer" class="form-control" placeholder="Muốn xưng tên thật thì xưng không thì thui" />
                        </div>
                        <div class="form-group mb-0">
                            <label for="content" class="col-form-label">Comment <span class="has-text-danger">(Bắt buộc)</span></label>
                            <textarea v-model.trim="comment.content" class="form-control" id="content" name="content" placeholder="Bức xúc hay gì thì viết dài dài vô (Tối thiểu 10 kí tự)" rows="5" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="reaction" class="col-form-label">Bày tỏ thái độ</label>
                            <select v-model="comment.reaction" id="reaction" name="reaction" class="form-control">
                                <option value="LIKE">👍 Like</option>
                                <option value="HATE">👎 Đếch lai</option>
                                <option value="DELETE">❌ Xóa giùm</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <vue-recaptcha
                                ref="recaptcha"
                                @verify="onVerify"
                                @expired="onExpired"
                                :sitekey="siteKey">
                            </vue-recaptcha>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="submit" class="btn btn-success" :disabled="!verifyReCaptcha">Đăng Comment</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  import VueRecaptcha from 'vue-recaptcha';
  import _ from 'lodash';
  // TODO: move site key
  const SITE_KEY = '6LfNBrQUAAAAAO8s0CWXvr8IsXFvATYatJ01Hor1';
  const REACTION_COMMENT = 'COMMENT';
  const REACTION_LIKE = 'LIKE';
  const REACTION_HATE = 'HATE';
  const REACTION_DELETE = 'DELETE';
  const DEFAULT_CONTENT_LIKE = 'Bác nói đúng vãi, tặng 1 like';
  const DEFAULT_CONTENT_HATE = 'Review nhảm nhí, dislike';
  const DEFAULT_CONTENT_DELETE = 'Xóa review này giùm!';
  export default {
    components: {
      VueRecaptcha
    },
    props: {
      apiList: {
        storedComment: {
          type: String,
          required: true
        }
      },
      company: {
        type: Object,
        required: true
      },
      comment_parent: {
        type: Object,
        required: true
      }
    },
    data: function () {
      return this.resetData()
    },
    methods: {
      onVerify: function (response) {
        if (!_.isEmpty(response)) { // If Verify success
          this.verifyReCaptcha = true;
          this.g_recaptcha_response = response;
        }
      },
      onExpired: function () {  // Expired reCaptCha
        this.g_recaptcha_response = '';
        this.verifyReCaptcha = false;
      },
      resetRecaptcha() {
        this.$refs.recaptcha.reset(); // Direct call reset method
        this.verifyReCaptcha = false;
        this.g_recaptcha_response = '';
      },
      resetData: function () {
        return {
          siteKey: SITE_KEY,
          comment: {
            reviewer: '',
            content: '',
            store: '3',
            reaction: REACTION_LIKE
          },
          verifyReCaptcha: false,
          g_recaptcha_response: ''
        }
      },
      storedComment: function () {
        let self = this;
        self.loading = true;
        let dataSend = {
          reviewer: self.comment.reviewer,
          content: self.comment.content,
          reaction: self.comment.reaction,
          company_id: self.company.id,
          star: self.comment.store,
          parent_id: self.comment_parent.comment_id,
          g_recaptcha_response: self.g_recaptcha_response
        };
        axios.post(self.apiList.storedComment, dataSend).then(response => {
          let responseData = response.data;
          if (responseData.success) {
            self.$emit('storedReaction', responseData.data);
            Object.assign(self.$data, self.resetData()); // Reset data component
            jQuery("#reaction_comment").modal('hide');
            self.resetRecaptcha();
            self.loading = false;
          }
        }).catch(error => {
          console.log(error);
          self.errored = true;
        }).finally( function() {
          self.loading = false;
          self.resetRecaptcha();
        })
      }
    },
    watch: {
      comment_parent: function (newComment) {
        if (!_.isEmpty(newComment) && newComment.reaction == REACTION_COMMENT) {
          this.comment.reaction = REACTION_LIKE;
          this.comment.content = '';
        }
        if (!_.isEmpty(newComment) && newComment.reaction == REACTION_LIKE) {
          this.comment.reaction = REACTION_LIKE;
          this.comment.content = DEFAULT_CONTENT_LIKE;
        }
        if (!_.isEmpty(newComment) && newComment.reaction == REACTION_HATE) {
          this.comment.reaction = REACTION_HATE;
          this.comment.content = DEFAULT_CONTENT_HATE;
          this.comment.store = '2';
        }
        if (!_.isEmpty(newComment) && newComment.reaction == REACTION_DELETE) {
          this.comment.reaction = REACTION_DELETE;
          this.comment.content = DEFAULT_CONTENT_DELETE;
          this.comment.store = '1';
        }
      }
    },
    mounted(){
      // Close form comment, reset google recaptcha
      jQuery(this.$refs.formReactionComment).on("hidden.bs.modal", this.resetRecaptcha);
    }
  }
</script>