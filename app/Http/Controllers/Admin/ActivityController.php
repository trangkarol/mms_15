<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use DB;

class ActivityController extends Controller
{
    protected $activity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = $this->activity->with('user', 'activitiable')->paginate(15);

        return view('admin.activity.index', compact('activities'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $activity = $this->activity->findOrFail($request->activityId);
            $activity->delete();
            $request->session()->flash('success', trans('activity.msg.delete-success'));
            DB::commit();

            return redirect()->action('Admin\ActivityController@index');
        } catch(Exception $e) {
            $request->session()->flash('fail', trans('activity.msg.delete-fail'));
            DB::rollback();

            return redirect()->action('Admin\ActivityController@index');
        }
    }
}
