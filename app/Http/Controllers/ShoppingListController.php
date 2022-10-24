<?php 

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\ShoppingList;
use DB;
 
class ShoppingListController extends Controller
{
	//get all the active tasks
	public function index(){
		//$list = DB::table("shopping_list")->whereNull('deleted_at')->orderBy('id', 'desc')->get();
		$list = ShoppingList::whereNull('deleted_at')->orderBy('id', 'desc')->get();
		return view('list', ['list'=>$list]);
	}

	//create a new task
	public function create(Request $request){
		$this->validate($request, [
			'item' => 'required|max:255'
		]);
		
		$list = new ShoppingList;
		$list->name = $request->item;
		$list->save();
		return response()->json(['status' => 'success'], 200);
	}

	//update the task
	public function update(Request $request){
		$item = ShoppingList::find($request->id);
		$item->name = $request->item;
		$item->save();
		return response()->json(['status' => 'success'], 200);
	}

	public function done(Request $request){
		$item = ShoppingList::find($request->id);
		$item->status = 1;
		$item->save();
		return response()->json(['status' => 'success'], 200);
	}	

	public function delete(Request $request){
		$item = ShoppingList::find($request->id);
		$item->delete();
		return response()->json(['status' => 'success'], 200);
	}	
}