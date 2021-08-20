<?php
namespace Modules\Ibinnacle\Http\Controllers\Api;

// Requests & Response
use Modules\Ibinnacle\Http\Requests\BinnacleRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ibinnacle\Http\Requests\CreateBinnacleRequest;
use Modules\Ibinnacle\Http\Requests\UpdateBinnacleRequest;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Ibinnacle\Transformers\BinnacleTransformer;

// Entities
use Modules\Ibinnacle\Entities\Binnacle;

// Repositories
use Modules\Ibinnacle\Repositories\BinnacleRepository;

class BinnacleApiController extends BaseApiController
{
  private $binnacle;

  public function __construct(BinnacleRepository $binnacle)
  {
    $this->binnacle = $binnacle;
  }

  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function index(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $binnacles = $this->binnacle->getItemsBy($params);

      //Response
      $response = ["data" => BinnacleTransformer::collection($binnacles)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($binnacles)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $binnacle = $this->binnacle->getItem($criteria, $params);

      //Break if no found item
      if (!$binnacle) throw new \Exception('Item not found', 404);

      //Response
      $response = ["data" => new BinnacleTransformer($binnacle)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($binnacle)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * CREATE A ITEM
   *
   * @param Request $request
   * @return mixed
   */
  public function create(Request $request)
  {
    \DB::beginTransaction();
    try {
      $data = $request->input('attributes') ?? [];//Get data
      //Validate Request

      $this->validateRequestApi(new CreateBinnacleRequest($data));

      //Create item
      $binnacle = $this->binnacle->create($data);

      //Response
      $response = ["data" => new BinnacleTransformer($binnacle)];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @return Response
   */
  public function update($criteria, Request $request)
  {


    \DB::beginTransaction();
    try {
      $params = $this->getParamsRequest($request);
      $data = $request->input('attributes');

      //Validate Request
      $this->validateRequestApi(new UpdateBinnacleRequest($data));

      //Update data
      $category = $this->binnacle->updateBy($criteria, $data,$params);

      //Response
      $response = ['data' => 'Item Updated'];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    return response()->json($response, $status ?? 200);
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function delete($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);

      //Delete data
      $this->binnacle->deleteBy($criteria, $params);

      //Response
      $response = ['data' => ''];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    return response()->json($response, $status ?? 200);
  }
}

