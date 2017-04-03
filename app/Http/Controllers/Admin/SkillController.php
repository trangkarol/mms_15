<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Skill\InserSkillRequest;
use App\Helpers\Library;
use App\Models\Skill;
use App\Models\SkillUser;
use App\Models\Activity;
use DB;

class SkillController extends Controller
{
    protected $skill;
    protected $activity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Skill $skill, Activity $activity)
    {
        $this->skill = $skill;
        $this->activity = $activity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = $this->skill->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.skill.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.skill.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InserSkillRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->skill->name = $request->name;
            $this->skill->save();
            $this->activity->insertActivities($this->skill, 'insert');
            $request->session()->flash('success', trans('skill.msg.insert-success'));
            DB::commit();

            return redirect()->action('Admin\SkillController@index');
        } catch(\Exception $e) {
            $request->session()->flash('fail', trans('skill.msg.insert-fail'));
            DB::rollback();
            dd($e);

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
        $skill = Skill::findOrFail($id);
        return view('admin.skill.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InserSkillRequest $request)
    {
        DB::beginTransaction();
        try {
            $skill = $this->skill->findOrFail($request->skillId);

            $skill->name = $request->name;
            $skill->update();

            $this->activity->insertActivities($skill, 'update');
            $request->session()->flash('success', trans('skill.msg.update-success'));
            DB::commit();

            return redirect()->action('Admin\SkillController@index');
        } catch(\Exception $e) {
            $request->session()->flash('fail', trans('skill.msg.update-fail'));
            DB::rollback();

            return redirect()->action(['Admin\SkillController@edit',  $request->skillId]);
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
            $skillId = $request->skillId;
            $skill = $this->skill->findOrFail($skillId);
            SkillUser::where('skill_id', $skillId)->delete();
            $this->activity->insertActivities($skill, 'delete');
            $skill->delete();
            $request->session()->flash('success', trans('skill.msg.delete-success'));
            DB::commit();

            return redirect()->action('Admin\SkillController@index');
        } catch(Exception $e) {
            $request->session()->flash('fail', trans('skill.msg.delete-fail'));
            DB::rollback();

            return redirect()->action('Admin\SkillController@index');
        }
    }
}
