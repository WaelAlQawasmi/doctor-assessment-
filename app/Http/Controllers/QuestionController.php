<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all questions with their associated users
        $questions = Question::with('user')->get();

        return response()->json([
            'status' => true,
            'questions' => $questions,
        ], 200);
    }

    /**
     * Store a newly created question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'question' => 'required|string',
            'answer' => 'string',
        ]);

        // Create a new question
        $question = new Question();
        $question->question = $request->input('question');
        $question->answer = $request->input('answer');
        $question->user_id = Auth::id();
        $question->save();

        return response()->json([
            'status' => true,
            'message' => 'Question created successfully',
            'question' => [
                'id' => $question->id,
                'question' => $question->question,
                'answer' => $question->answer,
                'user_id' => $question->user_id,
                'created_at' => $question->created_at,
                'updated_at' => $question->updated_at,
            ],
        ], 201);
    }


    /**
     * Display the specified question.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Fetch the question with its associated user
        $question = Question::with('user')->find($id);

        if (!$question) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'question' => $question,
        ], 200);
    }

    public function showAll()
    {
        // Fetch all questions with their associated users
        $questions = Question::with('user')->get();

        if ($questions->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No questions found',
            ], 404);
        }

        // Transform the questions data to include answer, time, and created by
        $formattedQuestions = $questions->map(function ($question) {
            return [
                'id' => $question->id,
                'question' => $question->question,
                'answer' => $question->answer,
                'user_id' => $question->user_id,
                'created_by' => $question->user->name,
                'created_at' => $question->created_at,
                'updated_at' => $question->updated_at,
            ];
        });

        return response()->json([
            'status' => true,
            'questions' => $formattedQuestions,
        ], 200);
    }


    /**
     * Update the specified question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'question' => 'required|string',
    //     ]);

    //     // Fetch the question
    //     $question = Question::find($id);

    //     if (!$question) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Question not found',
    //         ], 404);
    //     }

    //     // Update the question
    //     $question->question = $request->input('question');
    //     $question->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Question updated successfully',
    //         'question' => $question,
    //     ], 200);
    // }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'question' => 'required|string',
            'answer' => 'nullable|string', // Add validation for the answer
        ]);

        // Fetch the question
        $question = Question::find($id);

        if (!$question) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        }

        // Update the question and answer
        $question->question = $request->input('question');
        $question->answer = $request->input('answer');
        $question->save();

        return response()->json([
            'status' => true,
            'message' => 'Question updated successfully',
            'question' => $question,
        ], 200);
    }


    /**
     * Remove the specified question from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Fetch the question
        $question = Question::find($id);

        if (!$question) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        }

        // Delete the question
        $question->delete();

        return response()->json([
            'status' => true,
            'message' => 'Question deleted successfully',
        ], 200);
    }
}