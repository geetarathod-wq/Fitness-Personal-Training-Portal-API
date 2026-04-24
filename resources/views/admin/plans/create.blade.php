@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">➕ Create Fitness Plan</h2>

    <form method="POST" action="{{ route('admin.plans.store') }}">
        @csrf
        <div class="card p-3 mb-4">
            <div class="mb-3">
                <label>Plan Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3 position-relative">
                <label>Assign Client</label>
                <input type="text"
                       id="clientSearch"
                       class="form-control"
                       placeholder="Type client name..."
                       autocomplete="off">
                <input type="hidden" name="client_id" id="client_id">
                <div id="clientResults"
                     class="list-group position-absolute w-100"
                     style="z-index:1000; display:none;"></div>
                <div id="clientError" class="text-danger mt-1" style="display:none;">
                    Please select a client from the list
                </div>
            </div>
            <div class="mb-3">
                <label>Assigned Date</label>
                <input type="date" name="assigned_date" class="form-control" required>
            </div>
        </div>
        <div class="card p-3">
            <h5>Select Exercises</h5>
            <div id="exerciseContainer" style="max-height: 600px; overflow-y: auto;">
                @foreach($exercises as $exercise)
                <div class="border p-2 mb-3 rounded">
                    <label>
                        <input type="checkbox"
                               class="exercise-checkbox"
                               data-id="{{ $exercise->id }}"
                               name="exercises[]"
                               value="{{ $exercise->id }}">
                        <strong>{{ $exercise->name }}</strong>
                    </label>
                    <div class="row mt-2 exercise-fields d-none"
                         id="exercise-{{ $exercise->id }}">
                        <div class="col-md-4">
                            <input type="number" name="sets[{{ $exercise->id }}]" placeholder="Sets" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="reps_min[{{ $exercise->id }}]" placeholder="Min Reps" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="reps_max[{{ $exercise->id }}]" placeholder="Max Reps" class="form-control">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <button class="btn btn-success mt-4 w-100">
            💾 Save Plan
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded',function(){
const STORAGE_KEY="create_plan_form";
localStorage.removeItem(STORAGE_KEY);

function saveForm(){
let data={
name:document.querySelector('[name="name"]').value,
client_id:document.getElementById('client_id').value,
assigned_date:document.querySelector('[name="assigned_date"]').value,
exercises:[]
};

document.querySelectorAll('.exercise-checkbox:checked').forEach(cb=>{
let id=cb.value;

data.exercises.push({
id:id,
sets:document.querySelector(`[name="sets[${id}]"]`)?.value||'',
reps_min:document.querySelector(`[name="reps_min[${id}]"]`)?.value||'',
reps_max:document.querySelector(`[name="reps_max[${id}]"]`)?.value||''
});
});

localStorage.setItem(STORAGE_KEY,JSON.stringify(data));
}

function restoreForm(){
return; 
}

document.addEventListener('input',saveForm);
document.addEventListener('change',saveForm);

restoreForm();

document.querySelector('form').addEventListener('submit',function(e){

if(!document.getElementById('client_id').value){
e.preventDefault();
document.getElementById('clientError').style.display='block';
document.getElementById('clientSearch').focus();
return;
}

localStorage.removeItem(STORAGE_KEY);
});

document.querySelectorAll('.exercise-checkbox').forEach(cb=>{
cb.addEventListener('change',function(){
let id=this.dataset.id;
let section=document.getElementById('exercise-'+id);
if(this.checked){
section.classList.remove('d-none');
}else{
section.classList.add('d-none');
}
});
});

const searchInput=document.getElementById('clientSearch');
const resultsBox=document.getElementById('clientResults');
const clientIdInput=document.getElementById('client_id');
const clientError=document.getElementById('clientError');
let timer;

searchInput.addEventListener('input',function(){
clientIdInput.value='';
clientError.style.display='none';
});

searchInput.addEventListener('keyup',function(){
let query=this.value.trim();

if(!query){
resultsBox.style.display='none';
clientIdInput.value='';
return;
}

clearTimeout(timer);
timer=setTimeout(()=>{
fetch(`/admin/search-clients?search=${query}`)
.then(res=>res.json())
.then(data=>{

resultsBox.innerHTML='';
if(data.length===0){
resultsBox.innerHTML='<div class="list-group-item">No clients found</div>';
resultsBox.style.display='block';
return;
}

data.forEach(client=>{
let div=document.createElement('div');
div.className='list-group-item list-group-item-action';
div.style.cursor="pointer";

div.innerHTML=`<b>${client.name}</b><br><small>${client.email}</small>`;
div.onclick=()=>{
searchInput.value=client.name;
clientIdInput.value=client.id;
clientError.style.display='none';
resultsBox.style.display='none';
};

resultsBox.appendChild(div);
});

resultsBox.style.display='block';

});

},300);
});

document.addEventListener('click',function(e){
if(!searchInput.contains(e.target)){
resultsBox.style.display='none';
}
});

});
</script>

@endsection