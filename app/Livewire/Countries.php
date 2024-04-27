<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use App\Models\Country;
use Livewire\Attributes\On;
use Livewire\Component;

class Countries extends Component
{

    public $name;
    public $code;
    public $phone_code;
    public $country;

    public function render()
    {
        $countries = Country::all();

        return view('livewire.countries', [
            'countries' => $countries,
        ]);
    }

    public function addCountry()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'code' => 'required',
            'phone_code' => 'required',
        ]);

        Country::create([
            'name' => $this->name,
            'code' => $this->code,
            'phone_code' => $this->phone_code,
        ]);

        $this->resetFields();

         //event
         $this->dispatch('closeModal', 'addCountry');

         //toast
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => "Country Added Successfully!!",
        ]);

    }

    #[On('country-deleted')]
    public function deleteCountry($id)
    {
            Country::find($id)->delete();
           
           
            //toast
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Country deleted Successfully!!",
            ]);
    }

    public function editCountry(Country $country)
    {
        $this->country = $country;

        $this->name = $country->name;
        $this->code = $country->code;
        $this->phone_code = $country->phone_code;

        $this->dispatch('openModal', 'editCountry');

    }
    
    public function updateCountry()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'code' => 'required',
            'phone_code' => 'required',
        ]);

        $this->country->update($validatedData);

        $this->resetFields();

        //event
        $this->dispatch('closeModal', 'editCountry');

        //toast
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => "Country Updated Successfully!!",
        ]);
    }
    
    public function resetFields()
    {
        $this->resetValidation();
        $this->name = '';
        $this->code = '';
        $this->phone_code = '';
    }
}
