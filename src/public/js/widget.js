document.getElementById("widget-form").addEventListener("submit", async function (e) {
    e.preventDefault();
    const form = e.target;
    const data = new FormData(form);
    const message = document.getElementById("message");
    try {
        const response = await fetch("{{route('tickets.store')}}", {
            method: "POST",
            body: data,
            headers: {
                Accept: "application/json",
            },
        });
        if (!response.ok) {
            const errorData = await response.json();
            message.textContent = errorData.message || "Server error";
            return;
        }
        const json = await response.json();
        message.textContent = "Success";
        message.style.color = "green";
        form.reset();
    } catch (error) {
        message.textContent = "Error network";
    }
});
