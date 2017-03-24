<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Position\InsertPositionRequest;
use App\Helpers\Library;
use App\Models\Position;
use App\Models\Activity;
use DB;

class PositionController extends Controller
{
    protected $position;
    protected $activity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Position $position, Activity $activity)
    {
        $this->position = $position;
        $this->activity = $activity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = $this->position->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.position.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type_position = Library::getTypePosition();
        return view('admin.position.create', compact('type_position'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertPositionRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->position->name = $request->name;
            $this->position->short_name = $request->short_name;
            $this->position->type_position = $request->type_position;
            $this->position->save();
            $this->activity->insertActivities($this->position, 'insert');
            $request->session()->flash('success', trans('position.msg.insert-success'));
            DB::commit();

            return redirect()->action('Admin\PositionController@index');
        } catch(\Exception $e) {
            $request->session()->flash('fail', trans('position.msg.insert-fail'));
            DB::rollback();

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::findOrFail($id);
        $type_position = Library::getTypePosition();
        return view('admin.position.edit', compact('type_position', 'position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InsertPositionRequest $request)
    {
        DB::beginTransaction();
        try {
            $position = $this->position->findOrFail($request->positionId);
            //  dd($position);
            $position->name = $request->name;
            $position->short_name = $request->short_name;
            $position->type_position = $request->type_position;

            $position->update();

            $this->activity->insertActivities($position, 'update');
            $request->session()->flash('success', trans('position.msg.update-success'));
            DB::commit();

            return redirect()->action('Admin\PositionController@index');
        } catch(\Exception $e) {
            $request->session()->flash('fail', trans('position.msg.update-fail'));
            dd($e);
            DB::rollback();

            return redirect()->action(['Admin\PositionController@edit',  $request->positionId]);
        }
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
            $position = $this->position->findOrFail($request->positionId);
            $this->activity->insertActivities($position, 'delete');
            $position->delete();
            $request->session()->flash('success', trans('position.msg.delete-success'));
            DB::commit();

            return redirect()->action('Admin\PositionController@index');
        } catch(Exception $e) {
            $request->session()->flash('fail', trans('position.msg.delete-fail'));
            DB::rollback();

            return redirect()->action('Admin\PositionController@index');
        }
    }
}
