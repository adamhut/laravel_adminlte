<template>
  <a href="javascript:void(0);" 
    class="sidebar-toggle" 
    data-toggle="offcanvas" 
    role="button"
    @click="handleSidebarToggle"
  >
    <span class="sr-only">Toggle navigation</span>
  </a>
</template>

<script>
  export default {
    data () {
      return {
        clickable: true
      }
    },
    created(){
       axios.get('/api/user').then(response=>console.log(response)).catch(data=>console.log(data));
       
    },
    methods: {
      handleSidebarToggle () {
        if (this.clickable) {
          this.clickable = false
          //document.body.classList.toggle('sidebar-collapse')
          document.body.classList.toggle('sidebar-collapse')
          axios.post('/api/v1/sidebar-toggle').then(response=>{
            console.log(response);
            this.clickable = true
          });
          this.clickable=true; 
          /*
          this.$http.post('/api/v1/sidebar-toggle').then(response => {
            this.clickable = true
          })
          */
        }        
      }
    }
  }
</script>
