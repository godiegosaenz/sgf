<?php

namespace App\Http\Controllers\configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('configuraciones.roles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Permission = Permission::all();
        return view('configuraciones.rolesCreate',compact('Permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datavalidate = $request->validate([
            'name' => 'bail|required|unique:Spatie\Permission\Models\Role,name',
        ]);

        $role = Role::create($datavalidate);
        $role->syncPermissions($request->permissions);
        return redirect('roles/'.$role->id.'/editar')->with('guardado', 'El Rol '.$role->name.' se ha registrado satisfactoriamente');
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
        $Role = Role::findById($id);
        $Permission = Permission::all();
        return view('configuraciones.rolesEdit',compact('Role','Permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Role = Role::findByName($request->name);
        $datavalidate = $request->validate([
            'name' => [
                        'bail',
                        'required',
                        Rule::unique('roles')->ignore($Role->id)
                        ]
                    ]);

        $Role->update($datavalidate);
        $Role->syncPermissions($request->permissions);
        return redirect()->route('edit.roles', ['id' => $Role->id])->with('guardado',  'El Rol '.$request->name.' y sus permisos se han actualizado satisfactoriamente');
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

    public function list(Request $r){
        $Role = Role::all();
        return Datatables($Role)
                ->addColumn('action', function ($Role) {
                    $botonesRole = '';
                    $botonesRole .= '<a href="'.route('edit.roles',$Role->id).'" class="btn btn-warning btn-sm"><i class="bi bi-check-circle-fill"></i> Editar</a> ';
                    return $botonesRole;
                })
                ->rawColumns(['action'])
                ->make(true);
    }
}
