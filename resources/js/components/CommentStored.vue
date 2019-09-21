<template>
    <div ref="formComment" class="modal fade" id="write_comment" tabindex="-1" role="dialog" aria-labelledby="write comment modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form @submit.prevent="storedComment" method="post" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" v-if="company.name">{{ $t('Write a Review Company') }} {{ company.name}}</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="form-group mb-0">
                        <label for="reviewer" class="col-form-label">{{ $t('Full name') }}</label>
                        <input id="reviewer" v-model.trim="comment.reviewer" type="text" name="reviewer" class="form-control" :placeholder="$t('If you want to confess your real name, you will confess your name')" />
                    </div>
                    <div class="form-group mb-0">
                        <label for="position" class="col-form-label">{{ $t('Position') }}</label>
                        <input id="position" v-model.trim="comment.position" type="text" name="position" class="form-control" :placeholder="$t('Dev / HR or Manager')" />
                    </div>
                    <div class="form-group mb-0">
                        <label for="content" class="col-form-label">{{ $t('Company Review') }} <span class="has-text-danger">({{ $t('required')}})</span></label>
                        <textarea v-model.trim="comment.content" class="form-control" id="content" name="content" :placeholder="$t('If you are annoyed or long, write it long (Minimum of 10 characters)')" rows="5" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="score" class="col-form-label">{{ $t('Score company') }}</label>
                        <select v-model="comment.store" id="score" name="score" class="form-control">
                            <option v-for="(value, key) in $t('selector.star')" :value="key">{{ value}}</option>
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
                    <p class="m-t-5">{{ $t('The poster is responsible for the authenticity of the content and does not accept it, okay?') }}</p>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success" :disabled="!verifyReCaptcha">{{ $t('Post a review') }}</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ $t('Cancel') }}̉</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</template>
<script>
  import commentStoredMixin from '../mixins/commentStoredMixin.js';

  export default {
    mixins: [ commentStoredMixin ],
    methods: {
      storedComment: function () {
        let self = this;
        self.loading = true;
        let dataSend = {
          reviewer: self.comment.reviewer,
          position: self.comment.position,
          content: self.comment.content,
          star: self.comment.store,
          company_id: self.company.id,
          g_recaptcha_response: self.g_recaptcha_response
        };
        axios.post(self.apiList.storedComment, dataSend).then(response => {
          let responseData = response.data;
          if (responseData.success) {
            self.$emit('storedComment', responseData.data);
            Object.assign(self.$data, self.resetData()); // Reset data component
            jQuery("#write_comment").modal('hide');
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
    mounted(){
      // Close form comment, reset google recaptcha
      jQuery(this.$refs.formComment).on("hidden.bs.modal", this.resetRecaptcha);
    }
  }
</script>
