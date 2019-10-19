<?php declare(strict_types=1);

namespace App\Models\Eve;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    protected $table = 'eve_alliances';

    protected $guarded = [];

    public $timestamps = false;
}
