<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <create-post />
            </div>
            <div class="col-md-6 posts-container" style="height: 35rem; overflow-y: auto">
                <all-posts />
            </div>
        </div>
    </div>
</template>
<script>
  export default {
    mounted() {
      //
    }
  }
</script>
