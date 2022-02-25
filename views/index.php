<!DOCTYPE html>
<html lang="en">
<head>
    <title>To-Do</title>
	<script src=" https://cdn.jsdelivr.net/g/vue@2.0.0-rc.4,vue.resource@1.0.0" type="text/javascript"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
	<div class="container" id="app">
	<!-- Binding Text - Semantic -->
		<h1> {{ appName }} </h1>
		{{responseData2}}
		<h1 v-if="responseData"> Response:  </h1>
		<li v-for='(item2, index) in responseData2' >
				<p>{{item2}}</p>
			</li>
		<div v-for="(item, index) in responseData">
			<h1>{{item.name}}</h1>
			
			<!-- <ul class="list-group">
				<li class="list-group-item">Cras justo odio</li>
			</ul> -->
		</div>
		<input type="button" value="Haal text op" v-on:click="getData">
		<div class="input-group mb-3">
			<span class="input-group-text" id="basic-addon1">{{name}}</span>
			<input v-model="title" type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
			<input type="button" value="Stuur naam naar database" v-on:click="postData">
		</div>
	</div>
</body>
<script type="text/javascript">
	Vue.config.devtools = true;

	new Vue({ 
					// mount instance
		el: '#app',   // or document.getElementById('app')
					// Data property  - accessible in console: content.data.appName or content.appName
		data: {
			name: '@',
			title: '',
			appName: 'Amazing App',
			url: window.location,
			responseData: '',
			responseData2: '',
		},
		methods: {
			postData: function () {

				Vue.http.post(this.url + 'list/insert', {
						title: this.title,
				}).then((data) => { 	
					console.log(data);					
				});
			},

			getData: function () {
				this.$http.get(this.url + 'list/getAll').then((data) => { 	
					data = (JSON.parse(data.data));
					this.responseData = data.data;
				});
			},

			getEntries: function(id){
				// /list-entry/getWhere/list_id=id
				this.$http.get(this.url + '/list-entry/getWhere/list_id='+id).then((data) => { 
					data = (JSON.parse(data.data));
					console.log(data);	
					return data;
				});
			}
		},
		mounted() {
     		this.getData();
			this.responseData2 = this.getEntries(7);
   	 	},
	});
</script>
</html>