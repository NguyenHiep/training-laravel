<template>
    <div class="modal fade" id="write_comment" tabindex="-1" role="dialog" aria-labelledby="write comment modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Viết Review công ty Hương Việt Group</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="form-group mb-0">
                            <label for="reviewer" class="col-form-label">Tên họ</label>
                            <input id="reviewer" type="text" name="reviewer" class="form-control" placeholder="Muốn xưng tên thật thì xưng không thì thui" />
                        </div>
                        <div class="form-group mb-0">
                            <label for="position" class="col-form-label">Chức vụ</label>
                            <input id="position" type="text" name="position" class="form-control" placeholder="Dev quèn/HR hay Manager" />
                        </div>
                        <div class="form-group mb-0">
                            <label for="content" class="col-form-label">Review công ty <span class="has-text-danger">(Bắt buộc)</span></label>
                            <textarea class="form-control" id="content" name="content" placeholder="Bức xúc hay gì thì viết dài dài vô (Tối thiểu 10 kí tự)" rows="5" required></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <label for="score" class="col-form-label">Cho điểm công ty</label>
                            <select id="score" name="score" class="form-control">
                                <option value="1">1 điểm - Max sida, né gấp kẻo hối hận</option>
                                <option value="2">2 điểm - Hết thuốc chữa, đang tính đường chuồn</option>
                                <option value="3" selected>3 điểm - Cũng tạm, để coi sao</option>
                                <option value="4">4 điểm - Cũng ngon, nên làm lâu dài</option>
                                <option value="5">5 điểm - Công ty tuyệt cmn vời, đuổi cũng méo đi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            Google capcha
                        </div>
                    </form>
                    <p class="m-t-5">Người đăng chịu trách nhiệm về tính xác thực của nội dung chứ <strong>bên mình không có chịu</strong>, okay?</p>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Đăng review</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  export default {
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
      /*getCommentLatest: function () { // TODO: Check api external
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
      }*/
    },
    created() {
        //this.getCommentLatest();
    },
    filters: {
        // showTimeAgo: function (dateTime) {
        //   return moment(dateTime).fromNow();
        // }
    }
  }
</script>
