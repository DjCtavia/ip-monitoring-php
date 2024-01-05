<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IP Monitoring</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <dialog id="addNewIPDialog" tabindex="-1">
        <form>
            <div>
                <label for="addressIP"><h1>Add new IP Address</h1></label>
                <input type="text" name="addressIP" id="addressIP" placeholder="192.168.0.128" tabindex="0" autofocus>
            </div>
            <p id="errorDiagIpAdd"></p>
            <div>
                <button value="cancel" formmethod="dialog" tabindex="2">Cancel</button>
                <button id="confirmBtn" value="default" tabindex="1">Add IP</button>
            </div>
        </form>
    </dialog>

    <div id="summary" class="group-bar">
        <h2>Summary</h2>
        <button class="add-btn" id="addNewIPButtonDialog">
            <div><img src="assets/img/add.svg" alt="Add button"></div>
            Add new IP
        </button>
    </div>

    <div class="card-holder" id="monitored_ip_list">

    </div>








    <template id="ip_monitoring_card_template">
        <h3 id="description">Description</h3>
        <p id="ipAddress">192.168.0.1</p>
        <p id="pingStatus">Online</p>
        <p id="timestamp"></p>
    </template>
    <script src="assets/js/api.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>