<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmailSubscriptionRequest;
use App\Models\EmailSubscription;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class EmailSubscriptionController extends AppBaseController
{
    /**
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('email_subscription.index');
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateEmailSubscriptionRequest $request)
    {
        try {
            // Run your backend validation, this will prevent invalid data from being inserted
            EmailSubscription::create($request->all());

            // Return success response in JSON
            return response()->json([
                'success' => true,
                'message' => __('messages.placeholder.subscribed_successfully')
            ]);
        } catch (\Exception $e) {
            // Return error response in JSON if something goes wrong
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while subscribing.'
            ], 400);
        }
    }

    /**
     * @return mixed
     */
    public function destroy(EmailSubscription $emailSubscription)
    {
        $emailSubscription->delete();

        return $this->sendSuccess('Email deleted successfully.');
    }
}
