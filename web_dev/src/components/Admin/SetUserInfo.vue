<template>
	<div id="joinOrgan">
		<!-- <h2>该项目为开源项目，代码已上传至&nbsp;&lt;&nbsp;<a href="https://github.com/ZiBuYuCHN/asin" target="_blank">github</a>&nbsp;&nbsp;（你懂的）</h2> -->
		<ul>
			<li><span class="tdTile">栏目</span><span class="tdTile">值</span><span class="tdTile">备注</span></li>
			<li v-for="(item,key) in liObj">
				<label :for="key" :class="item.must ? 'must' : ''">{{ item.title }}</label>
				<input v-if="item.type != 'textarea'" :type="item.type" :id="key" :ref="key" @blur="check(key)" :value="item.default" :disabled="item.noChange">
				<textarea v-else :id="key" :ref="key">{{ item.default }}</textarea>
				<span>{{ item.note }}</span>
			</li>
		</ul>
		<br>
		<input type="submit" id="postForm" value="提交" class="postForm" @click="postForm">
	</div>
</template>

<script>
export default {
	name: 'JoinOrgan',
	data () {
		return {
			liObj: {
				qq: {
					title: 'QQ',
					type: 'number',
					default: '',
					note: '必填/用户QQ号，用作账号绑定',
					must: true
				},
				nickname: {
					title: '姓名',
					type: 'text',
					default: '',
					note: '必填/显示在刺客组织里的名称',
					must: true
				},
				sex: {
					title: '性别',
					type: 'number',
					default: 0,
					note: '默认为0；0为未知，1为男，2为女'
				},
				age: {
					title: '年龄',
					type: 'number',
					default: 16,
					note: '默认为16'
				},
				height: {
					title: '身高',
					type: 'number',
					default: 170,
					note: '默认为0，单位为cm'
				},
				weight: {
					title: '体重',
					type: 'number',
					default: 50,
					note: '默认为50，单位为kg'
				},
				str: {
					title: '力量',
					type: 'number',
					default: 20,
					note: '默认为20'
				},
				dex: {
					title: '敏捷',
					type: 'number',
					default: 20,
					note: '默认为20'
				},
				con: {
					title: '体质',
					type: 'number',
					default: 20,
					note: '默认为20'
				},
				ine: {
					title: '智力',
					type: 'number',
					default: 20,
					note: '默认为20'
				},
				wis: {
					title: '感知',
					type: 'number',
					default: 20,
					note: '默认为20'
				},
				cha: {
					title: '魅力',
					type: 'number',
					default: 20,
					note: '默认为0'
				},
				free: {
					title: '自由属性点',
					type: 'number',
					default: 20,
					note: '默认为20'
				},
				arms: {
					title: '武器',
					type: 'textarea',
					default: '',
					note: '默认为空'
				},
				introduce: {
					title: '介绍',
					type: 'textarea',
					default: '此人太过神秘，暂时没有相关信息',
					note: '默认为：此人太过神秘，暂时没有相关信息'
				},
				skill1: {
					title: '技能1',
					type: 'textarea',
					default: '',
					note: '默认为空'
				},
				skill2: {
					title: '技能2',
					type: 'textarea',
					default: '',
					note: '默认为空'
				},
				skill3: {
					title: '技能3',
					type: 'textarea',
					default: '',
					note: '默认为空'
				},
				skill4: {
					title: '技能4',
					type: 'textarea',
					default: '',
					note: '默认为空'
				},
				score: {
					title: '积分',
					type: 'number',
					default: 0,
					note: '默认为0/NPC设置为负数'
				},
				credit: {
					title: '暗币',
					type: 'number',
					default: 0,
					note: '默认为0'
				},
				rank: {
					title: '排名',
					type: 'number',
					default: 0,
					note: '设置NPC排名/默认为0，一般不填此值'
				}
			}
		}
	},
	methods: {
		checkLogin() {
			let token = localStorage.getItem("token");
			if (token) {
				orzzz.$post({
					mod: 'user_login',
					token: token,
					fail: (res)=> {
						alert(res.errMsg);
						this.$router.replace({path:'/admin/login'});
					}
				});
			} else {
				this.$router.replace({path:'/admin/login'});
			}
		},
		check: function (key) {
			if (key != 'qq') return;
			let qq = this.$refs.qq[0].value;
			if (!qq) return;
			if (this._hasId) return;
			orzzz.$post({
				mod: 'home_userinfo',
				action: 'getUserInfo',
				qq: qq,
				success: (res)=>{
					alert('该QQ号已加入刺客系统');
				}
			})
		},
		postForm: function () {
			var refs = this.$refs;
			let action = this._hasId ? 'newUserInfoByWeb' :'newUserInfo';
			let qq = this.$refs.qq[0].value;
			let data = {
				mod: 'home_userinfo',
				action: action,
				success: (res)=>{
					let msg = '';
					if (this._hasId) msg = '修改成功';
					else msg = '添加成功';
					alert(msg);
					this.$router.replace({path:'/admin/setUserInfo/'+qq});
				},
				fail: (res)=>{
					let msg = '';
					if (this._hasId) msg = '修改失败';
					else msg = '添加失败';
					alert(msg+"\n错误代码："+res.errCode+"\n错误信息："+res.errMsg);
				}
			};
			for (let key in refs) {
				if (key == 'qq' && !refs[key][0].value) {
					alert('QQ号不可为空');
					return;
				}
				if (key == 'nickname' && !refs[key][0].value) {
					alert('昵称不可为空');
					return;
				}
				data[key] = refs[key][0].value;
			}
			orzzz.$post(data);
		},
		getUserInfo: function () {
			orzzz.$post({
				mod: 'home_userinfo',
				action: 'getUserInfoByWeb',
				qq: this.$route.params.id,
				success: (res)=>{
					this.liObj.qq.noChange = true;
					for (let key in res) {
						if (this.liObj[key]) this.liObj[key].default = res[key];
					}
				},
				fail: (res)=>{
					alert('没有该用户');
					this.$router.replace({path:'/admin/setUserInfo/'});
				}
			})
		}
	},
	mounted: function () {
		this.checkLogin();
		if (this._hasId) this.getUserInfo();
	},
	computed: {
		_hasId: function () {
			return ('id' in this.$route.params);
		}
	}
};
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
#joinOrgan { text-align: left; }
table { width: 98%; margin: 0 auto; }
tr { border-bottom: 1px solid #dedede; }
td { text-align: left; }
.tdTile { font-weight: bold; font-size: 18px; }
.must { color: #FF0000; }
.postForm { margin: 0 0 20px 20px; padding: 5px 10px; }
label { cursor: pointer; display: inline-block; width: 5%; }
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
  width: 98%;
}
li {
  display: inline-block;
  margin: 0 10px;
  padding: 5px 0;
  width: 100%;
  border-bottom: 1px solid #dedede;
}
a {
  color: #42b983;
}
</style>