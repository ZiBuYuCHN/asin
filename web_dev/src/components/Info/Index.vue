<template>
	<div id="main">
		<div></div>
	</div>
</template>

<script>
export default {
	name: 'Index',
	data () {
		return {
			msg: '欢迎来到刺客组织',
			userInfo: {}
		}
	},
	methods: {
		getUserInfo: function() {
			let id = this.$route.params.id;
			orzzz.$post({
				mod: 'home_userinfo',
				action: 'getUserInfo',
				qq: id,
				success: (res)=> {
					console.log('success:::',res);
					this.userInfo = res;
				},
				fail: (res)=> {
					console.log('faile:::',res);
				}
			})
		}
	},
	mounted: function() {
		console.log('info::',this.$route);
		this.getUserInfo();
	}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
ul { list-style-type: none; padding: 0; margin: 10px auto; }
li { display: block; font-size: 2em; border-bottom: 1px solid #dedede; }
li.top { font-size: 4em; font-weight: bold; width: 100%; border-top: 1px solid #dedede; }
span { display: inline-block; }
span.rank { width: 30%; }
span.nickname { width: 35%; }
span.score { width: 30%; }
h1, h2 {
  font-weight: normal;
}
a {
  color: #42b983;
}
</style>