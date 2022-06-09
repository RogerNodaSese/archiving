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

    // public $accession;
    public $authors = [];
    public $title;
    public $month;
    public $months = [];
    // public $day;
    // public $days = [];
    public $year;
    public $years = [];
    public $publisher;
    public $publication;
    public $college;
    public $colleges;
    public $programs = [];
    public $program;
    public $subject;
    // public $keyword;
    public $citation;
    public $abstract;
    public $file;
    // private $keyId;
    private $subId;
    private $titleSlug;
    private $data_path;

    protected function rules(){ 
        return [
        'authors.*.lastname'    => 'required|regex:/^[a-zA-Z\s]*$/',
        'authors.*.firstname'   => 'required|regex:/^[a-zA-Z\s]*$/',
        'title'                 => 'required|unique:theses',
        'month'                 => 'required',
        'year'                  => 'required',
        'college'               => 'required',
        'program'               => 'required',
        'subject'               => 'required',
        'citation'              => ['required'],
        'abstract'              => ['required'],
        'file'                  => 'nullable|file|mimes:pdf',
        // 'accession'             => 'required|numeric|unique:theses,accession_number'
        ];
    }

    protected $messages = [
        'authors.*.firstname.required'  => 'Firstname required.',
        'authors.*.lastname.required'   => 'Lastname required.',
        'regex'                         => 'Only (A-Z a-z) characters.',
        'title.required'                => 'Title required.',
        'month.required'                => 'Month required.',
        'year.required'                 => 'Year required.',
        'college.required'              => 'College required.',
        'program.required'              => 'Program required.',
        'subject.required'              => 'Subject required.',
        'abstract.required'             => 'Abstract required.',
        // 'file.min'                      => 'The file must be at least 1MB.',
        // 'file.max'                      => 'The file size exceeded to 16MB.',
        // 'accession.numeric'             => 'Field must only contain numeric value'
    ];
    public function mount()
    {
        $this->pdf = collect();
        $this->authors = [
            ['lastname' => '' , 'firstname' => '', 'middlename' => ''],
        ];
        $this->months = Date::months();
        $this->years = Date::years();
        // $this->days = Date::days();
        $this->colleges = College::select('id','description')->get();
        // $this->authorizedUser();
    }

    public function authorizedUser()
    {
        if(auth()->user()->isStaff())
        {
            $this->college = strval(User::find(auth()->user()->id)->college->id);
            $this->programs = College::find($this->college)->programs;
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

    // public function updatedMonth($month){
        // if(!empty($month)){
        //     $this->days = Date::days($month);
        // }

    //     return $this->days = (!empty($month)) ? Date::days($month) : collect([]);
    // }

    public function updatedYear($year){
        // if($this->month == 2 && ($year % 400 == 0 || $year % 4 == 0)){
        //     $this->days = collect()->range(1,29);
        // }
        $names = array_map( fn($name) => $name['lastname'] . ", ". substr($name['firstname'], 0, 1), $this->authors );

        $this->citation = implode(', ', $names). " (" . $this->year ."). " . $this->title;
    }

    public function validateUserSubmission()
    {
        if(auth()->user()->isAdministrator() && $this->college != auth()->user()->college_id)
        {
            return true;
        }
        return false;
    }

    public function updatedAuthors(){
        $names = array_map( fn($name) => $name['lastname'] . ", ". substr($name['firstname'], 0, 1), $this->authors );

        $this->citation = implode(', ', $names). " (" . $this->year ."). " . $this->title;
        
    }

    public function updatedTitle(){
        $names = array_map( fn($name) => $name['lastname'] . ", ". substr($name['firstname'], 0, 1), $this->authors );

        $this->citation = implode(', ', $names). " (" . $this->year .") " . $this->title;
    }

    public function addThesis()
    {   
        // Storage::disk('google')->makeDirectory('archives');
        // $this->file->store('','google');

        
        // if($this->validateUserSubmission())
        // {
        //     return redirect()->route('thesis.create')->with('message', 'Request Error');
        // };
        //Validate data
        

        sleep(1);
        $this->validate();
        // $this->keyId = [];
        $this->subId = [];
        // $keywords = explode(',' , $this->keyword);
        $subjects = explode(',' , $this->subject);
        $this->publication = Str::slug($this->year." ".$this->month, "-");
        DB::transaction(function () use($subjects) {
        
            $file;
            if(!is_null($this->file)){
                $this->file->storeAs(Program::find($this->program)->directory->path,Str::slug($this->title." ".$this->month." ".$this->year),'google');

            $file = File::create([
                'description' => Str::slug($this->title." ".$this->month." ".$this->year),
                'path'        => $this->fileDirectory()
            ]);

            }

        $thesis = Thesis::create([
            'title'         => $this->title,
            // 'accession_number' => $this->accession,
            'user_id'       => auth()->user()->id,
            'publisher'     => $this->publisher,
            'date_of_publication' => $this->publication,
            'citation'      => $this->citation,
            'abstract'      => $this->abstract,
            'program_id'    => $this->program,
            'file_id'       => $file->id ?? NULL,
        ]);

        // foreach($keywords as $data)
        // {
        //     $keyResult = Keyword::where('description', '=', Str::of($data)->trim())->first();
        //     if(is_null($keyResult))
        //     {
        //         $keyword = new Keyword();
        //         $keyword->description = Str::of($data)->trim();
        //         $thesis->keywords()->save($keyword);
        //         array_push($this->keyId, $keyword->id);
        //     }else
        //     {
        //         array_push($this->keyId, $keyResult->id);
        //     }
        // }

        // $thesis->keywords()->sync($this->keyId);

        foreach($this->authors as $data)
        {
            $author = new Author();
            $author->first_name = $data['firstname'];
            $author->last_name = $data['lastname'];
            $author->middle_name = $data['middlename'];
            $thesis->authors()->save($author);
        }

        foreach ($subjects as $data) {

            $subResult = Subject::where('description', '=', Str::of(Str::lower($data))->trim())->first();
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
            if(Str::is(Str::lower($data['filename']), Str::lower(Str::slug($this->title." ".$this->month." ".$this->year,'-'))))
            {
                return $data['path'];
            }
        }
    }


    public function resetForm()
    {
        
        if(auth()->user()->isAdministrator())
        {
            $this->reset(['authors','title','month','year','subject','program','citation','abstract','file']);
        }else
        {
            $this->reset(['authors','title','month','college','year','subject','program','citation','abstract','file']);
        }
        $this->authors = [
            ['lastname' => '' , 'firstname' => ''],
        ];
    }

    public function addAuthor()
    {
        $this->authors[] = ['lastname' => '' , 'firstname' => '', 'middlename' => ''];
    }

    public function removeAuthor($index)
    {
        unset($this->authors[$index]);
        $this->authors = array_values($this->authors);

        $names = array_map( fn($name) => $name['lastname'] . ", ". substr($name['firstname'], 0, 1), $this->authors );

        $this->citation = implode(', ', $names). " (" . $this->year ."). " . $this->title;
    }

    public function render()
    {
        return view('livewire.thesis-form');
    }
}
