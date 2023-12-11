
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Page</title>
    <!-- Include necessary CSS files -->
    <!-- Bootstrap CSS -->
    <link href="path/to/bootstrap.min.css" rel="stylesheet">
    <!-- Your custom CSS if needed -->

    <!-- Include necessary JS files -->
    <!-- Bootstrap JS Bundle (Bootstrap and Popper.js) -->
    <script src="path/to/bootstrap.bundle.min.js"></script>
    <!-- Your custom scripts if needed -->
</head>
<style>
   /* Centering the modal */
   body, html {
            height: 100%;
            overflow: hidden; /* Prevent scrolling */
        
        }

        body {
           
            background-image: url('css/images/index.jpg');
            background-size: cover;


        
        }

        .modal-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        /* Custom styling for the modal */
        .modal-content {
            border: none;
            box-shadow: 10px 10px 20px rgba(0, 0.1, 0.1, 0.2);
            background-color: #f5f8fc; /* Light blue shade */
            border-radius: 10px;
            height: 500px;
            width: 600px;
        }
        .modal-header {
            background-color: #3498db; /* Blue header */
            color: #fff;
            border-radius: 10px 10px 0 0;
        }
        .modal-header h2 {
            margin: 0;
            padding: 15px;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-footer {
            border-radius: 0 0 10px 10px;
            padding: 15px;
            text-align: right;
        }


    .custom-textarea {
        width: 92%;
        height: 300px;
        padding: 20px;
        border: 3px solid #787777;
        border-radius: 5px;
        resize: vertical;
        background-color: #d6e6f8; /* Change this color to your desired background color */
        }

    .submit_button{
        background-color:#30defc ;
        border: 1px solid black;
        border-radius: 8px;
        font-size: 20px;
        margin-top: 15px;
        margin-left: 390px;
        transition: transform 0.3s, background-color 0.3s; /* Transition effect for shadow and background */

        font-family:Georgia, 'Times New Roman', Times, serif;
    }

     #feedbackButton:active {
    transform: scale(0.95); /* Scale down when button is pressed */
}
</style>

<body>

<div class="modal-container">
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="feedbackModalLabel">Feedback Form</h2>
                </div>
                <div class="modal-body">
                    <form id="feedbackForm" method="POST" action="{{ route('feedback.store') }}">
                        @csrf 
                        <div class="form-group">
                            <div class="p-3">
                                <textarea id="feedback" name="feedback_text" rows="5" cols="40" maxlength="500" class="form-control custom-textarea" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" id="submitFeedback" class="submit_button">Submit Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="path/to/bootstrap.bundle.min.js"></script>
<!-- Your custom scripts if needed -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const submitButton = document.getElementById('submitFeedback');

        submitButton.addEventListener('click', function() {
            const feedbackText = document.getElementById('feedback').value;

            // Send AJAX request to save the feedback
            fetch('{{ route("feedback.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    feedback_text: feedbackText
                })
            })
            .then(response => {
                if (response.ok) {
                    // Display success message
                    alert('Feedback submitted successfully!');
                    // Redirect to the welcome dashboard
                    window.location.href = '{{ route("welcome") }}';
                } else {
                    throw new Error('Failed to submit feedback');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle error if needed
            });
        });
    });
</script>

</body>
</html>