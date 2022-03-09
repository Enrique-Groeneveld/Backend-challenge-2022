<!DOCTYPE html>
<html lang="en">
<head>
    <title>To-Do</title>
	<script src=" https://cdn.jsdelivr.net/g/vue@2.0.0-rc.4,vue.resource@1.0.0" type="text/javascript"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
</head>
<body>
	<div class="container" id="app">
	<div class="row">
		
		<div class="card col-sm-6" v-for='(item, index) in lists'>
				<div class="card-body">
				
					<h5 class="card-title">Titel: {{item.title}} <i style="font-size: 3em; color:tomato;" class="fas fa-trash-can"></i></h5>
				</div>
				<ul  class="list-group list-group-flush" >
					<li class="list-group-item" v-for='(entry, index) in item.entries' v-if="entry.text"> 
						{{entry.text}}
						<button>
							<i class="fa-solid fa-trash-can"></i>					
						</button>
					</li>
				</ul>
				
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" :data-bs-target="'#exampleModal' + item.id">
					Add row
				</button>	
				<div class="modal fade"	:id="'exampleModal' + item.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Add row to: {{item.title}}</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<input v-model="modalText" type="text" class="form-control" placeholder="Username" aria-label="row" aria-describedby="basic-addon1">
							</div>
							<div class="modal-footer">
								<button v-on:click="addRow(item.id)" type="button" data-bs-dismiss="modal" class="btn btn-primary">Save changes</button>
							</div>
						</div>
					</div>
				</div>
		</div>
		

		<!-- Modal -->
		
	</div>


	<!-- Binding Text - Semantic -->
		<h1> {{ appName }} </h1>
		
		
		<div class="input-group mb-3">
			<span class="input-group-text" id="basic-addon1">{{name}}</span>
			<input v-model="title" type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
			<input type="button" value="Stuur naam naar database" v-on:click="postData">
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

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
			modalText: '',
			appName: 'Amazing App',
			url: window.location,
			lists: '',
			entriesWithList: '',
		},
		methods: {
			postData: function () {

				Vue.http.post(this.url + 'list/insert', {
						title: this.title,
				}).then((data) => { 	
					console.log(data);					
				});
				this.lists = this.getLists();

			},
			addRow: function (id) {
				Vue.http.post(this.url + 'list-entry/insert', {
						list_id: id,
						text: this.modalText
				}).then((data) => { 	
					console.log(data);					
				});
				this.lists = this.getLists();
				this.modalText = '';
				console.log(id);
			},

			getLists: function () {
				this.$http.get(this.url + 'list/getEntriesWithLists').then((data) => { 	
					data = (JSON.parse(data.data));
					this.lists = data.data;
				});				
			},

			getEntries: function(id){
				// /list-entry/getWhere/list_id=id
				this.$http.get(this.url + '/list-entry/getWhere/list_id='+id).then((data) => { 
					data = (JSON.parse(data.data));
					this.entriesWithList = data;
					this.test = data.data;
				});
			}
		},
		mounted() {
     		this.lists = this.getLists();
   	 	},
	});
</script>
</html>