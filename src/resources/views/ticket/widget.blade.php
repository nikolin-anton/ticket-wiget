<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket wiget</title>
    <link rel="stylesheet" href="{{asset('css/widget.css')}}">
</head>
<body>
    <div class="widget-container">
        <h1 class="widget-title">Ticket form</h1>
        <form class="widget-form" id="widget-form">
            <div class="widget-field">
                <label for="name">Name</label>
                <input class="widget-input" name="name" type="text" placeholder="name">
            </div>
            <div class="widget-field">
                <label for="email">Email</label>
                <input class="widget-input" name="email" type="email" placeholder="email">
            </div>
            <div class="widget-field">
                <label for="phone">Phone</label>
                <input class="widget-input" name="phone" type="text" placeholder="+12125551212">
            </div>
            <div class="widget-field">
                <label for="subject">Subject</label>
                <input class="widget-input" name="subject" type="text" placeholder="subject">
            </div>
            <div class="widget-field">
                <label for="text">Text</label>
                <input class="widget-input" name="text" type="text" placeholder="text">
            </div>
            <div class="widget-field">
                <label for="files">Attachment</label>
                <input class="widget-input-file" type="file" name="files">
            </div>
            <button class="widget-button" type="submit">Send</button>
        </form>
        <div id="message" class="message"></div>
    </div>
</body>
</html>
