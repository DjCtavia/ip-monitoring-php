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
    <dialog id="addNewIPDialog">
        <form>
            <div>
                <label for="addressIP"><h1>Add new IP Address</h1></label>
                <input type="text" name="addressIP" id="addressIP" placeholder="192.168.0.128">
            </div>
            <div>
                <button value="cancel" formmethod="dialog">Cancel</button>
                <button id="confirmBtn" value="default">Add IP</button>
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
    <script src="assets/js/script.js"></script>
</body>
</html>