<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepository->models()->orderBy('created_at','desc')->paginate(20);
        return view('admin.'.set_theme().'.role.index',compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.'.set_theme().'.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['name','displayName','description']);
        $input = parse_input($input);
        \Log::info('"controller.error" to listener "' . __METHOD__ . '".', ['request' => $input]);

        $rules = [
            'name' => 'required|unique:roles',
            'display_name' => 'required',
            'description' => 'max:60',
        ];

        $this->requestValidate($input,$rules,'role');

        $this->roleRepository->create($input);
        reminder()->success('角色创建成功','创建成功');
        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role =  $this->roleRepository->find($id);
        return view('admin.'.set_theme().'.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->roleRepository->find($id);

        $input = $request->only(['name','displayName','description']);
        $input = parse_input($input);
        \Log::info('"controller.error" to listener "' . __METHOD__ . '".', ['request' => $input]);

        $rules = [
            'name' => 'required|unique:roles,name,'.$id,
            'display_name' => 'required',
            'description' => 'max:60',
        ];

        $this->requestValidate($input,$rules,'role');

        $this->roleRepository->update($input,$id);
        reminder()->success('角色修改成功','修改成功');

        return  redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
