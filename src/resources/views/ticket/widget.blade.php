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
        <form class="widget-form" id="widget-form" enctype="multipart/form-data">
            <div class="widget-field">
                <label for="name">Name</label>
                <input class="widget-input" name="name" type="text" placeholder="name">
                <div class="widget-error" id="error-name"></div>
            </div>
            <div class="widget-field">
                <label for="email">Email</label>
                <input class="widget-input" name="email" type="email" placeholder="email">
                <div class="widget-error" id="error-email"></div>
            </div>
            <div class="widget-field">
                <label for="phone">Phone</label>
                <input class="widget-input" name="phone" type="text" placeholder="+12125551212">
                <div class="widget-error" id="error-phone"></div>
            </div>
            <div class="widget-field">
                <label for="subject">Subject</label>
                <input class="widget-input" name="subject" type="text" placeholder="subject">
                <div class="widget-error" id="error-subject"></div>
            </div>
            <div class="widget-field">
                <label for="text">Text</label>
                <input class="widget-input" name="text" type="text" placeholder="text">
                <div class="widget-error" id="error-text"></div>
            </div>
            <div class="widget-field">
                <label for="files">Attachment</label>
                <input class="widget-input-file" type="file" name="files[]" multiple>
            </div>
            <button class="widget-button" type="submit">Send</button>
        </form>
        <div id="message" class="message"></div>
    </div>
</body>
<script>
    document.getElementById("widget-form").addEventListener("submit", async function (e) {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);

        document.querySelectorAll(".widget-error").forEach(el=> el.textContent = "");
        const message = document.getElementById("message");
        try {
            const response = await fetch("{{route('tickets.store')}}", {
                method: "POST",
                body: data,
                headers: {
                    Accept: "application/json",
                },
            });
            const json = await response.json();
            if (!response.ok) {
                if(json.errors) {
                    for(const [field, errors] of Object.entries(json.errors)) {
                        const errorDiv = document.getElementById(`error-${field}`);
                        if(errorDiv) {
                            errorDiv.textContent = errors.join(", ");
                            errorDiv.style.color = "red";
                        }
                    }
                } else {
                    message.textContent = json.message || "Server error";
                    message.style.color = "red";
                }

                return;
            }

            message.textContent = "Success";
            message.style.color = "green";
            form.reset();
        } catch (error) {
            message.textContent = "Error network";
        }
    });

</script>
</html>
