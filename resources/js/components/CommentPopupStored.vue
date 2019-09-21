<template>
    <div ref="formReactionComment" class="modal fade" id="reaction_comment" tabindex="-1" role="dialog" aria-labelledby="write reaction comment modal" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <form @submit.prevent="storedCommentReply" method="post" action="" class="w-100 mx-auto">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label for="reviewer" class="col-form-label">{{ $t('Full name')}}</label>
                            <input id="reviewer" v-model.trim="comment.reviewer" type="text" name="reviewer" class="form-control" :placeholder="$t('If you want to confess your real name, you will confess your name')" />
                        </div>
                        <div class="form-group mb-0">
                            <label for="content" class="col-form-label">{{ $t('Comment')}} <span class="has-text-danger">({{ $t('required')}})</span></label>
                            <textarea v-model.trim="comment.content" class="form-control" id="content" name="content" :placeholder="$t('If you are annoyed or long, write it long (Minimum of 10 characters)')" rows="5" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="reaction" class="col-form-label">{{ $t('Express attitude')}}</label>
                            <select v-model="comment.reaction" id="reaction" name="reaction" class="form-control">
                                <option v-for="(value, key) in $t('selector.reaction')" :value="key" v-html="value"></option>
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
                        <button type="submit" class="btn btn-success" :disabled="!verifyReCaptcha">{{ $t('Post Comment')}}</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ $t('Cancel')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  import commentStoredMixin from '../mixins/commentStoredMixin.js';
  const REACTION_COMMENT = 'COMMENT';
  const REACTION_LIKE = 'LIKE';
  const REACTION_HATE = 'HATE';
  const REACTION_DELETE = 'DELETE';
  const DEFAULT_CONTENT_LIKE = 'Bác nói đúng vãi, tặng 1 like';
  const DEFAULT_CONTENT_HATE = 'Review nhảm nhí, dislike';
  const DEFAULT_CONTENT_DELETE = 'Xóa review này giùm!';

  export default {
    mixins: [ commentStoredMixin ],
    props: {
      comment_parent: {
        type: Object,
        required: true
      }
    },
    data: function () {
      return this.resetData()
    },
    methods: {
      resetData: function () {
        return {
          siteKey: SITE_KEY,
          comment: {
            reviewer: '',
            content: '',
            reaction: REACTION_LIKE
          },
          verifyReCaptcha: false,
          g_recaptcha_response: '',
          loading: false,
          errored: false
        }
      },
      storedCommentReply: function () {
        let self = this;
        self.loading = true;
        let dataSend = {
          reviewer: self.comment.reviewer,
          content: self.comment.content,
          reaction: self.comment.reaction,
          comment_id: self.comment_parent.comment_id,
          g_recaptcha_response: self.g_recaptcha_response
        };
        axios.post(self.apiList.storedCommentReply, dataSend).then(response => {
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
        if (!_.isEmpty(newComment) && newComment.reaction === REACTION_COMMENT) {
          this.comment.reaction = REACTION_LIKE;
          this.comment.content = '';
        }
        if (!_.isEmpty(newComment) && newComment.reaction === REACTION_LIKE) {
          this.comment.reaction = REACTION_LIKE;
          this.comment.content = DEFAULT_CONTENT_LIKE;
        }
        if (!_.isEmpty(newComment) && newComment.reaction === REACTION_HATE) {
          this.comment.reaction = REACTION_HATE;
          this.comment.content = DEFAULT_CONTENT_HATE;
          this.comment.store = '2';
        }
        if (!_.isEmpty(newComment) && newComment.reaction === REACTION_DELETE) {
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
