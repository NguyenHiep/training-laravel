<template>
    <section class="container-fuild bg-banner">
        <div class="bg-banner-gradient"></div>
        <img class="bg-banner-img img-fluid" :src=bannerImageUrl alt="banner image" />
    </section> <!-- .bg-banner -->
</template>
<script>
  export default {
    props: {
      baseUrl: {
        type: String,
        required: true
      }
    },
    computed: {
      bannerImageUrl: function () {
        return this.baseUrl + '/images/banner.jpg';
      }
    }
  }
</script>
