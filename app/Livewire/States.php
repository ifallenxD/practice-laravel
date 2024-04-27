<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\State;
use Livewire\Attributes\On;
use Livewire\Component;

class States extends Component
{

    protected $listeners = ['refreshStates' => 'render'];
    public $state;
    public $country_id;
    public $name;

    public function render()
    {
        $states = State::with('country')->get();
        $countries = Country::all();

        return view('livewire.states', [
            'states' => $states,
            'countries' => $countries,
        ]);
    }

    public function addState()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'country_id' => 'required',
        ]);

        State::create($validatedData);

        $this->resetFields();

         //event
         $this->dispatch('closeModal', 'addState');

         //toast
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => "State Added Successfully!!",
        ]);
    }

    #[On('state-deleted')]
    public function deleteState($id)
    {
            State::find($id)->delete();
           
            //toast
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "State deleted Successfully!!",
            ]);
    }


    public function resetFields()
    {
        $this->resetValidation();
        $this->name = '';
        $this->country_id = '';
    }


    public function editState(State $state)
    {
        $this->state = $state;

        $this->name = $state->name;
        $this->country_id = $state->country_id;

        $this->dispatch('openModal', 'editState');
    }

    public function updateState()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'country_id' => 'required',
        ]);

        $this->state->update($validatedData);

        $this->resetFields();

         //event
         $this->dispatch('closeModal', 'editState');

         //toast
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => "State Updated Successfully!!",
        ]);
    }
}
