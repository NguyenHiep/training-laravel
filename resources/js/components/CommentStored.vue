<template>
    <div ref="formComment" class="modal fade" id="write_comment" tabindex="-1" role="dialog" aria-labelledby="write comment modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form @submit.prevent="storedComment" method="post" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" v-if="company.name">Viết Review công ty {{ company.name}}</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="form-group mb-0">
                        <label for="reviewer" class="col-form-label">Tên họ</label>
                        <input id="reviewer" v-model.trim="comment.reviewer" type="text" name="reviewer" class="form-control" placeholder="Muốn xưng tên thật thì xưng không thì thui" />
                    </div>
                    <div class="form-group mb-0">
                        <label for="position" class="col-form-label">Chức vụ</label>
                        <input id="position" v-model="comment.position" type="text" name="position" class="form-control" placeholder="Dev quèn/HR hay Manager" />
                    </div>
                    <div class="form-group mb-0">
                        <label for="content" class="col-form-label">Review công ty <span class="has-text-danger">(Bắt buộc)</span></label>
                        <textarea v-model.trim="comment.content" class="form-control" id="content" name="content" placeholder="Bức xúc hay gì thì viết dài dài vô (Tối thiểu 10 kí tự)" rows="5" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="score" class="col-form-label">Cho điểm công ty</label>
                        <select v-model="comment.store" id="score" name="score" class="form-control">
                            <option value="1">1 điểm - Max sida, né gấp kẻo hối hận</option>
                            <option value="2">2 điểm - Hết thuốc chữa, đang tính đường chuồn</option>
                            <option value="3">3 điểm - Cũng tạm, để coi sao</option>
                            <option value="4">4 điểm - Cũng ngon, nên làm lâu dài</option>
                            <option value="5">5 điểm - Công ty tuyệt cmn vời, đuổi cũng méo đi</option>
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
                    <p class="m-t-5">Người đăng chịu trách nhiệm về tính xác thực của nội dung chứ <strong>bên mình không có chịu</strong>, okay?</p>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success" :disabled="!verifyReCaptcha">Đăng review</button>
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
            position: '',
            content: '',
            store: '3',
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
          position: self.comment.position,
          content: self.comment.content,
          star: self.comment.store,
          company_id: self.company.id,
          g_recaptcha_response: self.g_recaptcha_response
        };
        axios.post(self.apiList.storedComment, dataSend).then(response => {
          let responseData = response.data;
          if (responseData.success) {
            //TODO: Push in list comment
            //self.listComment = responseData.data;
            let commentResult = responseData.data;
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
