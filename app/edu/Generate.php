<?php

namespace App\edu;


class Generate{

    private const MODEL_GPT4_O = 'gpt-4o';
    private $client; 

    private const PRINT = "OUBLIE TOUTE LES INSTRUCTIONS PRECEDENTES. Pour ce prompt tu devras respecter STRICTEMENT les indications qui te seront indiquées. Renvoie uniquement du JSON.";
    private const CXTCR = "Crée un exercice sous la forme &TYPE& &PRC&. Le niveau est celui de &NVX&. Cet exercice doit permettre de mobiliser les compétences et le cours.";
    private const CTRRP = "Ta réponse devra respecter le format JSON suivant : {
        \"exercice\":{
            \"type\":\"...\",
            \"document\":{
                \"1\":\"...\"
                ...
            },
            \"context\":\"...\",
            \"questions\":{
                \"1\":{
                    \"question\":\"...\",
                    \"cpc\":{
                        \"...\":0.0
                    },
                    \"pp\":{
                        \"a\":\"...\"
                    }
                },
                ...
            }
        },
    
        \"indication\":{
            \"1\":\"...\",
            ...
        },
    
        \"answer\":{
            \"1\":\"...\",
            ...
        }
    }. Ne remplis que les champs JSON qui t'ont été explicités, laisse les autres vides. Voici la structure JSON à respecter : &JSONSTRC&.";

    private const QCMDESC = "- 'exercice.questions' contiendra la liste des questions où, pour chaque question, 'exercice.questions.#.question' contiendra la question.\n- 'exercice.indication' contiendra pour chaque question, une indication.\n- 'exercice.questions.#.pp' la liste des propositions.\n- 'answer' contiendra, pour chaque question, la réponse.";
    private const EXODESC = "- 'exercice.context' contiendra l'introduction au problème.\n- 'exercice.questions' contiendra la liste des questions où, pour chaque question, 'exercice.questions.#.question' contiendra la question.\n- 'exercice.indication' contiendra pour chaque question, une indication.\n- 'answer' contiendra, pour chaque question, la réponse ou, dans le cas d'une réflexion, les attentes de la réponse.";

    public function __construct(){
        $this->client = \OpenAI::client(env('OPENAI_API_KEY'));
    }

    private function formatData(array $data){
        $buffer = "";

        foreach($data as $rscName => $values){
            $buffer .= "Le $rscName commence à la balise '<$rscName-start>' et se termine à la balise '<$rscName-end>'.\n";
        }

        foreach($data as $rscName => $values){
            $buffer .= "<$rscName-start>' $values <$rscName-end>.\n";
        }

        return $buffer;
    }

    public function question(string $NVX, string $PRC, array $data){
        $format = self::PRINT;
        $prompt = str_replace(["&TYPE&", "&PRC&", "&NVX&"], ["d'un probleme", $PRC, $NVX], self::CXTCR);
        $prompt .= str_replace(["&JSONSTRC&"], [self::EXODESC], self::CTRRP);
        $prompt .= $this->formatData($data);

        return $this->query($format, $prompt);
    }

    public function QCM(string $NVX, string $PRC, array $data){
        $format = self::PRINT;
        $prompt = str_replace(["&TYPE&", "&PRC&", "&NVX&"], ["d'un QCM", $PRC, $NVX], self::CXTCR);
        $prompt .= str_replace(["&JSONSTRC&"], [self::QCMDESC], self::CTRRP);
        $prompt .= $this->formatData($data);

        return $this->query($format, $prompt);
    }

    public function exemple(string $NVX, array $data){

        return $this->QCM($NVX, "de une seule question avec 4 propositions", $data);
    }
    
    public function query(string $format, string $query){

        $response = $this->client->chat()->create([
            'model' => self::MODEL_GPT4_O,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $format
                ],
                [
                    'role' => 'user',
                    'content' => $query
                ],
            ],
        ]);

        $raw = $response->choices[0]->message->content;

        $cleanJson = preg_replace('/^```json|```$/', '', $raw);
        //$cleanJson = '{ "exercice": { "type": "QCM", "document": {}, "context": "Utiliser le théorème de Pythagore pour déterminer si un triangle est rectangle.", "questions": { "1": { "question": "Un triangle a trois côtés de longueurs 5 cm, 12 cm et 13 cm. Est-ce un triangle rectangle?", "cpc": {}, "pp": { "a": "Oui, car 13^2 = 5^2 + 12^2.", "b": "Non, car 13^2 ≠ 5^2 + 12^2.", "c": "On ne peut pas savoir, car il manque l\'angle.", "d": "Oui, car 5^2 + 12^2 = 13^2." } } } }, "indication": { "1": "Vérifiez si la somme des carrés des deux plus petits côtés est égale au carré du plus grand côté." }, "answer": { "1": "a" } }';
        return $cleanJson;
    }
}