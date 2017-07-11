<template>
	<div class="info-box">
		<span class="info-box-icon" :class="color">
	    	<i class="fa" :class="icon"></i>
	  	</span>

	  	<div class="info-box-content">
	    	<span class="info-box-text" v-html="text"></span>
	    	<span class="info-box-number" v-html="number">{{number}}</span>
	  	</div>
	  <!-- /.info-box-content -->
	</div>
</template>
<script>
  export default {
    props: ['text', 'number', 'color', 'icon']
  }
</script>