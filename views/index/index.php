<html>
<head>
    <title>API Client</title>
    <script src="https://unpkg.com/vue"></script>
</head>
<body>
<h3>Api Client</h3>
<div id="app">
    {{ message }}
</div>

</body>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            message: 'Hello Auto Shop!'
        }
    })
</script>
</html>