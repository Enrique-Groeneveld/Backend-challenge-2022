<!DOCTYPE html>
<html lang="en">
<head>
    <title>To-Do</title>
</head>
<body>
<div id="app">
<!-- Binding Text - Semantic -->
    <h1> {{ appName }} </h1>
    <h1 v-if="responseData"> Response:  </h1>
	<li v-for="(item, index) in responseData">
    {{ item.id }} - {{ item.text }}
  </li>
	<input type="button" value="Haal text op" v-on:click="getData">
</div>
    <script src="https://unpkg.com/vue@2.4.2/dist/vue.min.js" type="text/javascript"></script>
    <script type="text/javascript">
		Vue.config.devtools = true;

         new Vue({ 
                      // mount instance
            el: '#app',   // or document.getElementById('app')
                        // Data property  - accessible in console: content.data.appName or content.appName
            data: {
                appName: 'Amazing App',
				responseData: '',
				url: window.location,
            },
			methods: {
				getData: function () {
					var xmlHttp = new XMLHttpRequest();
					xmlHttp.open( "GET", this.url + "List-entry/getAll", false ); // false for synchronous request
					xmlHttp.send( null );
					this.responseData = JSON.parse(xmlHttp.responseText).data;

					// this.responseData = ;
					return 
				}
        	}
        });
    </script>
</body>
</html>