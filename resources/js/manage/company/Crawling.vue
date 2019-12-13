<template>
    <section v-cloak :class="loading ? 'loading' : ''">
        <div class="loading-block text-center" v-show="loading">
            <i class="fa fa-spin fa-spinner fa-3x"></i>
        </div>
        <form class="mb-3" @submit.prevent="preview()">
            <div class="form-group">
                <label for="crawlingDomain">Crawling domain</label>
                <input v-model.trim="urlCrawling" type="url" class="form-control" id="crawlingDomain" placeholder="Ex: example.com" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="lbl_domain">Domain</label>
                    <input type="text" min="0" max="9999" class="form-control" id="lbl_domain" placeholder="Ví dụ: minhhiep.info" />
                </div>
                <div class="form-group col-md-2">
                    <label for="lbl_loop">Số lần lặp</label>
                    <input type="number" min="0" max="9999" class="form-control" id="lbl_loop" placeholder="Ví dụ: 10" />
                </div>
                <div class="form-group col-md-7">
                    <label for="lbl_pattern">Cấu trúc</label>
                    <input type="text" class="form-control" id="lbl_pattern" placeholder="Nhập class hoặc id nhóm dữ liệu muốn thu thập" />
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="preview-crawling" v-if="previewData && !loading">
            <form @submit.prevent="previewExportData">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="d-block w-100">&nbsp;</label>
                        <button type="submit" class="from-control btn btn-primary">Export data</button>
                    </div>
                </div>
            </form>
            <div class="preview-result overflow-auto" style="max-height: 350px; background: rgb(209,209,209);">
                <samp>
                    <pre>
                        <code>
                            {{ previewData}}
                        </code>
                    </pre>
                </samp>
            </div>
        </div>

    </section>
</template>
<script>
  import _ from 'lodash';
  const PREVIEW_CRAWLING_URL = '/manage/companies/crawling';
  export default {
    name: "CompanyCrawling",
    data: function () {
      return {
        urlCrawling: '',
        previewData: '',
        loading: false,
        errored: false
      }
    },
    methods: {
      preview() {
        let self = this;
        self.loading = true;
        let dataSend = {
          url_crawling: self.urlCrawling
        };
        axios.post(PREVIEW_CRAWLING_URL, dataSend).then(response => {
          let responseData = response.data;
          if (responseData.success && !_.isEmpty(responseData.data)) {
            self.previewData = _.head(responseData.data);
          }
          self.loading = false;
        }).catch(error => {
          console.log(error);
          self.errored = true;
        }).finally(() => self.loading = false);
      },
      previewExportData() {
        let self = this;
        self.loading = true;

        if (!_.isEmpty(self.previewData)) {
          console.log(self.previewData);
        }

        var all = $(".company-item").map(function() {
          return this.innerHTML;
        }).get();
        console.log(all);
      }
    }
  }
</script>
