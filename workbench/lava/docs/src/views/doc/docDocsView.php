<pre id="json1"></pre>
<script type="text/javascript">
    var data = {
        "data": {
            "x": "1",
            "y": "1",
            "url": "http://url.com"
        },
        "event": "start",
        "show": 1,
        "id": 50
    }

    document.getElementById("json").innerHTML = JSON.stringify(data, undefined, 2);
</script>

<?php echo $viewData['modulesView']; ?>