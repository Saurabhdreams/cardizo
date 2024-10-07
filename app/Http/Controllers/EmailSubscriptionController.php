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
        $validatedData = $request->validate([
            'email' => 'required|email|max:25|unique:email_subscriptions,email',
        ]);

        EmailSubscription::create($validatedData);

        return response()->json(['success' => true, 'message' => __('messages.placeholder.subscribed_successfully')]);
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
