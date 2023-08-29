<?php
?>

<!DOCTYPE HTML>

<html>

<head>
    <title>Ray</title>
    <script src="jquery-3.6.3.min.js"></script>
</head>

<body>
<div id="msg"></div>

<script>
    const notifyConnection = new EventSource('http://ray.test/index.php?sse=1');
    notifyConnection.onmessage = function (event) {
        const data = JSON.parse(event.data);
        console.log(data);
        const div = $("#msg");
        data.payloads.forEach((payload) => {
            div.after("<hr />");
            div.after("<div>[" + currentTime() + "] " + payload.origin.file + ": " + payload.origin.line_number + "</div>");
            if (payload.content.values) {
                payload.content.values.forEach((value) => {
                    if (typeof value === 'string') {
                        value = value.indexOf('Sfdump = window.Sfdump ||') !== -1 ? value : escapeHtml(value);
                    }
                    div.after("<div style='background-color: #18171b; padding-left: 3px;'><span style='color: #ffffff;'>" + value + "</span></div>");
                });
            } else {
                div.after("<div style='background-color: #18171b; padding-left: 3px;'><span style='color: #ffffff;'>" + payload.content.content + " (" + payload.content.label + ")</span></div>");
            }
            // div.after(currentTime());
        });
    }

    function currentTime() {
        const dt = new Date();
        return  dt.getHours() + ":" + ((dt.getMinutes()<10?'0':'') + dt.getMinutes()) + ":" + ((dt.getSeconds()<10?'0':'') + dt.getSeconds());
    }
    function escapeHtml(text) {
        if (text === '')
            return 'пустая строка';
        if (text === ' ')
            return 'один пробел';

        let map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
</script>
</body>

</html>
