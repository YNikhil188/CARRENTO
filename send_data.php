<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX Example</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <form id="dataForm">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required>
        <label for="content">Content</label>
        <input type="text" id="content" name="content" placeholder="Enter content" required>
        <button type="submit">Submit</button>
    </form>

    <div id="output">
        <h3>Response:</h3>
        <p><strong>Name:</strong> <span id="outputName"></span></p>
        <p><strong>Content:</strong> <span id="outputContent"></span></p>
    </div>

    <script>
        $(document).ready(function () {
            $("#dataForm").on("submit", function (event) {
                event.preventDefault(); // Prevent the default form submission

                const formData = {
                    name: $("#name").val(),
                    content: $("#content").val()
                };

                // AJAX request to send the data
                $.ajax({
                    url: "send_to_python.php", // PHP file to handle the request
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    success: function (response) {
                        // Update the output section with the response
                        $("#outputName").text(response.reply || "N/A");
                        $("#outputContent").text(response.Username || "N/A");
                    },
                    error: function (xhr, status, error) {
                        console.error("Error:", error);
                        alert("An error occurred. Please try again.");
                    }
                });
            });
        });
    </script>
</body>
</html>
