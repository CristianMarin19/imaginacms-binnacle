<?php

namespace Modules\Ibinnacle\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ibinnacle\Entities\Binnacle;
use Modules\Ibinnacle\Http\Requests\CreateBinnacleRequest;
use Modules\Ibinnacle\Http\Requests\UpdateBinnacleRequest;
use Modules\Ibinnacle\Repositories\BinnacleRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class BinnacleController extends AdminBaseController
{
  /**
   * @var BinnacleRepository
   */
  private $binnacle;

  public function __construct(BinnacleRepository $binnacle)
  {
    parent::__construct();

    $this->binnacle = $binnacle;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    //$binnacles = $this->binnacle->all();

    return view('ibinnacle::admin.binnacles.index', compact(''));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('ibinnacle::admin.binnacles.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  CreateBinnacleRequest $request
   * @return Response
   */
  public function store(CreateBinnacleRequest $request)
  {
    $this->binnacle->create($request->all());

    return redirect()->route('admin.ibinnacle.binnacle.index')
      ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ibinnacle::binnacles.title.binnacles')]));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  Binnacle $binnacle
   * @return Response
   */
  public function edit(Binnacle $binnacle)
  {
    return view('ibinnacle::admin.binnacles.edit', compact('binnacle'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  Binnacle $binnacle
   * @param  UpdateBinnacleRequest $request
   * @return Response
   */
  public function update(Binnacle $binnacle, UpdateBinnacleRequest $request)
  {
    $this->binnacle->update($binnacle, $request->all());

    return redirect()->route('admin.ibinnacle.binnacle.index')
      ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ibinnacle::binnacles.title.binnacles')]));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Binnacle $binnacle
   * @return Response
   */
  public function destroy(Binnacle $binnacle)
  {
    $this->binnacle->destroy($binnacle);

    return redirect()->route('admin.ibinnacle.binnacle.index')
      ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ibinnacle::binnacles.title.binnacles')]));
  }
}
