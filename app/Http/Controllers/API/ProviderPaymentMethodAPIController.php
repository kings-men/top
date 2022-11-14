<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProviderPaymentMethodAPIRequest;
use App\Http\Requests\API\UpdateProviderPaymentMethodAPIRequest;
use App\Models\ProviderPaymentMethod;
use App\Repositories\ProviderPaymentMethodRepository;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Provider;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProviderPaymentMethodController
 * @package App\Http\Controllers\API
 */

class ProviderPaymentMethodAPIController extends AppBaseController
{
    /** @var  ProviderPaymentMethodRepository */
    private $providerPaymentMethodRepository;

    public function __construct(ProviderPaymentMethodRepository $providerPaymentMethodRepo)
    {
        $this->providerPaymentMethodRepository = $providerPaymentMethodRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/providerPaymentMethods",
     *      summary="Get a listing of the ProviderPaymentMethods.",
     *      tags={"ProviderPaymentMethod"},
     *      description="Get all ProviderPaymentMethods",
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
     *                  @OA\Items(ref="#/definitions/ProviderPaymentMethod")
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
        $providerPaymentMethods = $this->providerPaymentMethodRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($providerPaymentMethods->toArray(), 'Provider Payment Methods retrieved successfully');
    }

    /**
     * @param CreateProviderPaymentMethodAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/providerPaymentMethods",
     *      summary="Store a newly created ProviderPaymentMethod in storage",
     *      tags={"ProviderPaymentMethod"},
     *      description="Store ProviderPaymentMethod",
     *      @OA\Parameter(
     *          name="body",
     *          in="path",
     *          description="ProviderPaymentMethod that should be stored",
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
     *                  ref="#/definitions/ProviderPaymentMethod"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProviderPaymentMethodAPIRequest $request)
    {
        $input = $request->all();
        $rpovider = Provider::where('user_id',\Auth::user()->id)->first('id');
        $input['provider_id'] = $rpovider->id;
        $input['uuid'] = Str::orderedUuid();

        $providerPaymentMethod = ProviderPaymentMethod::where('provider_id',$rpovider->id)->first();

        if(empty($providerPaymentMethod)){
            $input['account_number'] = Crypt::encryptString($input['account_number']);
            $providerPaymentMethod = $this->providerPaymentMethodRepository->create($input);
        }


        return common_response( __('messages.provider_payment_method_saved_successfully'), True, 200, ['uuid'=>$providerPaymentMethod->uuid] );

    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/providerPaymentMethods/{id}",
     *      summary="Display the specified ProviderPaymentMethod",
     *      tags={"ProviderPaymentMethod"},
     *      description="Get ProviderPaymentMethod",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProviderPaymentMethod",
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
     *                  ref="#/definitions/ProviderPaymentMethod"
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
        /** @var ProviderPaymentMethod $providerPaymentMethod */
        // $providerPaymentMethod = $this->providerPaymentMethodRepository->find($id);
        $providerPaymentMethod = ProviderPaymentMethod::where('uuid',$id)->first();
        if (empty($providerPaymentMethod)) {
            return $this->sendError('Provider Payment Method not found');
        }
        $providerPaymentMethod['account_number']= Crypt::decryptString($providerPaymentMethod['account_number']);
        return common_response( __('messages.provider_payment_method_retrieved_successfully'), True, 200, $providerPaymentMethod->toArray() );
    }

    /**
     * @param int $id
     * @param UpdateProviderPaymentMethodAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/providerPaymentMethods/{id}",
     *      summary="Update the specified ProviderPaymentMethod in storage",
     *      tags={"ProviderPaymentMethod"},
     *      description="Update ProviderPaymentMethod",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProviderPaymentMethod",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Parameter(
     *          name="body",
     *          in="path",
     *          description="ProviderPaymentMethod that should be updated",
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
     *                  ref="#/definitions/ProviderPaymentMethod"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProviderPaymentMethodAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProviderPaymentMethod $providerPaymentMethod */
        $providerPaymentMethod = $this->providerPaymentMethodRepository->find($id);

        if (empty($providerPaymentMethod)) {
            return $this->sendError('Provider Payment Method not found');
        }

        $providerPaymentMethod = $this->providerPaymentMethodRepository->update($input, $id);

        return $this->sendResponse($providerPaymentMethod->toArray(), 'ProviderPaymentMethod updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/providerPaymentMethods/{id}",
     *      summary="Remove the specified ProviderPaymentMethod from storage",
     *      tags={"ProviderPaymentMethod"},
     *      description="Delete ProviderPaymentMethod",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProviderPaymentMethod",
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
        /** @var ProviderPaymentMethod $providerPaymentMethod */
        $providerPaymentMethod = $this->providerPaymentMethodRepository->find($id);

        if (empty($providerPaymentMethod)) {
            return $this->sendError('Provider Payment Method not found');
        }

        $providerPaymentMethod->delete();

        return $this->sendSuccess('Provider Payment Method deleted successfully');
    }
}
