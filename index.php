<html>
<head>
<meta name="viewport" content="width=device-width">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
}
</script>
<style>
.outer {
        display: table;
        position: relative;
        height: 100%;
        width: 100%;
}
.middle {
        display: table-cell;
        vertical-align: middle;
}
.inner {
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        overflow: hidden;
}
* {
        font-family:Verdana;
        background-color: #E5E8EA;
        text-align: center;
        color: #443D35
}
</style>
<link rel="icon" href="favi.png"/>
<title>Simple Shortener</title>
</head>
<body>
<div class="outer">
        <div class="middle">
                <div class="inner">
                        <?php
                        include 'indexManager.php';
                        ?>
                </div>
        </div>
</div>
</body>
</html>
