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
<h1>Note the following:</h1>
<p>All API's must have parameter \'format\' whose value must be \'json\' so as to return JSON format. Please include it.</p>
<p>In the JSON returned by all API's, I've changed property \'httpStatusCode\' to \'http_status_code\' and \'systemCode\' to \'system_code\'.</p>
<?php echo $viewData['modulesView']; ?>