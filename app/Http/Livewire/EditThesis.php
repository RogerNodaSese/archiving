<?php

namespace App\Http\Livewire;

use Livewire\Component;
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
use Illuminate\Support\Facades\DB;

class EditThesis extends Component
{
    public $thesis;
    public $authors = [];
    public $title;
    public $month;
    public $months = [];
    // public $day;
    // public $days = [];
    public $year;
    public $years = [];
    public $placeOfPublication;
    public $publisher;
    public $publication;
    public $college;
    public $colleges;
    public $programs = [];
    public $program;
    public $subject;
    public $subjects = [];
    // public $keyword;
    public $citation;
    public $abstract;
    private $subId;
    private $authorId;

    protected function rules(){ 
        return [
        'authors.*.lastname'    => 'required|regex:/^[a-zA-Z\s]*$/',
        'authors.*.firstname'   => 'required|regex:/^[a-zA-Z\s]*$/',
        'title'                 => 'required|unique:theses,title,'.$this->thesis->id,
        'month'                 => 'required',
        'year'                  => 'required',
        'college'               => 'required',
        'program'               => 'required',
        'subject'               => 'required',
        'citation'              => ['required'],
        'abstract'              => ['required'],
        'placeOfPublication'    => 'required',
        'publisher'             => 'required',
        ];
    }

    protected $messages = [
        'authors.*.firstname.required'  => 'Firstname is required.',
        'authors.*.lastname.required'   => 'Lastname is required.',
        'regex'                         => 'Only (A-Z a-z) characters.',
        'title.required'                => 'Title is required.',
        'month.required'                => 'Month is required.',
        'year.required'                 => 'Year is required.',
        'college.required'              => 'College is required.',
        'program.required'              => 'Program is required.',
        'subject.required'              => 'Subject/s is required.',
        'abstract.required'             => 'Abstract is required.',
        'placeOfPublication.required'   => 'Place of Pulication is required.',
        'publisher.required'            => 'Publisher is required.',
    ];

    public function mount($thesis)
    {
        $this->thesis = $thesis;
        $this->loadAuthors();
        array_map(function($subject){
            array_push($this->subjects ,$subject["description"]);
        }, $this->thesis->subjects->toArray());
        $this->subject = implode(",",$this->subjects);
        $this->citation = $this->thesis->citation;
        $dateOfPublication = explode("-", $this->thesis->date_of_publication);
        $this->year = $dateOfPublication[0];
        $this->month = ltrim($dateOfPublication[1], "0");
        $this->publisher = $this->thesis->publisher;
        $this->placeOfPublication = $this->thesis->place_of_publication;
        $this->title = $this->thesis->title;
        $this->months = Date::months();
        $this->years = Date::years();
        $this->college = $this->thesis->program->college_id;
        $this->program = $this->thesis->program->id;
        $this->programs = College::find($this->college)->programs;
        $this->colleges = College::select('id','description')->get();
        $this->abstract = $this->thesis->abstract;
    }

    public function updatedYear($year){
        // if($this->month == 2 && ($year % 400 == 0 || $year % 4 == 0)){
        //     $this->days = collect()->range(1,29);
        // }
        $names = array_map( fn($name) => $name['lastname'] . ", ". substr($name['firstname'], 0, 1) .".", $this->authors );

        $this->citation = implode(', ', $names). " (" . $this->year ."). " . $this->title .". " .$this->placeOfPublication. ": ". $this->publisher.".";
    }

    public function updatedAuthors(){
        $names = array_map( fn($name) => $name['lastname'] . ", ". substr($name['firstname'], 0, 1) .".", $this->authors );

        $this->citation = implode(', ', $names). " (" . $this->year ."). " . $this->title.". " .$this->placeOfPublication. ": ". $this->publisher.".";
        
    }

    public function updatedTitle(){
        $names = array_map( fn($name) => $name['lastname'] . ", ". substr($name['firstname'], 0, 1) .".", $this->authors );

        $this->citation = implode(', ', $names). " (" . $this->year .") " . $this->title .". ".$this->placeOfPublication. ": ". $this->publisher.".";
    }

    public function updatedPublisher(){
        $names = array_map( fn($name) => $name['lastname'] . ", ". substr($name['firstname'], 0, 1) .".", $this->authors );

        $this->citation = implode(', ', $names). " (" . $this->year .") " . $this->title .". ".$this->placeOfPublication. ": ". $this->publisher.".";
    }

    public function updatedPlaceOfPublication(){
        $names = array_map( fn($name) => $name['lastname'] . ", ". substr($name['firstname'], 0, 1) .".", $this->authors );

        $this->citation = implode(', ', $names). " (" . $this->year .") " . $this->title .". " .$this->placeOfPublication. ": ". $this->publisher.".";
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
    public function loadAuthors()
    {
        foreach($this->thesis->authors as $author)
        {
            $this->authors[] = ['lastname' => $author->last_name , 'firstname' => $author->first_name, 'middlename' => $author->middle_name];
        }
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

    public function updateThesis()
    {
        $this->validate();

        $this->subId = [];
        $this->authorId = [];
        // $keywords = explode(',' , $this->keyword);
        $subjects = explode(',' , $this->subject);
        $this->publication = Str::slug($this->year." ".$this->month, "-");
        DB::transaction(function () use($subjects) {

        $updateThesis = Thesis::where('id', $this->thesis->id)
                                ->update([
                                    'title' => $this->title,
                                    'place_of_publication' => $this->placeOfPublication,
                                    'publisher'     => $this->publisher,
                                    'date_of_publication' => $this->publication,
                                    'citation'      => $this->citation,
                                    'abstract'      => $this->abstract,
                                    'program_id'    => $this->program,
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

            $authorResult = Author::where([
                                    ['first_name', '=', $data['firstname']],
                                    ['last_name', '=', $data['lastname']],
                                    ['middle_name', '=', $data['middlename']],
            ])->first();

            if(is_null($authorResult)){
                $author = new Author();
                $author->first_name = $data['firstname'];
                $author->last_name = $data['lastname'];
                $author->middle_name = $data['middlename'];
                $this->thesis->authors()->save($author);
                array_push($this->authorId, $author->id);
            }else{
                array_push($this->authorId, $authorResult->id);
            }
        }
        $this->thesis->authors()->sync($this->authorId);
        Author::doesntHave('theses')->delete();
        foreach ($subjects as $data) {

            $subResult = Subject::where('description', '=', Str::of(Str::lower($data))->trim())->first();
            if(is_null($subResult))
            {
                $subject = new Subject();
                $subject->description = Str::of($data)->trim();
                $this->thesis->subjects()->save($subject);
                array_push($this->subId, $subject->id);
            }else
            {
                array_push($this->subId, $subResult->id);
            }
        }
        $this->thesis->subjects()->sync($this->subId);
        Subject::doesntHave('theses')->delete();
        },3);

        // $thesis->publisher = "HEY";

        // $thesis->save();

        // dd($thesis->publisher);
        // session()->flash('message', 'Created successfully!');
        // // $this->resetForm();
        // return redirect()->route('thesis.create');
        $this->dispatchBrowserEvent('toastr:created', [
            'icon' => 'success',
            'title' => 'Updated Successfully!',
        ]);
    }

    public function render()
    {
        return view('livewire.edit-thesis');
    }
}
