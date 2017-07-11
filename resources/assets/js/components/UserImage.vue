<template>
 	<img :src="imageSrc" :alt="alt" :class="imgClass">
</template>
<script>
  	export default {
	    props: ['src', 'alt', 'imgClass'],
	    created () {
	        this.imageSrc = this.src
	    },
	    data () {
	      	return {
	        	imageSrc: ''
	      	}
	    },
	    methods: {
	      	userImageChanged(imageSrc) {
	        	this.imageSrc = imageSrc
	        	console.log('image src changed to ', imageSrc)
	      	}
	    },
	    sockets: {
	      	user_image_uploaded(imageSrc) {
	        	console.log(imageSrc)
	        	//alert(2);
	        	this.userImageChanged(imageSrc)
	      	},
	    }
  	}
</script>