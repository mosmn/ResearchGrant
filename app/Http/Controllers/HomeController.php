<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchGrant;
use App\Models\Academician;
use App\Models\Milestone;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $data = [];

        if ($user->can('admin-executive')) {
            $data = $this->getAdminData();
        } elseif ($user->can('project-leader')) {
            $data = $this->getProjectLeaderData($user);
        } elseif ($user->can('irmc-staff')) {
            $data = $this->getIrmcStaffData();
        }

        return view('home', $data);
    }

    private function getAdminData()
    {
        return [
            'totalGrants' => ResearchGrant::count(),
            'totalFunding' => ResearchGrant::sum('grant_amount'),
            'totalResearchers' => Academician::count(),
        ];
    }

    private function getProjectLeaderData($user)
    {
        return [
            'myGrants' => ResearchGrant::where('academician_id', $user->academician->id)->get(),
            'upcomingMilestones' => Milestone::whereHas('researchGrant', function($query) use ($user) {
                $query->where('academician_id', $user->academician->id);
            })->where('due_date', '>', now())
              ->orderBy('due_date')
              ->take(5)
              ->get(),
        ];
    }

    private function getIrmcStaffData()
    {
        return [
            'recentGrants' => ResearchGrant::with('projectLeader')
                ->latest()
                ->take(5)
                ->get(),
        ];
    }
}
