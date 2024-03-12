<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialTransaction extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function getAttachment()
    {
        // Check if $this->file exists and has a file attribute
        if ($this->file && $this->file->file) {
            // Return the URL of the file from the storage disk
            return Storage::disk('public')->url($this->file->file);
        } else {
            // Fallback to a default image if file doesn't exist
            return "#";
        }
    }
    public function getAttachmentName()
    {
        // Check if $this->file exists and has a file attribute
        if ($this->file && $this->file->file) {
            // Return the URL of the file from the storage disk
            return $this->file->file_name;
        } else {
            // Fallback to a default image if file doesn't exist
            return "";
        }
    }

}
