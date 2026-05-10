<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'beggar_id',
        'phone',
        'amount',
        'tx_ref',
        'status',
        'lotto_number',
        'chapa_checkout_url',
    ];

    public function beggar()
    {
        return $this->belongsTo(Beggar::class);
    }

    public static function generateLottoNumber(): string
    {
        return 'ET-' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999);
    }
}
