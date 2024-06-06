<?php

namespace MMX\Users\Models\Commerce;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MMX\Database\Models\Casts\Serialize;
use MMX\Database\Models\Casts\Timestamp;
use MMX\Database\Models\User;

/**
 * @property int $id
 * @property string $class_key
 * @property array $properties
 * @property int $user
 * @property string $type
 * @property string $last_used
 * @property string $fullname
 * @property string $firstname
 * @property string $lastname
 * @property string $company
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property string $zip
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $phone
 * @property string $mobile
 * @property string $email
 * @property string $notes
 *
 * @property-read User $User
 */
class Address extends Model
{
    public $timestamps = false;
    protected $table = 'commerce_address';
    protected $guarded = ['id'];
    protected $casts = [
        'properties' => Serialize::class,
        'last_used' => Timestamp::class,
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }
}