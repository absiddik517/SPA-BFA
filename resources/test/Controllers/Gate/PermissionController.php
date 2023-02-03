<?php

namespace App\Http\Controllers\Gate;

use Exception;
use App\Models\Auth\Permission;
use Illuminate\Http\Request;
use App\Helper\Traits\Filter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Gate\Permission\StoreRequest;
use App\Http\Requests\Gate\Permission\UpdateRequest;
use App\Http\Resources\Gate\PermissionResource;

class PermissionController extends Controller
{
    use Filter;
    public function index(){
      $permissions. = PermissionResource::collection($this->getFilterData(Permission::class, [
        'like' => ["name", "guard_name", "group_name"]
      ])->withQueryString());
      $params = $this->getParams();
      return inertia('Gate/Permission', compact('permissions', 'params'));
    }
    
    public function store(StoreRequest $req){
      try{
        Permission::create($req->validated());
        $toast = [
          'message' => 'Permission has created successful!', 
          'type' => 'success'
        ];
      } catch (Exception $e) {
        $toast = [
          'message' => $e->getMessage(), 
          'type' => 'error'
        ];
      }
      return redirect()->route('gate.permission.index')->with('toast', $toast);
    }
    
    public function update($id, UpdateRequest $req){
      try{
        $permission = Permission::find($id);
        $permission->update($req->validated());
        $toast = [
          'message' => 'Permission <strong>'.$permission->name.'</strong> has updated successful!', 
          'type' => 'success'
        ];
      } catch (Exception $e) {
        $toast = [
          'message' => exception_message($e), 
          'type' => 'error'
        ];
      }
      return redirect()->back()->with('toast', $toast);
    }
    
    public function destroy($id){
      //sleep(5);
      try{
        $permission = Permission::findOrFail($id);
        $permission->delete();
        $toast = [
          'message' => 'Permission <strong>'.$permission->name.'</strong> has deleted successfull!', 
          'type' => 'success'
        ];
      }catch(\Exception $e){
        $toast = [
          'message' => exception_message($e), 
          'type' => 'error'
        ];
      }
      return redirect()->back()->with('toast', $toast);
    }
}
