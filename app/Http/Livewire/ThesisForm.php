<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use App\Rules\WordCount;
use Illuminate\Support\Str;
use App\Classes\Date;
use App\Models\College;
use App\Models\User;
use App\Models\Role;
use App\Models\Thesis;
use App\Models\Keyword;
use App\Models\Subject;
use App\Models\Author;
use App\Models\Program;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    public $citation;
    public $abstract;
    public $file;
    private $keyId;
    private $subId;
    private $titleSlug;
    private $data_path;

    protected function rules(){ 
        return [
        'authors.*.lastname'    => 'required|regex:/^[a-zA-Z\s]*$/',
        'authors.*.firstname'   => 'required|regex:/^[a-zA-Z\s]*$/',
        'title'                 => 'required|unique:theses',
        'day'                   => 'required',
        'month'                 => 'required',
        'year'                  => 'required',
        'college'               => 'required',
        'program'               => 'required',
        'subject'               => 'required',
        'keyword'               => 'required',
        'citation'              => ['required', new WordCount(15)],
        'abstract'              => ['required', new WordCount(150)],
        'file'                  => 'required|file|mimes:pdf|min:1000|max:16000',
        ];
    }

    protected $messages = [
        'authors.*.firstname.required'  => 'Firstname required.',
        'authors.*.lastname.required'   => 'Lastname required.',
        'regex'                         => 'Only (A-Z a-z) characters.',
        'title.required'                => 'Title required.',
        'day.required'                  => 'Day required.',
        'month.required'                => 'Month required.',
        'year.required'                 => 'Year required.',
        'college.required'              => 'College required.',
        'program.required'              => 'Program required.',
        'subject.required'              => 'Subject required.',
        'keyword.required'              => 'Keyword required.',
        'abstract.required'             => 'Abstract required.',
        'file.min'                      => 'The file must be at least 1MB.',
        'file.max'                      => 'The file size exceeded to 16MB.'
    ];
    public function mount()
    {
        $this->pdf = collect();
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
        // Storage::disk('google')->makeDirectory('archives');
        // $this->file->store('','google');
        if($this->validateUserSubmission())
        {
            return redirect()->route('thesis.create')->with('message', 'Request Error');
        };
        //Validate data
        

        sleep(1);
        $this->validate();
        $this->keyId = [];
        $this->subId = [];
        $keywords = explode(',' , $this->keyword);
        $subjects = explode(',' , $this->subject);
        
        
        DB::transaction(function () use($keywords, $subjects) {
        
        $this->file->storeAs(Program::find($this->program)->directory->path,Str::slug($this->title." ".$this->day." ".$this->month." ".$this->year),'google');

        $file = File::create([
            'description' => Str::slug($this->title." ".$this->day." ".$this->month." ".$this->year),
            'path'        => $this->fileDirectory()
        ]);

        $thesis = Thesis::create([
            'user_id'       => \Illuminate\Support\Facades\Auth::id(),
            'title'         => $this->title,
            'date_of_issue' => \Carbon\Carbon::createFromDate($this->year, $this->month, $this->day),
            'citation'      => $this->citation,
            'abstract'      => $this->abstract,
            'program_id'    => $this->program,
            'file_id'       => $file->id,
        ]);

       
        
        if(auth()->user()->role_id == Role::SUPER_ADMIN ) 
        {
            $thesis->verified = true;
            $thesis->save();
        }

        foreach($keywords as $data)
        {
            $keyResult = Keyword::where('description', '=', Str::of($data)->trim())->first();
            if(is_null($keyResult))
            {
                $keyword = new Keyword();
                $keyword->description = Str::of($data)->trim();
                $thesis->keywords()->save($keyword);
                array_push($this->keyId, $keyword->id);
            }else
            {
                array_push($this->keyId, $keyResult->id);
            }
        }

        $thesis->keywords()->sync($this->keyId);

        foreach($this->authors as $data)
        {
            $author = new Author();
            $author->first_name = $data['firstname'];
            $author->last_name = $data['lastname'];
            $thesis->authors()->save($author);
        }

        foreach ($subjects as $data) {

            $subResult = Subject::where('description', '=', Str::of($data)->trim())->first();
            if(is_null($subResult))
            {
                $subject = new Subject();
                $subject->description = Str::of($data)->trim();
                $thesis->subjects()->save($subject);
                array_push($this->subId, $subject->id);
            }else
            {
                array_push($this->subId, $subResult->id);
            }
        }
        $thesis->subjects()->sync($this->subId);
        },3);

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

    private function fileDirectory()
    {
        $storage = Storage::disk('google');
        $files = $storage->files(Program::find($this->program)->directory->path);
        foreach($files as $file)
        {
            $data = $storage->getAdapter()->getMetadata($file);
            if(Str::is(Str::lower($data['filename']), Str::lower(Str::slug($this->title." ".$this->day." ".$this->month." ".$this->year,'-'))))
            {
                return $data['path'];
            }
        }
    }


    public function resetForm()
    {
        
        if(auth()->user()->isAdministrator())
        {
            $this->reset(['authors','title','month','day','year','subject','program','keyword','citation','abstract','file']);
        }else
        {
            $this->reset(['authors','title','month','college','day','year','subject','program','citation','keyword','abstract','file']);
        }
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
