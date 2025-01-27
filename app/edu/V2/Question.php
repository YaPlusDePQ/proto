<?php

namespace App\edu\V2;

use App\edu\Generate;

class Question{

    public string $text;
    public string $answer;
    public string $currentAnswer;
    public string $comment;
    public int $note;
    
    public function __construct(array $data){

        $this->text = $data["text"];
        $this->answer = $data["answer"];
        $this->currentAnswer = "";
        $this->comment = "";
        $this->note = -1;
    }

    public function correct(Generate $client, string $level, string $context, string $givenAnswers){

        $this->currentAnswer = $givenAnswers;

        $prompt = "Tu t'adresses à un élève de $level. Voici l'énoncé de l'exercice : \"$context\". La question était : \"$this->text\". La réponse attendue était : \"$this->answer\" J'ai répondu : \"$this->currentAnswer\" Les réponses sont-elles équivalentes ? . Pour ta reponse tu repondera sous la forme d'un JSON avec \"note\" qui contiendra la note sur 10,  \"cmt\": un commentaire donnant une indication précise sur la position de l'erreur. Ce commentaire ne dois pas contenir de correction.";

        // $jsonSchema = [
        //     "name"=> "correction",
        //     "description" => "rapport de correction",
        //     "strict" => true,
        //     "schema" => [
        //         "type" => "object",
        //         "properties" => [
        //             "note"=> [
        //                 "type"=> "number",
        //                 "description"=> "Note sur 10 de la reponse par rapport a celle attendu"
        //             ],
        //             "cmt"=> [
        //                 "type"=> ["string"],
        //                 "description"=> "un commentaire donnant des indications concises sur comment améliorer la réponse et une indication précise sur la position de l'erreur. Ce commentaire ne doit pas contenir de correction."
        //             ]
        //         ],
        //         "additionalProperties"=> false,
        //         "required"=> [
        //             "note", "cmt"
        //         ]
        //     ]
        // ];

        $response = json_decode($client->query("", $prompt), true);

        $this->note = $response["note"];

        $this->comment =  $response["cmt"];
    }

    public function getHTML(string $name, bool $lock){

        $buffer = "";

        if($lock){
            $buffer .= "<div class='question'>";
            
            //question start

            $buffer .= "<p class='question-question'> $this->text </p>";

            if($this->note != -1){
                $buffer .= "<div class='question-answer'>
                    <p class='question-correction' style='color:". ($this->note == 10 ? 'green' : 'orange') .";'>$this->comment</p>
                </div>";

                $buffer .= "<div class='question-pp'>
                    <p>$this->currentAnswer</p>
                </div>";
            }

            //question end

            $buffer .= "</div>";
        }
        else {
            $csrfToken = csrf_token(); 

            $buffer .= "<form class='question' method='POST'>";
            $buffer .= "<input type='hidden' name='_token' value='$csrfToken'>";
            
            $buffer .= "<input type='number' required readonly hidden name='id' value='$name'>";
    
            //question start
    
            $buffer .= "<p class='question-question'> $this->text </p>";
    
            if($this->note != -1){
                $buffer .= "<div class='question-answer'>
                    <p class='question-correction' style='color:". ($this->note == 10 ? 'green' : 'orange') .";'>$this->comment</p>
                </div>";
            }
    
            $buffer .= "<div class='question-pp'>
                <input type='text' name='answer' value='$this->currentAnswer'>
            </div>";
    
            //question end
    
            $buffer .= "<button type='submit'><span>Verifier</span><div class='spinner'></div></button>";
    
            $buffer .= "</form>";
        }

        return $buffer;
    }

}