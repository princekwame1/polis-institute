<?php

namespace App\Models;

use Database\Factories\EnquiryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['type', 'name', 'email', 'phone', 'organisation', 'course', 'learning_mode', 'location', 'subject', 'message', 'handled_at'])]
class Enquiry extends Model
{
    /** @use HasFactory<EnquiryFactory> */
    use HasFactory;

    public const TYPES = ['contact', 'registration', 'corporate'];

    /**
     * Readable labels for each enquiry type.
     */
    public const TYPE_LABELS = [
        'contact' => 'Contact enquiry',
        'registration' => 'Course registration',
        'corporate' => 'Corporate training',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'handled_at' => 'datetime',
        ];
    }

    public function isHandled(): bool
    {
        return $this->handled_at !== null;
    }

    public function typeLabel(): string
    {
        return self::TYPE_LABELS[$this->type] ?? ucfirst($this->type);
    }
}
