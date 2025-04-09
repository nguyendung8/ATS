<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client as GuzzleClient;

class OpenAiController extends Controller
{

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $file = $request->file('file');
        $path = $file->store('uploads', 'public');

        $analysisResult = self::sendToOpenAI($file);

        return response()->json([
            'message' => 'File uploaded and analyzed successfully',
            'file_name' => $file->getClientOriginalName(),
            'file_path' => Storage::url($path),
            'analysis_result' => $analysisResult,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    /**
     * Gửi nội dung văn bản đến OpenAI API để phân tích.
     */
    static function sendToOpenAI($text)
    {
        $apiKey = env('OPENAI_API_KEY');
        $client = new GuzzleClient();

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an AI that extracts structured data from text.'],
                    ['role' => 'user', 'content' => self::getPrompt($text)]
                ],
                'temperature' => 0.2
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        $generatedText = $data['choices'][0]['message']['content'] ?? null;

        return json_decode(self::cleanJson($generatedText), true);
    }

    static function getPrompt($file)
    {
        return "Extract structured information from the following text and return a well-formatted JSON object:
        
        TEXT: 
        ``` 
        " . base64_encode(file_get_contents($file->getRealPath())) ."
        ```
        
        JSON Format:
        ```json
        {
            \"personal_info\": {
                \"full_name\": \"\",
                \"gender\": \"\",
                \"phone_number\": \"\",
                \"email\": \"\",
                \"address\": \"\"
            },
            \"work_experience\": [],
            \"education\": [],
            \"skills\": [],
            \"volunteer_experience\": [],
            \"career_objective\": \"\"
        }
        ```

        Ensure all fields are extracted correctly. If a field is missing, use \"Unknown\" or an empty array where applicable.";
    }

    static function cleanJson($text)
    {
        $text = preg_replace('/^```json\s*/', '', $text);
        $text = preg_replace('/\s*```$/', '', $text);
        return trim($text);
    }
}
