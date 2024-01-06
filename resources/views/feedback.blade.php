
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Page</title>
  
    <link href="path/to/bootstrap.min.css" rel="stylesheet">

    <script src="path/to/bootstrap.bundle.min.js"></script>
</head>
<style>
   body, html {
            height: 100%;
            overflow: hidden; 
        
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
        .modal-content {
            border: none;
            box-shadow: 10px 10px 20px rgba(0, 0.1, 0.1, 0.2);
            background-color: #f5f8fc; 
            border-radius: 10px;
            height: 500px;
            width: 600px;
        }
        .modal-header {
            background-color: #3498db; 
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
        background-color: #d6e6f8; 
        }

    .submit_button{
        background-color:#30defc ;
        border: 1px solid black;
        border-radius: 8px;
        font-size: 20px;
        margin-top: 15px;
        margin-left: 390px;
        transition: transform 0.3s, background-color 0.3s; 

        font-family:Georgia, 'Times New Roman', Times, serif;
    }

     #feedbackButton:active {
    transform: scale(0.95); 
}

.modal-header {
    position: relative;
}

.close {
    position: absolute;
    top: 0;
    right: 0;
}

.close-circle {
    border-radius: 50%; 
    width: 30px; 
    height: 30px;
    margin:10px;
}

.close-circle {
    border-radius: 50%; 
    width: 30px; 
    height: 30px; 
    padding: 0;
    font-size: 24px; 
}

.close-circle span:hover {
    color: red; 
    cursor: pointer; 
}


</style>

<body>

<div class="modal-container">
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
    <h2 class="modal-title">Feedback Form</h2>
    <button type="button" class="close close-circle" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const submitButton = document.getElementById('submitFeedback');

        submitButton.addEventListener('click', function() {
            const feedbackText = document.getElementById('feedback').value;

            if (feedbackText.trim() === '') {
                alert('Please provide feedback before submitting.');
                return; 
            }

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
                    alert('Feedback submitted successfully!');
                    window.location.href = '{{ route("welcome") }}';
                } else {
                    throw new Error('Failed to submit feedback');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        const closeButton = document.querySelector('.modal-header .close');
        closeButton.addEventListener('click', function() {
            window.location.href = '{{ route("welcome") }}';
        });
    });
</script>

</body>
</html>