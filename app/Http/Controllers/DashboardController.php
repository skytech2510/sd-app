<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadSchedule;
use App\Models\Proposal;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\FunnelStep;
use App\Models\FormCampaign;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $dashboard = [];
        $label = [];
        $data = [];

        if ($request->has('date')) {
            $dates = $request->date;
            $startDate = date('Y-m-d 00:00:00',strtotime($request->date[0]));
            $endDate = date('Y-m-d 23:59:59',strtotime($request->date[1]));
            $dates[] = [$startDate, $endDate];

            $request->session()->put('dashboard.dates', $dates);
        }else{
            if($request->session()->has('dashboard.dates')){
                $dates = $request->session()->pull('dashboard.dates');
                $request->session()->put('dashboard.dates', $dates);
            }else{
                $startDate = now()->startOfMonth();
                $startDate = date('Y-m-d 00:00:00',strtotime($startDate));

                $endDate = now()->endOfDay();
                $endDate = date('Y-m-d 23:59:59',strtotime($endDate));

                $dates = [$startDate, $endDate];
            }
        }

        if(($user->role_id == 1)){ //ADM
            $dashboard = $this->getAdminDash($dates, $request);

        }elseif($user->role_id == 2){ //CONSULTOR

            $dashboard = $this->getUserDash($dates, $request);

        }elseif($user->role_id == 3){ //MKT

            $dashboard = $this->getAdminDash($dates, $request);
        }

        $companies = Company::select('id as value', 'name as label')->where('status_id', '=', 1)->orderBy('name')->get();

        $filters = array(
            'date' => $dates,
            'companies' => $request->companies,
            'users' => $request->users,
        );
        // return Inertia::render(
        //     'Dashboard',
        //     [
        //         'dashboard' => $dashboard,
        //         'filters' => $filters,
        //         'companies' => $companies,
        //     ]
        // );
                return Inertia::render('Dashboard', ['dashboard' => $dashboard, 'filters' => $filters, 'companies' => $companies]);
    }

    public function getUserDash($dates, $request){

        $user = Auth::user();
        $daysInMonth = now()->daysInMonth;

        $leads = Lead::where("user_id","=",$user->id)
                       ->whereBetween ('created_at', $dates );
        $total = $leads->whereNotIn("status_id", [3, 12])->count();

        $leads = Lead::where("user_id","=",$user->id)
                       ->whereBetween ('created_at', $dates );
        $inprogress = $leads->where("status_id", "<>", 3)->count();

        $leads = Lead::where("user_id","=",$user->id)
                       ->whereBetween ('created_at', $dates );
        $pendings = $leads->where("status_id", "=", 10)->count();

        $leads = Lead::where("user_id","=",$user->id)
                       ->whereBetween ('created_at', $dates );
        $waiting = $leads->where("status_id", "=", 9)->orderBy('created_at')->get();


        //AGENDAMENTOS
        $schedules = Lead::where("user_id", "=",  $user->id)
                    ->where("status_id", "=", 7)
                    ->whereBetween ('schedule_date', [now()->startOfweek(), now()->endOfWeek()] )
                    ->orderBy('schedule_date')
                    ->get();

        //PROPOSTAS NO MÊS
        $proposal = Proposal::where("user_id","=",$user->id)
                               ->whereBetween ('created_at', $dates );

        $proposals = $proposal->whereNotIn('status_id',[3])->count();
        $dealsOpenTotal = $proposal->whereIn("proposals.status_id", [4,11,13])->sum('price');

        //FECHAMENTOS NO MÊS
        $deal = Proposal::where("user_id","=",$user->id)
                           ->whereBetween ('created_at', $dates);

        $deals =  $deal->where("status_id", "=", 11)->count();
        $dealsTotal = $deal->whereIn("proposals.status_id", [11,13])->sum('price');

        //APROPRIADOS NO MÊS
        $appropriated = Proposal::where("user_id","=",$user->id)
                                ->whereBetween ('created_at', $dates )
                                ->whereIn('status_id',[13])
                                ->count();

        $dealsAppropriated = Proposal::where("user_id","=",$user->id)
                ->where("status_id", "=", 13)
                ->whereBetween ('created_at', $dates )
                ->sum('price');

        $start = Carbon::parse($dates[0]);
        $end = Carbon::parse($dates[1]);
        $days_count = $start->diffInDays($end);

        if($days_count <= 31){
            $month =  $start->month;
            $year = $start->year;
            $daysInMonth = Carbon::parse($dates[0])->daysInMonth;
        }else{
            $month =  $end->month;
            $year = $end->year;
            $daysInMonth = Carbon::parse($dates[1])->daysInMonth;
        }

        for($i = 1; $i <= $daysInMonth; $i++) {

            $label[] = $i;
            $dataChart = Lead::selectRaw("COUNT(*) views, DATE_FORMAT(created_at, '%Y %m %e') date")
                        ->whereDay('created_at', $i )
                        ->where("user_id","=",$user->id)
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->whereNotIn("status_id", [3,12])
                        ->whereNotIn("company_id", ['NULL'])
                        ->groupBy('date');

            $count = $dataChart->get();

            if(count($count) > 0)
                $data[] = $count[0]->views;
            else
                $data[] = 0;
        }

        $chartLeads[] = [
            'labels' => $label,
            'datasets' => $data,
        ];

        $label = [];
        $data = [];

        for($i = 1; $i <= 30; $i++) {
            $label[] = $i;

            $dataChart = Proposal::join('users','user_id','users.id')
                    ->selectRaw("COUNT(*) views, DATE_FORMAT(approved_at, '%Y %m %e') date")
                    ->where("user_id","=",$user->id)
                    ->whereDay('approved_at', $i )
                    ->whereMonth('approved_at', $month )
                    ->whereYear('approved_at', $year )
                    ->where("proposals.status_id", "=", 11)
                    ->groupBy('date');

            $count = $dataChart->get();

            if(count($count) > 0)
                $data[] = $count[0]->views;
            else
                $data[] = 0;
        }

        $chartDeals[] = [
            'labels' => $label,
            'datasets' => $data,
        ];

        $funnels  = $this->getFunnel($dates, $request, 2, 0);

        $dashboard[] = [
            'schedules' => $schedules,
            'waiting' => $waiting ,
            'total' => $total,
            'inprogress' => $inprogress,
            'pendings' => $pendings,
            'proposals' => $proposals,
            'deals' => $deals,
            'dealsTotal' => $dealsTotal,
            'dealsOpenTotal' => $dealsOpenTotal,
            'appropriated ' => $appropriated,
            'dealsAppropriated' => $dealsAppropriated,
            'chartLeads' => $chartLeads,
            'chartDeals' => $chartDeals,
            'funnels' => $funnels,
            'users' => 0,
           ];

        return $dashboard;
    }

    public function getAdminDash($dates, $request){

        $users = 0;
        $user = Auth::user();
        $company_id = getCompany($user);

        //ATENDIMENTOS NO MÊS
        $leads = Lead::select('id')
                        ->whereBetween ('created_at', $dates );

        if ($request->has('companies')) {
            $leads->whereIn('leads.company_id', $request->companies);

            if ($request->has('users')) {
                $leads->whereIn('leads.user_id', $request->users);
            }
        }else{
            $leads->where('leads.company_id', '=', $company_id);
        }

        $total = $leads->whereNotIn("status_id", [3, 12])->count();


        //PENDENTES
        $leads = Lead::select('id')
                ->whereBetween ('created_at', $dates );

        if ($request->has('companies')) {
            $leads->whereIn('leads.company_id', $request->companies);
        if ($request->has('users')) {
            $leads->whereIn('leads.user_id', $request->users);        }
        }else{
            $leads->where('leads.company_id', '=', $company_id);
        }

        $pendings = $leads->where("status_id", "=", 9)->count();

        //EM PROGRESSO
        $leads = Lead::select('id')
                ->whereBetween ('created_at', $dates );

        if ($request->has('companies')) {
            $leads->whereIn('leads.company_id', $request->companies);
        if ($request->has('users')) {
            $leads->whereIn('leads.user_id', $request->users);        }
        }else{
            $leads->where('leads.company_id', '=', $company_id);
        }

        $inprogress = $leads->where("funnel_step_id", "=", 2)->count();


        //PROPOSTAS
        $proposals = Proposal::join('users','user_id','users.id')
                            ->whereNotIn('proposals.status_id',[3])
                            ->whereBetween ('proposals.created_at', $dates )
                            ->select('proposals.id');

        if ($request->has('companies')) {
            $proposals->whereIn('users.company_id', $request->companies);

            if ($request->has('users')) {
                $proposals->whereIn('proposals.user_id', $request->users);
            }
        }else{
            $proposals->where('proposals.company_id', '=', $company_id);
        }

        //TOTAL DE PROPOSTAS NO MÊS
        $proposalsCount = $proposals->count();
        $dealsOpenTotal = $proposals->sum('price');

        //FECHAMENTOS NO MÊS
        $deals = $proposals->whereIn("proposals.status_id", [11,13])->count();
        $dealsTotal = $proposals->whereIn("proposals.status_id", [11,13])->sum('price');

        //APROPRIADOS NO MÊS
        $appropriated = $proposals->whereIn("proposals.status_id", [13])->count();
        $dealsAppropriated = $proposals->whereIn("proposals.status_id", [13])->sum('price');

        $start = Carbon::parse($dates[0]);
        $end = Carbon::parse($dates[1]);
        $days_count = $start->diffInDays($end);

        if($days_count <= 31){
            $month =  $start->month;
            $year = $start->year;
            $daysInMonth = Carbon::parse($dates[0])->daysInMonth;
        }else{
            $month =  $end->month;
            $year = $end->year;
            $daysInMonth = Carbon::parse($dates[1])->daysInMonth;
        }

        for($i = 1; $i <= $daysInMonth; $i++) {

            $label[] = $i;
            $dataChart = Lead::selectRaw("COUNT(*) views, DATE_FORMAT(created_at, '%Y %m %e') date")
                        ->whereDay('created_at', $i )
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->whereNotIn("status_id", [3,12])
                        ->whereNotIn("company_id", ['NULL'])
                        ->groupBy('date');

            if ($request->has('companies')) {
                $dataChart->whereIn('company_id', $request->companies);

                if ($request->has('users')) {
                    $dataChart->whereIn('leads.user_id', $request->users);
                }
            }else{
                $dataChart->where('leads.company_id', '=', $company_id);
            }

            $count = $dataChart->get();

            if(count($count) > 0)
                $data[] = $count[0]->views;
            else
                $data[] = 0;
        }

        $chartLeads[] = [
            'labels' => $label,
            'datasets' => $data,
        ];

        $label = [];
        $data = [];

        for($i = 1; $i <= 30; $i++) {
            $label[] = $i;

            $dataChart = Proposal::join('users','user_id','users.id')
                    ->selectRaw("COUNT(*) views, DATE_FORMAT(approved_at, '%Y %m %e') date")
                    ->whereDay('approved_at', $i )
                    ->whereMonth('approved_at', $month )
                    ->whereYear('approved_at', $year )
                    ->whereIn("proposals.status_id", [11,13])
                    ->groupBy('date');

            if($request->has('companies')){
                $dataChart->whereIn('users.company_id', $request->companies);

                if ($request->has('users')) {
                    $dataChart->whereIn('proposals.user_id', $request->users);
                }

            }else{
                $dataChart->where('proposals.company_id', '=', $company_id);
            }

            $count = $dataChart->get();

            if(count($count) > 0)
                $data[] = $count[0]->views;
            else
                $data[] = 0;
        }

        $chartDeals[] = [
            'labels' => $label,
            'datasets' => $data,
        ];

        $ranking = $this->getUserRanking($dates, $request, $company_id);
        $forms = $this->getFormRanking($dates, $request, $company_id);
        $waiting = $this->getWaitingLeads($dates, $request, $company_id);
        $funnels  = $this->getFunnel($dates, $request, 1, $company_id);

        if ($request->has('companies')) {
            $users = User::select('id as value', 'name as label')->whereIn('company_id', $request->companies)->whereNotIn('status_id', [3])->orderBy('name')->get();
        }

        $dashboard[] = [
            'total' => $total,
            'inprogress' => $inprogress,
            'pendings' => $pendings,
            'proposals' => $proposalsCount,
            'deals' => $deals,
            'dealsTotal' => $dealsTotal,
            'dealsOpenTotal' => $dealsOpenTotal,
            'appropriated' => $appropriated,
            'dealsAppropriated' => $dealsAppropriated,
            'chartLeads' => $chartLeads,
            'chartDeals' => $chartDeals,
            'ranking' => $ranking,
            'forms' => $forms,
            'waiting' => $waiting,
            'users' => $users,
            'funnels' => $funnels,
        ];

        return $dashboard;
    }

    public function getUserRanking($dates, $request, $company_id){

        $ranking = [];

        $users = User::join('leads','users.id','leads.user_id')
                    ->join('companies','users.company_id', 'companies.id')
                    ->select("users.id")
                    ->where('users.status_id','<>','3')
                    ->where('companies.status_id','<>','2')
                    ->groupBy('users.id');

        if($request->has('companies')){
            $users->whereIn('users.company_id', $request->companies);

            if($request->has('users')){
                $users->whereIn('users.id', $request->users);
            }
        }else{
            $users->where('users.company_id', '=', $company_id);
        }

        $users = $users->get();

        foreach($users as $user){

            $data = User::select('id','name')->where('id','=',$user->id)->get();

            $leads = Lead::where("user_id","=",$user->id)
                        ->where("status_id", "<>", 3)
                        ->whereBetween ('created_at', $dates );

            $total = $leads->count();
            $inprogress = $leads->where("funnel_step_id", "=", 2)->count();

            $proposals = Proposal::where("user_id","=",$user->id)
                            ->whereBetween ('created_at', $dates )
                            ->whereNotIn('status_id',[3])
                            ->count();

            $deals = Proposal::where("user_id","=",$user->id)
                            ->where("status_id", "=", 11)
                            ->whereBetween ('created_at', $dates )
                            ->count();

            $dealsTotal = Proposal::where("user_id","=",$user->id)
                            ->whereIn("status_id", [11,13])
                            ->whereBetween ('created_at', $dates )
                            ->sum('price');

            $dealsOpenTotal = Proposal::where("user_id","=",$user->id)
                            ->whereIn("status_id", [4,11])
                            ->whereBetween ('created_at', $dates )
                            ->sum('price');

            $ranking[] = [
                'user' => $data,
                'total' => $total,
                'inprogress' => $inprogress,
                'proposals' => $proposals,
                'deals' => $deals,
                'dealsTotal' => $dealsTotal,
                'dealsOpenTotal' => $dealsOpenTotal,
            ];
        }

        return $ranking;
    }

    public function getWaitingLeads($dates, $request, $company_id){

        $ranking = [];
        $user = Auth::user();

        $users = User::join('leads','users.id','leads.user_id')
                    ->join('companies','users.company_id', 'companies.id')
                    ->select("users.id")
                    ->where('users.status_id','<>','3')
                    ->where('companies.status_id','<>','2')
                    ->groupBy('users.id');

        if($request->has('companies')){
            $users->whereIn('users.company_id', $request->companies);

            if($request->has('users')){
                $users->whereIn('users.id', $request->users);
            }
        }else{
            $users->where('users.company_id', '=', $company_id);
        }

        $users = $users->get();

        foreach($users as $user){

            $data = Lead::join('users','leads.user_id','users.id')
                            ->select('users.id','users.name','leads.created_at as last_interaction')
                            ->where("user_id","=",$user->id)
                            ->where("leads.status_id", "=", 9)
                            ->orderBy('leads.created_at', 'asc')
                            ->limit(1)
                            ->get();


            $total = Lead::where("user_id","=",$user->id)
                        ->where("status_id", "=", 9)
                        ->whereBetween ('created_at', $dates )
                        ->count();

            if($total > 0){
                $ranking[] = [
                    'user' => $data,
                    'total' => $total,
                ];
            }
        }

        return $ranking;
    }

    public function getFormRanking($dates, $request, $company_id){

        $ranking = [];

        $forms = FormCampaign::where('status_id','=',1)->orderBy('id')->get();

        foreach($forms as $form){

            $leads = Lead::join('companies','leads.company_id', 'companies.id')
                       ->selectRaw("leads.id")
                       ->where('leads.status_id','<>','3')
                       ->where('leads.form_id','=', $form->facebook_form_id)
                       ->whereBetween ('leads.created_at', $dates )
                       ->where('companies.status_id','<>','2');

            if($request->has('companies')){
                $leads->whereIn('leads.company_id', $request->companies);
            }else{
                $leads->where('leads.company_id', '=', $company_id);
            }

            $deals = Lead::join('companies','leads.company_id', 'companies.id')
                        ->selectRaw("leads.id")
                        ->where('leads.status_id','<>','3')
                        ->where('leads.funnel_step_id','=','4')
                        ->where('leads.form_id','=', $form->facebook_form_id)
                        ->whereBetween ('leads.created_at', $dates )
                        ->where('companies.status_id','<>','2');

            if($request->has('companies')){
                $leads->whereIn('leads.company_id', $request->companies);
            }else{
                $leads->where('leads.company_id', '=', $company_id);
            }

            if($leads->count() > 0){
                $ranking[] = [
                    'name' => $form->name,
                    'total' => $leads->count(),
                    'deals' => $deals->count(),
                ];
            }
        }

        return $ranking;
    }

    public function getFunnel($dates, $request, $type, $company_id){ //type 1 = admin 2= consultor
        $user = Auth::user();

        $steps = FunnelStep::where('status_id','=',1)->orderBy("order", "asc")->get();
        $funnels = [];

        $total = $leads = Lead::whereNotIn("leads.status_id", [3, 12])
                            ->whereBetween ('leads.created_at', $dates );

        if( $type == 1){
            if($request->has('companies')){
                $leads->whereIn('leads.company_id', $request->companies);

                if($request->has('users')){
                    $leads->whereIn('leads.user_id', $request->users);
                }
            }else{
                $leads->where('leads.company_id', '=', $company_id);
            }
        }elseif($type == 2){
            $leads->where('user_id','=',$user->id);
        }

        foreach ($steps as $step)
        {
            $leads = Lead::join('funnel_steps','leads.funnel_step_id', 'funnel_steps.id')
                        ->whereNotIn("leads.status_id", [3, 12])
                        ->whereBetween ('leads.created_at', $dates )
                        ->where('funnel_step_id','=', $step->id);

            if( $type == 1){
                if($request->has('companies')){
                    $leads->whereIn('leads.company_id', $request->companies);

                    if($request->has('users')){
                        $leads->whereIn('leads.user_id', $request->users);
                    }
                }else{
                    $leads->where('leads.company_id', '=', $company_id);
                }

            }elseif($type == 2){
                $leads->where('user_id','=',$user->id);
            }

            $funnels[] = [ 'id' => $step->id,
                        'name' => $step->name,
                        'color' => $step->color,
                        'count' => $leads->count(),
                        'total' => $total->count(),
                      ];
        }
        return $funnels;
    }
}
