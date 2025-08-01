<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Article;

return new class extends Migration
{
    public function up()
    {
        // First, copy any data from image_path to image column
        DB::table('articles')
            ->whereNotNull('image_path')
            ->whereNull('image')
            ->update(['image' => DB::raw('image_path')]);

        // Now let's try to match the existing articles with the images in public/images
        // Based on your file listing, let's assign images to articles
        $imageAssignments = [
            1 => 'images/tomatoes.png',        
            2 => 'images/planting.png',         
            3 => 'images/storage.png',        
            
        ];

        // Apply the image assignments
        foreach ($imageAssignments as $articleId => $imagePath) {
            Article::where('id', $articleId)
                  ->whereNull('image')
                  ->update(['image' => $imagePath]);
        }

        // Finally, drop the image_path column as it's no longer needed
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }

    public function down()
    {
        // Add back the image_path column
        Schema::table('articles', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('excerpt');
        });

        // Copy data back from image to image_path
        DB::table('articles')
            ->whereNotNull('image')
            ->update(['image_path' => DB::raw('image')]);
    }
};