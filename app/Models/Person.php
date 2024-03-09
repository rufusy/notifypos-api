<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Person
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $phone_number
 * @property string $email
 * @property string $country
 * @property string $address
 * @property string $city
 * @property string|null $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $person_id
 * @method static \Database\Factories\PersonFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Person newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Person newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Person query()
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Person extends Model
{
    use HasFactory;
}
