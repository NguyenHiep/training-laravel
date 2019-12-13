<template>
    <div class="companies" :class="loading ? 'loading' : ''">
        <div class="loading-block text-center" v-show="loading">
            <i class="fa fa-spin fa-spinner fa-3x"></i>
        </div>
        <nav class="pagination-list" aria-label="Pagination home" v-if="paginate.last_page > 1">
            <span class="pagination-summary">{{ $t('Page') }} <b>{{ paginate.current_page}}</b> {{ $t('on total') }} <b>{{paginate.last_page}}</b></span>
            <Paginate
                v-model="paginate.current_page"
                :page-count=paginate.last_page
                :page-range="3"
                :margin-pages="2"
                :click-handler="getCompanyList"
                :prev-text="''"
                :next-text="''"
                :container-class="'pagination pagination-sm'"
                :page-class="'page-item'"
                :page-link-class = "'page-link'"
            >
            </Paginate>
        </nav>
        <template v-if="listCompany && listCompany.length > 0">
            <!-- Begin .company-item -->
            <div class="company-item" v-for="company in listCompany" :key="company.id">
                <div class="company-info">
                    <figure class="company-info__logo" v-if="company.logo">
                        <img  class="img-fluid" :src=company.logo :alt=company.name />
                    </figure>
                    <div class="company-info__detail">
                        <h2 class="company-info__name">
                            <a :href=company.company_url>{{ company.name }}</a>
                            <span class="company-info__rating">
                        <span class="icon has-text-warning" v-for="star in 5" :key="star">
                            <template v-if="company.avg_star >= star">
                                <i class="fas fa-star"></i>
                            </template>
                            <template v-else-if="isFloatNumber(company.avg_star) && Math.round(company.avg_star) === star">
                                <i class="fas fa-star-half-alt"></i>
                            </template>
                            <template v-else>
                                <i class="far fa-star"></i>
                            </template>
                         </span>
                        <span class="rating-count">({{ company.total_comment}})</span>
                      </span>
                        </h2>
                        <div class="company-info__other">
                            <span><i class="fas fa-briefcase"></i> {{ $t('selector.type.' + company.type) }}</span>
                            <span><i class="fas fa-users"></i> {{ company.size }}</span>
                        </div>
                        <div class="company-info__location">
                            <span><i class="fas fa-building"></i> {{ company.address }}</span>
                        </div>
                    </div> <!-- .company-info__detail -->
                </div>
            </div>
            <!-- End .company-item -->
        </template>
        <p v-else class="text-center p-5">{{ $t('Data empty') }}</p>
        <nav class="pagination-list" aria-label="Pagination home" v-if="paginate.last_page > 1">
            <span class="pagination-summary">{{ $t('Page') }} <b>{{ paginate.current_page}}</b> {{ $t('on total') }} <b>{{paginate.last_page}}</b></span>
            <Paginate
                v-model="paginate.current_page"
                :page-count=paginate.last_page
                :page-range="3"
                :margin-pages="2"
                :click-handler="getCompanyList"
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
<script>
  import _ from 'lodash';
  import Paginate from 'vuejs-paginate';

  export default {
    components: {
      Paginate
    },
    props: {
      apiList: {
        getCompanyList: {
          type: String,
          required: true
        }
      }
    },
    data: function () {
      return {
        listCompany: [],
        paginate: {
          current_page: 1,
          offset: 4,
          last_page: 0,
          total: 0,
        },
        loading: false,
        errored: false
      }
    },
    methods: {
      getCompanyList: _.debounce(function (pageNum) {
        let self = this;
        self.loading = true;
        let urlCompany = self.apiList.getCompanyList;
        if (_.isNumber(pageNum)) {
          urlCompany += '?page=' + pageNum;
          self.paginate.current_page = pageNum;
        }
        axios.get(urlCompany).then(response => {
          let responseData = response.data;
          if (responseData.success && !_.isEmpty(responseData.data.list_company)) {
            self.listCompany = responseData.data.list_company;
            self.paginate = responseData.data.paginate;
          }
          self.loading = false;
        }).catch(error => {
          console.log(error);
          self.errored = true;
        }).finally(() => self.loading = false)
      }, 300),
      isFloatNumber: function (num) {
        let number = parseInt(num);
        return !isNaN(number) && num.indexOf('.') !== -1;
      }
    },
    created() {
      this.getCompanyList();
    }
  }
</script>
