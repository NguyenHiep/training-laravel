<template>
   <article v-cloak>
       <HomeBanner :base-url="apiList.baseUrl"></HomeBanner>
       <CompanySearch :api-list="apiList"></CompanySearch>
       <section class="container main-content">
           <div class="row">
               <div class="col-12 col-lg-8">
                   <CompanyList :api-list="apiList"></CompanyList>
               </div>
               <div class="col-12 col-lg-4">
                   <CommentLatest :api-list="apiList"></CommentLatest>
               </div>
           </div>
       </section> <!-- End .main-content -->
   </article>
</template>
<script>
  import HomeBanner from '../components/HomeBanner.vue';
  import CommentLatest from '../components/CommentLatest.vue';
  import CompanySearch from '../components/CompanySearch.vue';
  import CompanyList from '../components/CompanyList.vue';

  export default {
    props: {
      apiList: {
        type: Object,
        required: true
      }
    },
    components: {
      HomeBanner,
      CommentLatest,
      CompanySearch,
      CompanyList
    }
  }
</script>
