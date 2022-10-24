@extends('layouts.app')
@section('content')
<div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
	<h3 class="heading bold">Shopping List</h3>
</div>
<div class="my-3 p-3 bg-white rounded shadow-sm">
	<form class="form-inline my-2 my-lg-0 new_item_form">
		<input class="form-control mr-sm-2 item_name" name="item_name" type="text" placeholder="Add new item" aria-label="Add new item">
		<button class="btn btn-success my-2 my-sm-0 add_item_btn" type="button" disabled>Submit</button>
		<span class="ajax_status"></span>
	</form>
</div>
<div class="my-3 p-3 bg-white rounded shadow-sm">
	<table class="ui table">
		<thead>
			<tr>
				<th class="thirteen wide">Items</th>
				<th class="three wide">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		@if(count($list) > 0)
			@foreach($list as $ls)
				<tr>
					<td>{{$ls->name}}</td>
					<td class="right aligned">
						<span class="update_status action_btns {{ $ls->status == 1 ?'minus':'check' }}" data="{{ $ls->status == 1 ?'minus':'check' }}" item="{{$ls->id}}" <?php echo $ls->status !== 1 ? 'data-toggle="tooltip" data-placement="top" title="Mark as done"': '' ?> >
							<i class="fa-solid {{ $ls->status == 1 ?'fa-minus':'fa-check' }}"></i>
						</span>
						<span class="update_item action_btns" data-toggle="modal" data-target="#exampleModal" data-id="{{ $ls->id}}" item="{{ $ls->name }}">
							<i class="fa-solid fa-pen"></i>
						</span>
						<span class="trash_item action_btns danger" item="{{$ls->id}}">
							<i class="fa-solid fa-trash"></i>
						</span>
					</td>
				</tr>
			@endforeach
		@else
			<tr><td>No items in the list</td></tr>
		@endif
		</tbody>
	</table>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form class="update_item_form">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Update</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <input class="form-control mr-sm-2 up_item_name" name="up_item_name" type="text" placeholder="Add item" aria-label="Add item">
	        <input type="hidden" class="entry_id" id="entry_id" name="entry_id" value=""/>
	      	 <div class="ajax_modal_status"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary update_item_btn" disabled>Save changes</button>
	      </div>
	    </form>
    </div>
  </div>
</div>
@endsection