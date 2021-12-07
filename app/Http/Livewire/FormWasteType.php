<?php

namespace App\Http\Livewire;

use App\Models\WasteType;
use Livewire\Component;

class FormWasteType extends Component
{
    public $data;
    public $action;
    public $dataId;
    public function mount(){
        $this->data=[
            'title'=>'',
            'price'=>''
        ];
        if ($this->dataId!=null){
            $data=WasteType::find($this->dataId);
            $this->data=[
                'title'=>$data->title,
                'price'=>$data->price
            ];
        }
    }

    public function create(){
    WasteType::create($this->data);
        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => 'Berhasil menambah data',
        ]);
        $this->emit('redirect', route('admin.wasteType.index'));
    }
    public function update(){
        WasteType::find($this->dataId)->update($this->data);
        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => 'Berhasil merubah data',
        ]);
        $this->emit('redirect', route('admin.wasteType.index'));
    }

    public function render()
    {
        return view('livewire.form-waste-type');
    }
}
