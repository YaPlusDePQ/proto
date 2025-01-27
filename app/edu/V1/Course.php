<?php

namespace App\edu\V1;

use App\edu\Generate;
use Illuminate\Support\Facades\Storage;

use App\edu\V1\generated\Exercice;

class Course{

    private array $jsonContent;
    public string $name;
    private string $content;
    private string $contentRaw;
    private string $level;

    public function __construct(string $courseName){

        $this->name = $courseName;

        $path = "courses/" . $this->name . ".json";

        $this->jsonContent = Storage::disk('local')->json($path);

        if ($this->jsonContent == null) {
            throw new \Exception("File failed to open. >>> " . $path);
        }
        
        try{
            $this->content = Storage::disk('local')->get('html/'.$this->jsonContent["content"].".html");
            $this->contentRaw = $this->jsonContent["contentRaw"];
            $this->level = $this->jsonContent["level"];
        }
        catch(e){
            throw new \Exception("File cannot be read.");
        }

    }

    public function getExemple(string $name, Generate $client){
        return new Exercice($name, $client->exemple($this->level,  ["cours"=>$this->contentRaw]));
    }

    public function getExercice(string $name, Generate $client){
        if(rand(0,1)){
            return new Exercice($name, $client->question($this->level, "de 3 question", ["cours"=>$this->contentRaw]));
        }
        else{
            return new Exercice($name, $client->QCM($this->level,  "de 5 question avec 4 propositions", ["cours"=>$this->contentRaw]));
        }
    }

    public function getHtml(){
        return $this->content;
    }


}
