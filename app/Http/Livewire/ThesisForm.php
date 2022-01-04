<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Classes\Date;
use App\Models\College;
use App\Models\User;
use App\Models\Role;
use App\Models\Thesis;
use App\Models\Keyword;
use App\Models\Subject;
use App\Models\Author;

class ThesisForm extends Component
{
    use WithFileUploads;

    public $authors = [];
    public $title;
    public $month;
    public $months = [];
    public $day;
    public $days = [];
    public $year;
    public $years = [];
    public $college;
    public $colleges;
    public $programs = [];
    public $program;
    public $subject;
    public $keyword;
    public $abstract;
    public $file;

    protected $rules = [
        'authors.*.lastname'    => 'required',
        'authors.*.firstname'   => 'required',
        'title'                 => 'required|unique:theses',
        'day'                   => 'required',
        'month'                 => 'required',
        'year'                  => 'required',
        'college'               => 'required',
        'program'               => 'required',
        'subject'               => 'required',
        'keyword'               => 'required',
        'abstract'              => 'required',
        'file'                  => 'nullable|file|mimes:pdf'
    ];

    protected $messages = [
        'authors.*.firstname.required'  => 'Firstname required',
        'authors.*.lastname.required'   => 'Lastname required',
        'title.required'                => 'Title required',
        'day.required'                  => 'Day required',
        'month.required'                => 'Month required',
        'year.required'                 => 'Year required',
        'college.required'              => 'College required',
        'program.required'              => 'Program required',
        'subject.required'              => 'Subject required',
        'keyword.required'              => 'Keyword required',
        'abstract.required'             => 'Abstract required'
    ];
    public function mount()
    {
        $this->authors = [
            ['lastname' => '' , 'firstname' => ''],
        ];
        $this->months = Date::months();
        $this->years = Date::years();
        $this->days = Date::days();
        $this->colleges = College::select('id','description')->get();
        $this->authorizedUser();
    }

    public function authorizedUser()
    {
        if(auth()->user()->isAdministrator())
        {
            $this->college = strval(User::find(auth()->user()->id)->college->id);
            $this->programs = College::find($this->college)->programs;
        }

        if(auth()->user()->isSuperAdministrator())
        {
            $this->college = collect([]);
            $this->programs = collect([]);
        }
    }

    public function updatedCollege($college)
    {
        // if(!empty($college))
        // {
        //     return $this->programs = College::find($college)->programs;
        // }
        // return $this->programs = collect([]);
        return $this->programs = (!empty($college)) ? College::find($college)->programs : collect([]);
    }

    public function updatedMonth($month){
        // if(!empty($month)){
        //     $this->days = Date::days($month);
        // }

        return $this->days = (!empty($month)) ? Date::days($month) : collect([]);
    }

    public function updatedYear($year){
        // if($this->month == 2 && ($year % 400 == 0 || $year % 4 == 0)){
        //     $this->days = collect()->range(1,29);
        // }

        return $this->days = ($this->month == 2 && ($year % 400 == 0 || $year % 4 == 0)) ? collect()->range(1,29) : collect()->range(1,31);
    }

    public function validateUserSubmission()
    {
        if(auth()->user()->isAdministrator() && $this->college != auth()->user()->college_id)
        {
            return true;
        }
        return false;
    }

    public function addThesis()
    {    
        if($this->validateUserSubmission())
        {
            return redirect()->route('thesis.create')->with('message', 'Request Error');
        };
        //Validate data
        sleep(1);
        $this->validate();

        $keywords = explode(',' , $this->keyword);
        $subjects = explode(',' , $this->subject);

        $thesis = Thesis::create([
            'user_id'       => \Illuminate\Support\Facades\Auth::id(),
            'title'         => $this->title,
            'date_of_issue' => \Carbon\Carbon::createFromDate($this->year, $this->month, $this->day),
            'abstract'      => $this->abstract,
            'program_id'    => $this->program
        ]);

        if(auth()->user()->role_id == Role::SUPER_ADMIN ) 
        {
            $thesis->verified = true;
            $thesis->save();
        }

        foreach($keywords as $data)
        {
            $keyword = new Keyword();
            $keyword->description = Str::of($data)->trim();
            $thesis->keywords()->save($keyword);
        }

        foreach($this->authors as $data)
        {
            $author = new Author();
            $author->first_name = $data['firstname'];
            $author->last_name = $data['lastname'];
            $thesis->authors()->save($author);
        }

        foreach ($subjects as $data) {
            $subject = new Subject();
            $subject->description = Str::of($data)->trim();
            $thesis->subjects()->save($subject);
        }

        // $thesis->publisher = "HEY";

        // $thesis->save();

        // dd($thesis->publisher);
        // session()->flash('message', 'Created successfully!');
        // // $this->resetForm();
        // return redirect()->route('thesis.create');
        $this->dispatchBrowserEvent('toastr:created', [
            'icon' => 'success',
            'title' => 'Created Successfully!',
        ]);
        $this->resetForm();
        //Insert metadata to db

        //Attach the thesis to author

        //Return success message 
    }

    // public function updatedSubject($value)
    // {
    //     $slug = \Illuminate\Support\Str::slug($value, '-');

    //     $this->keyword = $slug;
    // }

    public function resetForm()
    {
        $this->reset(['authors','title','college','month','day','year','subject','program','keyword','abstract','file']);
        $this->authors = [
            ['lastname' => '' , 'firstname' => ''],
        ];
    }

    public function addAuthor()
    {
        $this->authors[] = ['lastname' => '' , 'firstname' => ''];
    }

    public function removeAuthor($index)
    {
        unset($this->authors[$index]);
        $this->authors = array_values($this->authors);
    }

    public function render()
    {
        return view('livewire.thesis-form');
    }
}
