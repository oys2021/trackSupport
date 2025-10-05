<?php


namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityUpdate;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class ActivityUpdateController extends Controller
{
     public function create(Activity $activity)
    {
        return view('activity_updates.create', compact('activity'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'status' => 'required|in:done,pending',
            'remark' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();
        ActivityUpdate::create($data);

        return redirect()->route('activities.show', $data['activity_id'])
                         ->with('success', 'Activity status updated!');
    }

    // Show form to edit an update
    public function edit(ActivityUpdate $activityUpdate)
    {
        return view('activity_updates.edit', compact('activityUpdate'));
    }

    // Update activity update
    public function update(Request $request, ActivityUpdate $activityUpdate)
    {
        $data = $request->validate([
            'status' => 'required|in:done,pending',
            'remark' => 'nullable|string',
        ]);

        $activityUpdate->update($data);

        return redirect()->route('activities.show', $activityUpdate->activity_id)
                         ->with('success', 'Activity status updated!');
    }

    // Delete an update
    public function destroy(ActivityUpdate $activityUpdate)
    {
        $activityUpdate->delete();
        return redirect()->route('activities.show', $activityUpdate->activity_id)
                         ->with('success', 'Activity update deleted!');
    }
}
