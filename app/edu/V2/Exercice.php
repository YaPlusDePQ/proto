<?php

namespace App\edu\V2;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\edu\V2\Question;
use App\edu\Generate;


class Exercice{

    public string $context;
    public string $name;
    public string $level;
    public array $questions;

    public array $jsonContent;

    
    public function __construct(string $exercicesName){

        $this->name = $exercicesName;

        $path = "exercices/" . $this->name . ".json";

        $this->jsonContent = Storage::disk('local')->json($path);

        if ($this->jsonContent == null) {
            throw new \Exception("File failed to open. >>> " . $path);
        }
        
        try{
            $this->context = $this->jsonContent["context"];
            $this->level = $this->jsonContent["level"];
        }
        catch(e){
            throw new \Exception("File cannot be read.");
        }

        try{
            $this->questions = [];

            foreach($this->jsonContent["questions"] as $data){
                array_push($this->questions, new Question($data));

            }
        }
        catch(e){
            throw new \Exception("Question load failed");
        }

    }

    public function getHTML(){

        $csrfToken = csrf_token(); 
        $lockFlag = false;

        $buffer = "";

        $buffer .= "<div class='exercice-context'> $this->context </div>";

        foreach($this->questions as $n => $q){
            if($q->note != 10 && !$lockFlag){
                $buffer .= $q->getHTML($n, false);
                $lockFlag = true;
            }
            else{
                $buffer .= $q->getHTML($n, true);
            }
        }

        return $buffer;
    }

    public function correct(Generate $client, Request $request){
        $this->questions[$request->id]->correct($client, $this->level, $this->context, $request->answer ?? "" );
        
    }


}