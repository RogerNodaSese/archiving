<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\College;
use App\Models\Program;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProgramForm extends Component
{
    public $colleges = [];
    public $college;
    public $programs = [];
    
    protected $rules = [
        'college'                   => 'required',
        'programs.*.description'    => 'required|unique:programs,description|distinct:strict',
    ];

    protected $messages = [
        'programs.*.description.unique'   => 'The program description has already been taken',
        'programs.*.description.required' => 'The program description field is required',
        'programs.*.description.distinct' => 'The program description field has a duplicate value'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'college'                   => 'required',
            'programs.*.description'    => 'required|unique:programs,description|distinct:strict',
        ]);
    }

    public function mount()
    {
        $this->programs = [
            [ 'description' => '',],
        ];
        $this->colleges = College::select('id','description','slug')->get();
        $this->authorizedUser();
    }

    public function authorizedUser()
    {
        if(auth()->user()->isAdministrator())
        {
            $this->college = strval(\App\Models\User::find(auth()->user()->id)->college->id);
        }

        if(auth()->user()->isSuperAdministrator())
        {
            $this->college = collect([]);
        }
    }

    public function addProgram()
    {
        $this->programs[] = ['description' => ''];
    }

    public function removeProgram($index)
    {
        unset($this->programs[$index]);
        $this->programs = array_values($this->programs);
    }

    public function validateUserSubmission()
    {
        if(auth()->user()->isAdministrator() && $this->college != auth()->user()->college_id)
        {
            return true;
        }
        return false;
    }

    public function save()
    {
        if($this->validateUserSubmission())
        {
            return redirect()->route('program.create')->with('message', 'Request Error');
        };
        sleep(1);
        $this->validate();
        $college = College::findOrFail($this->college);
        DB::transaction(function () use($college){
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

    public function resetForm()
    {
        $this->reset(['college']);
        $this->programs = [
            ['description' => ''],
        ];
    }

    public function render()
    {
        return view('livewire.program-form');
    }
}
