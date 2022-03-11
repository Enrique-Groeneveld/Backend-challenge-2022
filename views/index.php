<!DOCTYPE html>
<html lang="en">
<head>
    <title>To-Do</title>
	<script src=" https://cdn.jsdelivr.net/g/vue@2.0.0-rc.4,vue.resource@1.0.0" type="text/javascript"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
</head>
<body>
		<nav class="navbar navbar-dark bg-dark">
			<a class="navbar-brand col-12" href="#">Navbar</a>
		</nav>

	<div class="container " id="app">
		<i  @click="HideUnhide" class="fas fa-edit  text-right">  Edit rows or lists</i>		
		<h1> {{ appName }} </h1>
		<div class="input-group mb-3">
			<span class="input-group-text" id="basic-addon1">{{name}}</span>
			<input v-model="title" type="text" class="form-control" placeholder="List name" aria-label="List name" >
			<input type="button" value="Stuur naam naar database" v-on:click="postData">
		</div>

		<div class="row d-flex justify-content-center">
			<!-- Start list card -->
			<div class="card col-3 m-4 p-2 " v-for='(item, index) in lists'>

				<h5 class="card-title">{{item.title}}   {{item.id}}
					
				<i  @click="passUpdate(item)" v-show="hidden" class="fas fa-edit  text-right "style="float:right"
						data-bs-toggle="modal" data-bs-target="#updateModal"></i> 
						<i @click="deleteList(item.id)" v-show="hidden" style="float:right" class="fas fa-trash-alt text-danger "></i>	
				</h5>

				<ul  class="list-group list-group-flush" >
					<li class="list-group-item" v-for='(entry, index) in item.entries' v-if="entry.text">
						{{entry.text}}
						<i  @click="sendData2(entry)" v-show="hidden" class="fas fa-edit  text-right "style="float:right"
						data-bs-toggle="modal" data-bs-target="#exampleModal2"></i> 
						<i @click="deleteEntry(entry.id)" v-show="hidden" style="float:right" class="fas fa-trash-alt text-danger "></i>		
					</li>
				</ul>

				<button type="button" class="btn btn-primary" @click="sendData(item)" data-bs-toggle="modal" data-bs-target="#exampleModal">
				Add step <i class="fas fa-plus-square"></i>
			</button>
			</div>
			<!-- End card list -->
		</div>
		<!-- Binding Text - Semantic -->
				
		<div class="modal fade"	id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Add row to: {{passedItem.title}}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<input v-model="modalText" type="text" class="form-control" placeholder="List name" aria-label="row" aria-describedby="basic-addon1">
					</div>
					<div class="modal-footer">
						<button v-on:click="addRow(passedItem.id)" type="button" data-bs-dismiss="modal" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade"	id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Change name to: {{passedItem3.title}}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<input v-model="passedItem3.title" type="text" class="form-control" :placeholder="passedItem3.title" aria-label="row" aria-describedby="basic-addon1">
					</div>
					<div class="modal-footer">
						<button v-on:click="updateList(passedItem3)" type="button" data-bs-dismiss="modal" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade"	id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Change name to: {{passedItem2.text}}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<input v-model="modalText" type="text" class="form-control" :placeholder="passedItem2.text" aria-label="row" aria-describedby="basic-addon1">
					</div>
					<div class="modal-footer">
						<button v-on:click="addRow(passedItem2.id)" type="button" data-bs-dismiss="modal" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript">
	Vue.config.devtools = true;

	new Vue({ 
					// mount instance
		el: '#app',   // or document.getElementById('app')
					// Data property  - accessible in console: content.data.appName or content.appName
		data: {
			hidden: false,
			entry:'',
			name: '@',
			title: '',
			passedItem:{},
			passedItem2:{},
			passedItem3:{},
			modalText: '',
			appName: 'Amazing App',
			url: window.location,
			lists: '',
			entriesWithList: '',
		},
		methods: {
			HideUnhide: function () {
				this.hidden = this.hidden ? false : true;
			},
			deleteEntry: function (id){
				console.log(id);
				this.$http.get(this.url + 'list-entry/delete/'+id).then((data) => { 	
					data = (JSON.parse(data.data));
					console.log(data);
					this.lists = this.getLists();
				});	
			},

			deleteList: function (id){
				console.log(id);
				this.$http.get(this.url + 'list/deleteList/'+id).then((data) => { 	
					console.log(data);
				});	
			},

			sendData: function (item){
				this.passedItem = item;
				console.log(item);
			},
			
			sendData2: function (item){
				this.passedItem2 = item;
			},
			
			passUpdate: function (item){
				console.log(item);
				this.passedItem3 = item;
			},

			postData: function () {

				Vue.http.post(this.url + 'list/insert', {
						title: this.title,
				}).then((data) => { 	
					console.log(data);					
				});
				this.lists = this.getLists();

			},
			updateList: function (passedItem3) {

				Vue.http.post(this.url + 'list/update/' + this.passedItem3.id, {
						title: this.passedItem3.title,
				}).then((data) => { 	
					this.lists = this.getLists();					
				});


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
			},

			openModal: function(){
				$('#modal').modal();
			}
		},
		mounted() {

     		this.lists = this.getLists();
   	 	},
	});
</script>
</html>