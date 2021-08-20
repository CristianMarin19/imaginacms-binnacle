<?php

namespace Modules\Ibinnacle\Repositories\Eloquent;

use Modules\Ibinnacle\Repositories\BinnacleRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentBinnacleRepository extends EloquentBaseRepository implements BinnacleRepository
{
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    }

    // FILTERS
    if (isset($params->filter)) {
      $filter = $params->filter;

      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where(function ($query) use ($filter) {
          $query->whereHas('translations', function ($query) use ($filter) {
            $query->where('locale', $filter->locale)
              ->where('title', 'like', '%' . $filter->search . '%');
          })->orWhere('ibinnacle__binnacles.id', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
      }

      //add filter by ids
      if (isset($filter->ids)) {
        is_array($filter->ids) ? true : $filter->ids = [$filter->ids];
        $query->whereIn('ibinnacle__binnacles.id', $filter->ids);
      }

      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }

      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy("ibinnacle__binnacles." . $orderByField, $orderWay);//Add order to query
      }
      //Filter by Created By ID
      if (isset($filter->createdbyId)) {
        if ($filter->createdbyId == 0) {
          $query->whereNull("created_by_id");
        } else {
          $query->where("created_by_id", $filter->createdbyId);
        }
      }

      //filter by binnacleId
      if(isset($filter->binnacleId)){
        $query->where("binnacle_id",$filter->binnacleId);
      }

      //filter by Binnacle Type
      if(isset($filter->binnacleType)){
        $query->where("binnacle_type",$filter->binnacleType);
      }
    }

    /*== REQUEST ==*/
    //dd($query->toSql());
    if (isset($params->onlyQuery) && $params->onlyQuery) {
      return $query;
    } else
      if (isset($params->page) && $params->page) {
        return $query->paginate($params->take);
      } else {
        $params->take ? $query->take($params->take) : false;//Take
        return $query->get();
      }
  }

  public function getItem($criteria, $params = false)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with([]);
    }
    
    /*== FIELDS ==*/
    if (isset($params->fields) && is_array($params->fields) && count($params->fields))
      $query->select($params->fields);


    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      //Filter by specific field
      if (isset($filter->field))
        $field = $filter->field;

      // find translatable attributes
      $translatedAttributes = $this->model->translatedAttributes;

      // filter by translatable attributes
      if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
        $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
          $query->where('locale', $filter->locale)
            ->where($field, $criteria);
        });
      else {
        // find by specific attribute or by id
        $query->where($field ?? 'id', $criteria);
      }

      //Filter by Created By ID
      if (isset($filter->createdbyId)) {
        if ($filter->createdbyId == 0) {
          $query->whereNull("created_by_id");
        } else {
          $query->where("created_by_id", $filter->createdbyId);
        }
      }

      //filter by Binnacle Id
      if(isset($filter->binnacleId)){
        $query->where("binnacle_id",$filter->binnacleId);
      }

      //filter by Binnacle Type
      if(isset($filter->binnacleType)){
        $query->where("binnacle_type",$filter->binnacleType);
      }

    }

    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {

    } else {


    }

    /*== REQUEST ==*/
    return $query->first();
  }

  /**
   * Find a resource by the given slug
   *
   * @param string $slug
   * @return object
   */

  public function create($data)
  {

    $binnacle = $this->model->create($data);

    //Event to ADD media
    return $binnacle;
  }

  public function updateBy($criteria, $data, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      //Update by field
      if (isset($filter->field))
        $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();

    return $model ? $model->update((array)$data) : false;
  }

  public function deleteBy($criteria, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      if (isset($filter->field))//Where field
        $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    $model ? $model->delete() : false;
  }
}