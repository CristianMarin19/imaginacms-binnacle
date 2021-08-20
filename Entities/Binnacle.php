<?php

namespace Modules\Ibinnacle\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Illuminate\Support\Str;

class Binnacle extends Model
{
  use NamespacedEntity;

  protected $table = 'ibinnacle__binnacles';
  protected static $entityNamespace = 'asgardcms/ibinnacleBinnacle';

  protected $fillable = [
    'created_by_id',
    'description',
    'binnacle_id',
    'binnacle_type',
  ];
  public function getOptioqnsAttribute($value)
  {
    try {
      return json_decode(json_decode($value));
    } catch (\Exception $e) {
      return json_decode($value);
    }
  }
}