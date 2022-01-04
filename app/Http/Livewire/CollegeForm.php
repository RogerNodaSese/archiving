<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\College;
use App\Models\Program;
use Illuminate\Support\Facades\DB;

class CollegeForm extends Component
{
    public $collegeName;
    public $collegeSlug;
    public $programs = [];

    protected $rules = [
        'collegeName'               => 'required|unique:colleges,description',
        'collegeSlug'               => 'required|unique:colleges,slug',
        'programs.*.description'    => 'required|unique:programs,description|distinct:strict',
    ];

    protected $messages = [
        'programs.*.description.unique'   => 'The program description has already been taken',
        'programs.*.description.required' => 'The program description field is required',
        'programs.*.description.distinct' => 'The program description field has a duplicate value'
    ];

    public function mount()
    {
        $this->programs = [
            [ 'description' => '',],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'collegeName'               => 'required|unique:colleges,description',
            'collegeSlug'               => 'required|unique:colleges,slug',
            'programs.*.description'    => 'required|unique:programs,description|distinct:strict',
        ]);
    }

    public function updatingCollegeName($value)
    {
        $this->collegeSlug = Str::slug($value, '-');
    }

    public function addCollege()
    {
        sleep(1);
        $this->validate();
        DB::transaction(function () {
            $college = College::create([
                'description' => $this->collegeName,
                'slug'        => $this->collegeSlug
            ]);

            foreach ($this->programs as $data) {
                $program = new Program();
                $program->description = $data['description'];
                $program->slug = Str::slug($data['description'], '-');
                $college->programs()->save($program);
            }
        }, 3);

        $this->resetForm();
        $this->dispatchBrowserEvent('toastr:created', [
            'icon' => 'success',
            'title' => 'Created Successfully!',
        ]);
    }

    public function addProgram()
    {
        $this->programs[] = ['description' => ''];
    }

    public function resetForm()
    {
        $this->reset();
        $this->programs = [
            ['description' => ''],
        ];
    }

    public function removeProgram($index)
    {
        unset($this->programs[$index]);
        $this->programs = array_values($this->programs);
    }

    public function render()
    {
        return view('livewire.college-form');
    }
}
