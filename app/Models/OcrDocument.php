<?php
    
namespace App\Models;
    
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
    
class OcrDocument extends Model
{
    use HasFactory;
    
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_ocr';
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ocr_documents';

    /**
     * The attributes that are mass assignable.
     * This is the fix for the MassAssignmentException.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'original_filename',
        'stored_path',
        'extracted_text',
        'word_data',
        'thumbnail_path',
    ];
}

