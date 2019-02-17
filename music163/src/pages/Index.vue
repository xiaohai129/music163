<template>
  <div>
    <banner/>
    <div class="content-wrap">
      <div class="c-left">
        <rec-list/>
      </div>
      <div class="c-right"></div>
    </div>
  </div>
</template>

<script>
  import Banner from "../components/Banner"
  import RecList from "../components/RecList"
  export default {
    components:{
      "banner":Banner,
      "rec-list":RecList
    }
  }
</script>

<style lang="scss" scoped>
</style>