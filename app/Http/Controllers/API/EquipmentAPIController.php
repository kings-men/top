<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEquipmentAPIRequest;
use App\Http\Requests\API\UpdateEquipmentAPIRequest;
use App\Models\Equipment;
use App\Models\Company;
use App\Repositories\EquipmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;
use DB;
use Auth;

/**
 * Class EquipmentController
 * @package App\Http\Controllers\API
 */

class EquipmentAPIController extends AppBaseController
{
    /** @var  EquipmentRepository */
    private $equipmentRepository;

    public function __construct(EquipmentRepository $equipmentRepo)
    {
        $this->equipmentRepository = $equipmentRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/equipment",
     *      summary="Get a listing of the Equipment.",
     *      tags={"Equipment"},
     *      description="Get all Equipment",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/definitions/Equipment")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        // $equipment = $this->equipmentRepository->with('frequency')->with('file')->get();
        $query = Equipment::query()->latest()->with('frequency')->with('file');

        if ($topic = $request->query('make')) {
            $query->where('make', $topic);
        }
        if ($topic = $request->query('uuid')) {
            $query->where('uuid', $topic);
        }
        if ($topic = $request->query('name')) {
            $query->where('name', $topic);
        }
        if ($topic = $request->query('category_id')) {
            $query->where('category_id', $topic);
        }

        return common_response( 'Equipment retrieved successfully', True, 200, $query->get() );
    }

    /**
     * @param CreateEquipmentAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/equipment",
     *      summary="Store a newly created Equipment in storage",
     *      tags={"Equipment"},
     *      description="Store Equipment",
     *      @OA\Parameter(
     *          name="body",
     *          in="path",
     *          description="Equipment that should be stored",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/definitions/Equipment"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEquipmentAPIRequest $request)
    {

        $response = [];

            $company_id = Company::where('user_id',Auth::user()->id)->first('id');
            $input = $request->all();
            $input['uuid']    =   Str::orderedUuid();
            $input['company_id'] = $company_id->id;
            $equipment = $this->equipmentRepository->create($input);

            // return $this->sendResponse($equipment->toArray(), 'Equipment saved successfully');
            $response       = $equipment->toArray();
            $message        = __('messages.equipment_saved');
            $status_code    = 200;
            $status         = True;

        return common_response( $message, $status, $status_code, $response );
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/equipment/{id}",
     *      summary="Display the specified Equipment",
     *      tags={"Equipment"},
     *      description="Get Equipment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Equipment",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/definitions/Equipment"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Equipment $equipment */
        // $equipment = $this->equipmentRepository->find($id);
        $equipment = Equipment::where('uuid',$id)->first();

        if (empty($equipment)) {
            return $this->sendError('Equipment not found');
        }

        return $this->sendResponse($equipment->toArray(), 'Equipment retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateEquipmentAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/equipment/{id}",
     *      summary="Update the specified Equipment in storage",
     *      tags={"Equipment"},
     *      description="Update Equipment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Equipment",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Parameter(
     *          name="body",
     *          in="path",
     *          description="Equipment that should be updated",
     *          required=false,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/definitions/Equipment"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEquipmentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Equipment $equipment */
        $equipment = $this->equipmentRepository->find($id);

        if (empty($equipment)) {
            return $this->sendError('Equipment not found');
        }

        $equipment = $this->equipmentRepository->update($input, $id);

        return $this->sendResponse($equipment->toArray(), 'Equipment updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/equipment/{id}",
     *      summary="Remove the specified Equipment from storage",
     *      tags={"Equipment"},
     *      description="Delete Equipment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Equipment",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Equipment $equipment */
        $equipment = $this->equipmentRepository->find($id);

        if (empty($equipment)) {
            return $this->sendError('Equipment not found');
        }

        $equipment->delete();

        return $this->sendSuccess('Equipment deleted successfully');
    }
}
