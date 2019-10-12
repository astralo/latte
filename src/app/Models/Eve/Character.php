<?php declare(strict_types=1);

namespace App\Models\Eve;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'eve_characters';

    protected $guarded = [];
}
