<template>
    <section class="container section-search">
        <div class="bg-description">
            <h2>Review lương bổng, đãi ngộ, HR, sếp và công việc,... gì cũng có</h2>
            <div class="form-search">
                <form action="" method="get" class="form-search">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-search"></i></span>
                        </div>
                        <input name="q"
                               v-model="textSearch"
                               autocomplete="off"
                               type="text"
                               class="form-control"
                               placeholder="Tìm công ty"
                               required
                               @keyup="searchCompany()"
                        />
                    </div>
                    <div class="autocomplete-suggestions"
                         v-if="listCompany && listCompany.length > 0"
                         v-click-outside="outsideResultSearch"
                    >
                        <div class="autocomplete-suggestion" v-for="(company, key) in listCompany" :key="key">
                            <a :href=company.company_url class="d-flex align-items-center w-100 link-company-detail">
                                <figure class="company-logo image is-32x32">
                                    <img :src=company.logo :alt=company.name />
                                </figure>
                                <span class="company-name" v-html="company.name"></span>
                            </a>
                        </div>
                    </div> <!-- End .autocomplete-suggestions-->
                </form>
            </div>
        </div>
    </section> <!-- End .section-search -->
</template>
<script>
  import _ from 'lodash';
  export default {
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
        textSearch: '',
        listCompany: [],
        clickOutside: 0,
        loading: false,
        errored: false
      }
    },
    methods: {
      searchCompany: _.debounce(function () {
        let self = this;
        if (_.isEmpty(self.textSearch)) {
          self.listCompany = [];
          return false;
        }
        let urlSearch = self.apiList.getCompanyList + '?q=' + self.textSearch;
        self.loading = true;
        axios.get(urlSearch).then(response => {
          let responseData = response.data;
          if (responseData.success && !_.isEmpty(responseData.data)) {
            let listCompany = responseData.data;
            // Highlight keyword search in result by tag <strong>
            _.forEach(listCompany, function (company) {
              let resultString = company.name;
              self.textSearch.replace(/(\s+)/, "(<[^>]+>)*$1(<[^>]+>)*");
              let pattern = new RegExp("(" + self.textSearch + ")", "gi");
              resultString = resultString.replace(pattern, "<strong>$1</strong>");
              resultString = resultString.replace(/(<span>[^<>]*)((<[^>]+>)+)([^<>]*<\/span>)/, "$1</strong>$2<strong>$4");
              company.name = resultString;
            });
            self.listCompany = listCompany;
          }
          self.loading = false;
        }).catch(error => {
          console.log(error);
          self.errored = true;
        }).finally(() => self.loading = false)
      }, 400),
      outsideResultSearch: function () {
        this.clickOutside += 1;
        if (this.clickOutside > 0 && !_.isEmpty(this.listCompany)) {
          this.listCompany = []; // Reset data
        }
      },
    },
    directives: {
      'click-outside': {
        bind: function (el, binding, vNode) {
          // Define Handler and cache it on the element
          const bubble = binding.modifiers.bubble;
          const handler = (e) => {
            if (bubble || (!el.contains(e.target) && el !== e.target)) {
              binding.value(e)
            }
          };
          el.__vueClickOutside__ = handler

          // add Event Listeners
          document.addEventListener('click', handler)
        },

        unbind: function (el, binding) {
          // Remove Event Listeners
          document.removeEventListener('click', el.__vueClickOutside__);
          el.__vueClickOutside__ = null

        }
      }
    }
  }
</script>
