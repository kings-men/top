<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFeatureAPIRequest;
use App\Http\Requests\API\UpdateFeatureAPIRequest;
use App\Models\Feature;
use App\Repositories\FeatureRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FeatureController
 * @package App\Http\Controllers\API
 */

class FeatureAPIController extends AppBaseController
{
    /** @var  FeatureRepository */
    private $featureRepository;

    public function __construct(FeatureRepository $featureRepo)
    {
        $this->featureRepository = $featureRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/features",
     *      summary="Get a listing of the Features.",
     *      tags={"Feature"},
     *      description="Get all Features",
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
     *                  @OA\Items(ref="#/definitions/Feature")
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
        $features = $this->featureRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($features->toArray(), 'Features retrieved successfully');
    }

    /**
     * @param CreateFeatureAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/features",
     *      summary="Store a newly created Feature in storage",
     *      tags={"Feature"},
     *      description="Store Feature",
     *      @OA\Parameter(
     *          name="body",
     *          in="path",
     *          description="Feature that should be stored",
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
     *                  ref="#/definitions/Feature"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateFeatureAPIRequest $request)
    {
        $input = $request->all();

        $feature = $this->featureRepository->create($input);

        return $this->sendResponse($feature->toArray(), 'Feature saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/features/{id}",
     *      summary="Display the specified Feature",
     *      tags={"Feature"},
     *      description="Get Feature",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Feature",
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
     *                  ref="#/definitions/Feature"
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
        /** @var Feature $feature */
        $feature = $this->featureRepository->find($id);

        if (empty($feature)) {
            return $this->sendError('Feature not found');
        }

        return $this->sendResponse($feature->toArray(), 'Feature retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateFeatureAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/features/{id}",
     *      summary="Update the specified Feature in storage",
     *      tags={"Feature"},
     *      description="Update Feature",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Feature",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Parameter(
     *          name="body",
     *          in="path",
     *          description="Feature that should be updated",
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
     *                  ref="#/definitions/Feature"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateFeatureAPIRequest $request)
    {
        $input = $request->all();

        /** @var Feature $feature */
        $feature = $this->featureRepository->find($id);

        if (empty($feature)) {
            return $this->sendError('Feature not found');
        }

        $feature = $this->featureRepository->update($input, $id);

        return $this->sendResponse($feature->toArray(), 'Feature updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/features/{id}",
     *      summary="Remove the specified Feature from storage",
     *      tags={"Feature"},
     *      description="Delete Feature",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Feature",
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
        /** @var Feature $feature */
        $feature = $this->featureRepository->find($id);

        if (empty($feature)) {
            return $this->sendError('Feature not found');
        }

        $feature->delete();

        return $this->sendSuccess('Feature deleted successfully');
    }
}
