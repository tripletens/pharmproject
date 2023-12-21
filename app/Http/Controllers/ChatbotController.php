<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{

    public function index(){
        return view('chatbot');
    }
    // get Bot response

    public function getBotResponse(Request $request)
    {
        try {
            $userInput = $request->input('chat_input');
            $userName = Auth::user()->name;
    
            // Make a request to the OpenAI API
            $response = Http::post('https://api.openai.com/v1/chat/completions', [
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $userInput],
                ],
                'model' => env('AI_MODEL'),
                'temperature' => 0.7
            ])->header('Authorization', 'Bearer ' . env('OPENAI_API_KEY'));
    
            // Check for HTTP errors
            // $response->throw();
    
            // Extract and return the generated response
            $botResponse = $response;
            
            // ->json()['choices'][0]['message']['content'];
    
            return response()->json(['bot_response' => $botResponse]);
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
