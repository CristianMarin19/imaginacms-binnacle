<?php

namespace Modules\Ibinnacle\Repositories\Cache;

use Modules\Ibinnacle\Repositories\BinnacleRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheBinnacleDecorator extends BaseCacheDecorator implements BinnacleRepository
{
  public function __construct(BinnacleRepository $binnacle)
  {
    parent::__construct();
    $this->entityName = 'ibinnacle.binnacles';
    $this->repository = $binnacle;
  }
}
