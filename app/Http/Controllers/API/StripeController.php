<?php

namespace App\Http\Controllers\API;

use Auth;
use Stripe;
use Exception;
use App\Models\Plans;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\CompanyPayment;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyPaymentsRequest;

class StripeController extends Controller
{

    public function craeteSubscription(CompanyPaymentsRequest $request){

        $responseData = [];
        try {

            $user = Auth::user();

            $planDetail = Plans::where('id',$request->plan_id)->first();

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = Stripe\Customer::create(array(

                "email" => $user->email,
                "name" => $user->display_name,
                'source' => $request->card_token
            ));

            $subscriptions = Stripe\Subscription::create([
                'customer'      => $customer->id,
                'items' => [
                    ['price' => $planDetail->plan_price_id],
                ],
            ]);

            if (($subscriptions && $subscriptions['status'] && $subscriptions['status'] == 'active') || ($request->plan == '1')){

                // Sending Mail to Restaurant and Admin
                $details = array('email'=>$user->email);
                // dispatch(new \App\Jobs\SubscriptionJob($details));

                $message            = __('messages.success');
                $responseData       = $subscriptions;
                $status_code        = 200;
                $status             = True;

            }


          } catch(\Stripe\Exception\CardException $e) {

            $status = $e->getHttpStatus();
            $status_code = $e->getError()->code;
            $message = $e->getError()->message.' Type is:' . $e->getError()->type;

          } catch (\Stripe\Exception\RateLimitException $e) {
                // Too many requests made to the API too quickly
                $status = $e->getHttpStatus();
                $status_code = $e->getError()->code;
                $message = $e->getError()->message.' Type is:' . $e->getError()->type;
          } catch (\Stripe\Exception\InvalidRequestException $e) {
                // Invalid parameters were supplied to Stripe's API
                $status = $e->getHttpStatus();
                $status_code = $e->getError()->code;
                $message = $e->getError()->message.' Type is:' . $e->getError()->type;
          } catch (\Stripe\Exception\AuthenticationException $e) {
                // Authentication with Stripe's API failed
                // (maybe you changed API keys recently)
                $status = $e->getHttpStatus();
                $status_code = $e->getError()->code;
                $message = $e->getError()->message.' Type is:' . $e->getError()->type;
          } catch (\Stripe\Exception\ApiConnectionException $e) {
                // Network communication with Stripe failed
                $status = $e->getHttpStatus();
                $status_code = $e->getError()->code;
                $message = $e->getError()->message.' Type is:' . $e->getError()->type;
          } catch (\Stripe\Exception\ApiErrorException $e) {
                // Display a very generic error to the user, and maybe send
                // yourself an email
                $status = $e->getHttpStatus();
                $status_code = $e->getError()->code;
                $message = $e->getError()->message.' Type is:' . $e->getError()->type;
          } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
          }

        return common_response( $message, $status, $status_code, $responseData );

    }

}
