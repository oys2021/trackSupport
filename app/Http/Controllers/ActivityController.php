<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityUpdate;


class ActivityController extends Controller
{
     public function index()
    {
       $activities = Activity::with(['creator', 'updates.user'])->get();
    $users_count = \App\Models\User::count();

    return view('activities.index', compact('activities', 'users_count'));
    }



    // Show form to create a new activity
    public function create()
    {
        return view('activities.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $data['created_by'] = Auth::id();
        Activity::create($data);

        return redirect()->route('activities.index')->with('success', 'Activity created successfully!');
    }

    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    // Update activity from form submission
    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $activity->update($data);

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully!');
    }


    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully!');
    }


    public function show(Activity $activity)
    {
        $activity->load('updates.user');
        return view('activities.show', compact('activity'));
    }



        public function showDailyView(Request $request){
            $date = $request->date ?? now()->format('Y-m-d');

        $updates = ActivityUpdate::with('activity', 'user')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('activities.daily', [
            'updates' => $updates,
            'date' => $date,
        ]);
        }



   public function showReport(Request $request)
{
    $query = ActivityUpdate::with(['activity', 'user']);


    $start_date = $request->start_date ?? now()->subDays(7)->format('Y-m-d');
    $end_date = $request->end_date ?? now()->format('Y-m-d');


    if ($start_date && $end_date) {
        $query->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
    }

    $updates = $query->orderBy('created_at', 'desc')->get();

    
    $activities = Activity::with(['updates' => function($q) use ($start_date, $end_date) {
            $q->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
              ->orderBy('created_at', 'desc');
        }, 'updates.user', 'creator'])
        ->whereHas('updates', function($q) use ($start_date, $end_date) {
            $q->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        })
        ->get();

    return view('activities.report', [
        'activities' => $activities,
        'updates' => $updates,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'total_updates' => $updates->count(),
        'completed_updates' => $updates->where('status', 'done')->count(),
        'pending_updates' => $updates->where('status', 'pending')->count(),
    ]);
}


}
