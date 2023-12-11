<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback; 

class FeedbackController extends Controller
{
    public function showFeedbackForm()
    {
        return view('feedback'); // This assumes 'feedback.blade.php' is located in the 'views' directory.
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'feedback_text' => 'required|max:500'
        ]);

        // Store the validated feedback in the database
        $feedback = Feedback::create([
            'feedback_text' => $validatedData['feedback_text']
        ]);

        // Check if feedback was saved successfully
        if ($feedback) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 500);
        }
    }
}
