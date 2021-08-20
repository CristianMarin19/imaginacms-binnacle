<?php

namespace Modules\Ibinnacle\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;

class BinnacleTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->id,
      'description' => $this->description,
      'createdById' => (int)$this->created_by_id,
      'binnacleId' => (int)$this->binnacle_id,
      'binnacleType' => $this->binnacle_type,
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];

    $filter = json_decode($request->filter);
    
    return $data;
  }
}
