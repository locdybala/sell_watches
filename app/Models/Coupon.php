<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'tbl_coupon';
    protected $primaryKey = 'coupon_id';
}
