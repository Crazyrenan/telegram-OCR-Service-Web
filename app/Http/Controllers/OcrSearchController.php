<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\OcrDocument;
    use Illuminate\Http\Request;
    
    class OcrSearchController extends Controller
    {
        /**
         * API endpoint to search for documents based on a keyword.
         */
        public function searchDocumentsApi(Request $request)
        {
            $validated = $request->validate(['query' => 'required|string|max:255']);
    
            $documents = OcrDocument::where('extracted_text', 'LIKE', '%' . $validated['query'] . '%')
                ->select('id', 'original_filename', 'created_at')
                ->latest()
                ->limit(10)
                ->get();
    
            return response()->json($documents);
        }
    }
    
