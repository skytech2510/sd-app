<?php

namespace App\Http\Controllers;

use App\Models\UserQueue;
use App\Models\User;
use App\Models\FormCampaign;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Carbon\Carbon;
use Auth;

class UserQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $company_id = getCompany($user);

        $list = User::where('company_id', '=', $company_id)
                    ->where('status_id', '=', 1)
                    ->where('role_id','=',2)
                    ->orderBy('last_interaction','asc');

        return Inertia::render(
            'UserQueue/Index',
            [
                'users' => $list->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $count = User::where('company_id', '=', 1)->count();
        dd($count);
        
        $last_user = userQueue::where('company_id', '=', 1)->orderBy('created_at', 'desc')->limit(1)->get();

        $user = User::where('company_id', '=', 1)
                        ->whereNotIn('id', [$last_user[0]->user_id])                        
                        ->orderBy('id', 'asc')
                        ->limit(1)
                        ->get();
        
        $queue = new userQueue();
        $queue->position = 1;
        $queue->company_id = 1;
        $queue->user_id = 1;
        $queue->lead_id = 44;
        $queue->status_id = 1;  
        $queue->save();
        sleep(1);
    }

    /**
     * Display the specified resource.
     */
    public function show(userQueue $userQueue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(userQueue $userQueue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, userQueue $userQueue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(userQueue $userQueue)
    {
        //
    }


    /**
     * Queue of distribution of leads.
     */
    public function queueUsers()
    {
        $forms = FormCampaign::join('campaigns','form_campaigns.campaign_id', 'campaigns.id')
                                ->select('campaigns.id', 'form_campaigns.facebook_form_id', 'form_campaigns.product_id')
                                ->where('form_campaigns.status_id','=','1')
                                ->where('campaigns.status_id','=','1')
                                ->get();
        
        foreach($forms as $form){
            
            $leads = Lead::where('form_id','=',$form->facebook_form_id)
                            ->where('status_id','=',12) 
                            ->get();
           
            foreach($leads as $lead){                

                $users = User::join('companies', 'users.company_id', '=', 'companies.id')
                                ->select('users.id', 'users.email', 'last_interaction', 'users.company_id')
                                ->where('companies.campaign_id', '=', $form->id)
                                ->where('users.role_id', '=', 2)
                                ->where('users.status_id', '=', 1)
                                ->orderBy('last_interaction', 'asc')
                                ->limit(1)
                                ->get();

                foreach($users as $user){
                    $queue = new UserQueue();
                    $queue->company_id = $user->company_id;
                    $queue->user_id = $user->id;
                    $queue->lead_id = $lead->id;
                    $queue->status_id = 1;  
                    $queue->save();

                    $user->last_interaction = now();
                    $user->save();
                    sleep(1);
                    
                    $lead->company_id = $user->company_id;
                    $lead->user_id = $user->id;
                    $lead->product_id = $form->product_id;
                    $lead->status_id = 9;
                    $lead->save();

                    Mail::to($user->email)
                          ->send(new NotificationMail());                    
                }
            }
        }
    }
}
