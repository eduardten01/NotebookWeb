<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*@SWG\Definition(
    *  definition="Contact",
    *  @SWG\Property(
    *      property="id",
    *      type="integer"
    *  ),
    *  @SWG\Property(
    *      property="full_name",
    *      type="string"
    *  ),
    *  @SWG\Property(
    *      property="company",
    *      type="string"
    *  ),
    *     *  @SWG\Property(
    *      property="phone",
    *      type="string"
    *  ),
    *     *  @SWG\Property(
    *      property="email",
    *      type="string"
    *  ),
    *     *  @SWG\Property(
    *      property="date_birthday",
    *      type="date"
    *  ),
    *     *  @SWG\Property(
    *      property="photo",
    *      type="string"
    *  )
    * )
    */
class Contact extends Model
{
    protected $fillable=['full_name','company','phone','email','date_birthday','photo'];
    use HasFactory;
}
