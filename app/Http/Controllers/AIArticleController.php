<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Exception;

class AIArticleController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('ai-articles.create', compact('categories'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'tone' => 'required|string|in:professional,casual,academic,creative,informative',
            'length' => 'required|string|in:short,medium,long',
            'category_id' => 'nullable|exists:categories,id',
            'instructions' => 'nullable|string|max:500'
        ]);

        try {
            $topic = $request->topic;
            $tone = $request->tone;
            $length = $request->length;
            $instructions = $request->instructions ?? '';

            $wordCounts = [
                'short' => '300-500',
                'medium' => '500-800', 
                'long' => '800-1200'
            ];

            $prompt = $this->buildPrompt($topic, $tone, $wordCounts[$length], $instructions);
            $generatedContent = $this->callGeminiAPI($prompt);
            $parsedContent = $this->parseGeneratedContent($generatedContent);

            return response()->json([
                'success' => true,
                'title' => $parsedContent['title'],
                'excerpt' => $parsedContent['excerpt'],
                'content' => $parsedContent['content'],
                'category_id' => $request->category_id
            ]);

        } catch (Exception $e) {
            \Log::error('AI Generation Error: ' . $e->getMessage());
            \Log::error('AI Generation Stack Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate article: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateStandalone(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'tone' => 'required|in:professional,casual,informative,engaging',
            'length' => 'required|in:short,medium,long',
        ]);

        try {
            $wordCount = match($request->length) {
                'short' => '300-500 words',
                'medium' => '500-800 words',
                'long' => '800-1200 words',
            };

            $prompt = $this->createPrompt($request->topic, $request->tone, $wordCount);
            $generatedContent = $this->callGeminiAPI($prompt);

            $lines = explode("\n", $generatedContent);
            $title = trim($lines[0], "# \t\n\r\0\x0B");
            $body = trim(substr($generatedContent, strlen($lines[0])));

            $excerpt = Str::limit(strip_tags($body), 150);
            $category = Category::find($request->category_id);

            return view('ai-articles.preview', compact(
                'title', 
                'body', 
                'excerpt', 
                'category',
                'request'
            ));

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to generate article: ' . $e->getMessage()]);
        }
    }

    public function save(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'category_id' => $request->category_id,
            'is_published' => false,
            'published_at' => null,
        ]);

        return redirect()->route('articles.edit', $article)
            ->with('success', 'AI-generated article saved as draft! You can now edit and publish it.');
    }

    public function testAPI()
    {
        try {
            $apiKey = env('GEMINI_API_KEY');
            
            if (!$apiKey) {
                return response()->json(['error' => 'Gemini API key not found in environment']);
            }
            
            $data = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => 'Say "Hello, Gemini API is working!"'
                            ]
                        ]
                    ]
                ]
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=' . $apiKey);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return response()->json([
                'api_key_length' => strlen($apiKey),
                'http_code' => $httpCode,
                'response' => json_decode($response, true)
            ]);
            
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    private function callGeminiAPI($prompt)
    {
        
        $apiKey = env('GEMINI_API_KEY');
        
        if (!$apiKey) {
            throw new \Exception('Gemini API key not configured');
        }
        
        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=' . $apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            \Log::error('Gemini API Error - HTTP Code: ' . $httpCode);
            \Log::error('Gemini API Response: ' . $response);
            throw new Exception('Gemini API request failed with status: ' . $httpCode . '. Response: ' . $response);
        }

        $responseData = json_decode($response, true);
        
        if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            throw new Exception('Invalid response from Gemini API');
        }

        return $responseData['candidates'][0]['content']['parts'][0]['text'];
    }

    private function buildPrompt($topic, $tone, $wordCount, $instructions = '')
    {
        $toneDescriptions = [
            'professional' => 'professional, authoritative, and business-oriented',
            'casual' => 'casual, friendly, and conversational',
            'academic' => 'academic, research-based, and scholarly',
            'creative' => 'creative, engaging, and imaginative',
            'informative' => 'informative, educational, and clear'
        ];

        $toneDescription = $toneDescriptions[$tone] ?? 'professional';

        $prompt = "Write a comprehensive blog article about: {$topic}\n\n";
        $prompt .= "Requirements:\n";
        $prompt .= "- Word count: {$wordCount} words\n";
        $prompt .= "- Tone: {$toneDescription}\n";
        $prompt .= "- Format: Include a compelling title, brief excerpt (2-3 sentences), and well-structured main content\n";
        $prompt .= "- Structure: Use proper headings, paragraphs, and make it engaging for readers\n";
        
        if ($instructions) {
            $prompt .= "- Additional instructions: {$instructions}\n";
        }
        
        $prompt .= "\nPlease format the response as follows:\n";
        $prompt .= "TITLE: [Article Title]\n";
        $prompt .= "EXCERPT: [Brief excerpt/summary]\n";
        $prompt .= "CONTENT: [Full article content]\n\n";
        
        return $prompt;
    }

    private function createPrompt($topic, $tone, $wordCount)
    {
        return "Write a {$tone} blog article about '{$topic}' in {$wordCount}. 

Structure the article with:
1. An engaging title
2. A compelling introduction
3. Well-organized main content with subheadings
4. Practical tips or actionable advice
5. A strong conclusion

Focus on providing value to readers interested in gardening, agriculture, or farming. Make it informative and engaging. Use markdown formatting for headings and emphasis.

Topic: {$topic}";
    }

    private function parseGeneratedContent($content)
    {
        $title = '';
        $excerpt = '';
        $mainContent = '';

        if (preg_match('/TITLE:\s*(.*?)(?=\n|EXCERPT:|$)/s', $content, $titleMatch)) {
            $title = trim($titleMatch[1]);
        }

        if (preg_match('/EXCERPT:\s*(.*?)(?=\n\n|CONTENT:|$)/s', $content, $excerptMatch)) {
            $excerpt = trim($excerptMatch[1]);
        }

        if (preg_match('/CONTENT:\s*(.*?)$/s', $content, $contentMatch)) {
            $mainContent = trim($contentMatch[1]);
        }

        if (empty($title) && empty($excerpt) && empty($mainContent)) {
            $lines = explode("\n", trim($content));
            $title = $lines[0] ?? 'Generated Article';
            $excerpt = isset($lines[1]) ? $lines[1] : 'AI-generated article content';
            $mainContent = implode("\n", array_slice($lines, 2));
        }

        if (empty($title)) {
            $title = 'AI Generated Article - ' . date('Y-m-d H:i:s');
        }

        if (empty($excerpt)) {
            $excerpt = substr(strip_tags($mainContent), 0, 150) . '...';
        }

        $mainContent = $this->cleanContent($mainContent);

        return [
            'title' => $title,
            'excerpt' => $excerpt,
            'content' => $mainContent
        ];
    }

    private function cleanContent($content)
    {
        $content = preg_replace('/^(TITLE|EXCERPT|CONTENT):\s*/m', '', $content);
        $content = preg_replace('/\n{3,}/', "\n\n", $content);
        $content = trim($content);
        
        return $content;
    }
}